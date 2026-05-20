<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\TrustedDeviceModel;
use DateTime;
use App\Domain\Models\TwoFactorAuthModel;
use App\Domain\Models\UserModel;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TwoFactorController extends BaseController
{

    public function __construct(
        ContainerInterface $container,
        private TwoFactorAuthModel $twoFactorModel,
        private TrustedDeviceModel $trustedDeviceModel,
        private UserModel $userModel
    ) {
        parent::__construct($container);
    }

    public function showSetup(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Query the database to check if the user already has
        //    2FA enabled. If so, set a flash error and redirect
        //    to the dashboard.

        if ($this->twoFactorModel->isEnabled(SessionManager::get('user')['user_id'])) {
            FlashMessage::error('You already have two-factor authentication enabled.');
            return $this->redirect($request, $response, '/admin/users/2fa-dashboard');
        }
        // 2. Create a QR code provider and a TwoFactorAuth instance.
        $qrProvider = new BaconQrCodeProvider(4, '#ffffff', '#000000', 'svg');
        $tfa = new TwoFactorAuth($qrProvider, 'pet-store');
        // 3. Generate a new TOTP secret.
        $secret = $tfa->createSecret();
        // 4. Store the secret in the session temporarily (not in the
        //    database yet, since the user has not verified the code).
        SessionManager::set('2fa_secret', $secret);
        // 5. Generate a QR code data URI for the authenticator app.
        $uri = $tfa->getQRCodeImageAsDataUri(SessionManager::get('user')['user_email'], SessionManager::get('2fa_secret'));
        // 6. Render the setup view, passing the QR code and the secret.
        return $this->render($response, 'auth/2fa-setup.php', ['title' => 'Enable 2FA', 'qrCodeDataUri' => $uri, 'secret' => SessionManager::get('2fa_secret')]);
    }

    public function verifyAndEnable(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Retrieve the setup secret from the session. If missing,
        //    the setup session has expired: redirect to the setup page.
        $data = $request->getParsedBody();
        $code = $data['code'] ?? '';


        $secret = SessionManager::get('2fa_secret');


        if (!isset($secret) || empty($secret)) {
            return $this->redirect($request, $response, '2fa.setup');
        }
        // 2. Verify the submitted code against the session secret.
        $qrProvider = new BaconQrCodeProvider(4, '#ffffff', '#000000', 'svg');
        $tfa = new TwoFactorAuth($qrProvider, 'pet-store');
        $valid = $tfa->verifyCode($secret, $code);

        // 3. If the code is invalid, regenerate the QR code and
        //    re-render the setup page with an error message.
        if (!$valid) {
            $uri = $tfa->getQRCodeImageAsDataUri(SessionManager::get('user')['user_email'], $secret);

            return $this->render(
                $response,
                'auth/2fa-setup.php',
                [
                    'title' => 'Enable 2FA',
                    'qrCodeDataUri' => $uri,
                    'secret' => $secret,
                    'error' => 'Invalid verification code.'
                ]
            );
        }

        // 4. If the code is valid, save the secret to the database
        //    and enable 2FA for the user.
        $this->twoFactorModel->create(SessionManager::get('user')['user_id'], $secret);
        $this->twoFactorModel->enable(SessionManager::get('user')['user_id']);

        // 5. Remove the setup secret from the session.
        SessionManager::remove('2fa_secret');

        // 6. Redirect to the dashboard with a success flash message.
        FlashMessage::success('Account successfully verified.');
        return $this->redirect($request, $response, 'user.dashboard');
    }

    public function showVerify(Request $request, Response $response): Response
    {
        // TODO: Render the 2FA verification view.
        $data = [
            'title' => '2FA · Verification'
        ];

        return $this->render($response, 'auth/2fa-verify.php', $data);
    }

    public function verify(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Retrieve the user's stored TOTP secret from the database.
        $secret = $this->twoFactorModel->getSecret(SessionManager::get('user')['user_id']);
        // 2. Verify the submitted code against the stored secret.
        $form_data = $request->getParsedBody();
        $code = $form_data['code'];
        $qrProvider = new BaconQrCodeProvider(4, '#ffffff', '#000000', 'svg');
        $tfa = new TwoFactorAuth($qrProvider, 'pet-store');
        // 3. If the code is invalid, increment a failed attempts counter
        //    in the session. After 5 failed attempts, destroy the session
        //    and redirect to the login page. Otherwise, re-render the
        //    verification page with an error.
        if (!$tfa->verifyCode($secret, $code)) {
            if (SessionManager::has('failed_login_attempts')) {
                SessionManager::set('failed_login_attempts',  SessionManager::get('failed_login_attempts') + 1);
                if (SessionManager::get('failed_login_attempts') === 5) {
                    SessionManager::destroy();
                    return $this->redirect($request, $response, 'auth/login');
                } else {
                    SessionManager::set('failed_login_attempts', 1);
                }
                FlashMessage::error('Invalid code');
                return $this->redirect($request, $response, '2fa-verify');
            }
        }
        // 4. If the code is valid, mark 2FA as verified in the session.
        SessionManager::set('2fa_verified', true);

        $trustDevice = $form_data['trust_device'] ?? false;

        if ($trustDevice) {
            // Generate a secure random device token.
            $device_token = bin2hex(random_bytes(32));

            //       Calculate the expiration date (30 days from now).
            $expire_date = (new DateTime('+30 days'))->format('Y-m-d H:i:s');

            //       Build a device info array with the device name, user agent,
            //       IP address, and expiration date.
            $device_info = [
                'device_name' => $this->getDeviceName($request),
                'user_agent' => $request->getHeaderLine('User-Agent'),
                'ip_address' => $this->getClientIp($request),
                'expires_at' => $expire_date,
            ];

            //       Save the trusted device to the database.
            $this->trustedDeviceModel->create(SessionManager::get('user')['user_id'], $device_token, $device_info);

            //       Set a secure cookie named 'trusted_device' with the token,
            //       configured with httponly and samesite flags.
            setcookie(
                'trusted_device',
                $device_token,
                [
                    'expires' => strtotime($expire_date),
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Strict',
                ]
            );
        }

        // 5. Clear the attempts counter.
        SessionManager::remove('failed_login_attempts');
        // 6. Regenerate the session ID for security.
        session_regenerate_id(true);
        // 7. Redirect to the dashboard.
        // return $this->redirect($request, $response, 'admin/users/2fa-dashboard');

        if (SessionManager::get('user')['user_role'] === 'admin') {
            FlashMessage::success("Welcome " . SessionManager::get('user')['user_name']);
            return $this->redirect($request, $response, 'admin.dashboard');
        } else {
            FlashMessage::success("Welcome " . SessionManager::get('user')['user_name']);
            return $this->redirect($request, $response, 'user.dashboard');
        }
    }

    public function disable(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Retrieve the submitted password from the form data.
        $form_data = $request->getParsedBody();
        $password = $form_data['password'];
        // 2. Look up the user in the database and use password_verify()
        //    to confirm the password is correct. If invalid, re-render
        //    the disable page with an error.
        if ($this->userModel->verifyCredentials(SessionManager::get('user')['user_email'], $password) === null) {
            FlashMessage::error('Incorrect credentials');
            return $this->render($response, 'auth/2fa-disable');
        }
        // 3. Disable 2FA in the database for this user.
        $this->twoFactorModel->disable(SessionManager::get('user')['user_id']);
        // 4. Redirect to the dashboard with a success flash message.
        FlashMessage::success('You have disabled two-factor authentication');
        if (SessionManager::get('user')['user_role'] === 'admin') {
            FlashMessage::success("Welcome " . SessionManager::get('user')['user_name']);
            return $this->redirect($request, $response, 'admin/users/2fa-dashboard');
        } else {
            FlashMessage::success("Welcome " . SessionManager::get('user')['user_name']);
            return $this->redirect($request, $response, 'user.dashboard');
        }
    }

    public function showDisable(Request $request, Response $response): Response
    {
        // TODO: Render the disable confirmation view.
        $data = [
            'title' => '2FA · Disable'
        ];

        return $this->render($response, 'auth/2fa-disable.php', $data);
    }

    private function getDeviceName(Request $request): string
    {
        $userAgent = $request->getHeaderLine('User-Agent');

        if (stripos($userAgent, 'Windows') !== false) return 'Windows PC';
        if (stripos($userAgent, 'Mac') !== false) return 'Mac';
        if (stripos($userAgent, 'iPhone') !== false) return 'iPhone';
        if (stripos($userAgent, 'Android') !== false) return 'Android';
        if (stripos($userAgent, 'Linux') !== false) return 'Linux PC';

        return 'Unknown Device';
    }

    private function getClientIp(Request $request): string
    {
        $serverParams = $request->getServerParams();

        if (!empty($serverParams['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $serverParams['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]);
        }

        return $serverParams['REMOTE_ADDR'] ?? '0.0.0.0';
    }
}
