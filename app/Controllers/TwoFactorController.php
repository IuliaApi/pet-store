<?php

declare(strict_types=1);

namespace App\Controllers;

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
        // 2. Create a QR code provider and a TwoFactorAuth instance.
        // 3. Generate a new TOTP secret.
        // 4. Store the secret in the session temporarily (not in the
        //    database yet, since the user has not verified the code).
        // 5. Generate a QR code data URI for the authenticator app.
        // 6. Render the setup view, passing the QR code and the secret.
    }

    public function verifyAndEnable(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Retrieve the setup secret from the session. If missing,
        //    the setup session has expired: redirect to the setup page.
        // 2. Verify the submitted code against the session secret.
        // 3. If the code is invalid, regenerate the QR code and
        //    re-render the setup page with an error message.
        // 4. If the code is valid, save the secret to the database
        //    and enable 2FA for the user.
        // 5. Remove the setup secret from the session.
        // 6. Redirect to the dashboard with a success flash message.
    }

    public function showVerify(Request $request, Response $response): Response
    {
        // TODO: Render the 2FA verification view.
    }

    public function verify(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Retrieve the user's stored TOTP secret from the database.
        // 2. Verify the submitted code against the stored secret.
        // 3. If the code is invalid, increment a failed attempts counter
        //    in the session. After 5 failed attempts, destroy the session
        //    and redirect to the login page. Otherwise, re-render the
        //    verification page with an error.
        // 4. If the code is valid, mark 2FA as verified in the session.
        // 5. Clear the attempts counter.
        // 6. Regenerate the session ID for security.
        // 7. Redirect to the dashboard.
    }

    public function disable(Request $request, Response $response): Response
    {
        // TODO:
        // 1. Retrieve the submitted password from the form data.
        // 2. Look up the user in the database and use password_verify()
        //    to confirm the password is correct. If invalid, re-render
        //    the disable page with an error.
        // 3. Disable 2FA in the database for this user.
        // 4. Redirect to the dashboard with a success flash message.
    }

    public function showDisable(Request $request, Response $response): Response
    {
        // TODO: Render the disable confirmation view.
    }
}
