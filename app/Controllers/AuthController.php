<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use App\Controllers\BaseController;
use App\Domain\Models\UserModel;
use App\Domain\Models\TwoFactorAuthModel;
use App\Helpers\SessionManager;
use App\Middleware\SessionMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\FlashMessage;
use Exception;

class AuthController extends BaseController
{

    public function __construct(Container $container, private UserModel $userModel, private TwoFactorAuthModel $twoFactorAuthModel)
    {
        parent::__construct($container);
    }
    public function register(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Register | Create a new account',
        ];

        if (isset($_SESSION["account_info"])) {
            $data['data']['account_info'] = $_SESSION["account_info"];
            unset($_SESSION["account_info"]);
        }
        return $this->render($response, "auth/register.php", $data);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        // TODO: Extract the submitted form fields from the request
        $form_data = $request->getParsedBody();
        // TODO: Validate all fields:
        //       - All fields are required
        //       - Email must be a valid format
        //       - Email must not already be registered
        //       - Username must not already be taken
        //       - Password must be at least 8 characters and contain at least one number
        //       - Password and confirmation must match
        //       Collect any validation errors into an array.
        $return_to_form = false;
        if (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            FlashMessage::error('Enter a valid email');
            $return_to_form = true;
        }
        if ($this->userModel->emailExists($form_data['email'])) {
            FlashMessage::error('This email is already registered');
            $return_to_form = true;
        }
        if ($this->userModel->usernameExists($form_data['username'])) {
            FlashMessage::error('This username is already taken.');
            $return_to_form = true;
        }
        if (!preg_match("/^.{8,}$/i", $form_data['password']) || !preg_match("/\d/", $form_data['password'])) {
            FlashMessage::error('Password must be at least 8 characters long and contain a number');
            $return_to_form = true;
        }
        if ($form_data['password'] !== $form_data['confirm_password']) {
            FlashMessage::error('Passwords do not match');
            $return_to_form = true;
        }
        // TODO: If validation fails, display the first error as a flash message
        // and redirect to the registration page
        if ($return_to_form) {
            SessionManager::set("account_info", $form_data);
            return $this->redirect($request, $response, 'auth.register');
        }

        // TODO: Build the user data array and hardcode the role as 'customer'.
        //       Create the user using the UserModel.
        //       On success, display a success flash message and redirect to the login page.
        //       On failure, display an error flash message and redirect to the registration page.
        $userParams = [
            'first_name' => $form_data['first_name'],
            'last_name' => $form_data['last_name'],
            'username' => $form_data['username'],
            'email' => $form_data['email'],
            'password' => $form_data['password']
        ];
        try {
            $userId = $this->userModel->createUser($userParams);
            FlashMessage::success("Created user #$userId");
            return $this->render($response, '/user/accounts/login.php');
        } catch (Exception $e) {
            FlashMessage::error($e->getMessage());
            return $this->redirect($request, $response, 'auth.register');
        }
        // !after validating the account info and detecting something wrong with them

    }
    /**
     * Display the login form (GET request).
     */
    public function login(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'Login'
        ];

        return $this->render($response, 'auth/login.php', $data);
    }

    /**
     * Process login form submission (POST request).
     */
    public function authenticate(Request $request, Response $response, array $args): Response
    {
        $form_data = (array) $request->getParsedBody();
        // TODO: Validate that both fields are present
        if (isset($form_data['identifier']) && isset($form_data['password'])) {
            $user = $this->userModel->verifyCredentials($form_data['identifier'], $form_data['password']);
            if ($user === null) {
                FlashMessage::error('Invalid Credentials.');
                return $this->redirect($request, $response, 'auth.login');
            }
        } else {
            FlashMessage::error('Insufficient Credentials. Please ensure all fields are filled before submitting.');
            return $this->redirect($request, $response, 'auth.login');
        }

        SessionManager::set('user', [
            'user_id' => $user['id'],
            'user_email' => $user['email'],
            'user_name' => $user['first_name'] . ' ' . $user['last_name'],
            'user_role' => $user['role'],
            'is_authenticated' => true
        ]);

        // TODO:
        // 1. Query the database to check whether the user has 2FA enabled.
        // 2. Store the result in the session as 'requires_2fa'.
        $requires_2fa = $this->twoFactorAuthModel->isEnabled($user['id']);

        // 3. Set 'two_factor_verified' in the session:
        // If the user does not have 2FA enabled, mark it as already verified so they are not prompted.
        //If they do have 2FA, mark it as not yet verified.
        $session_user = SessionManager::get('user');
        if (!$requires_2fa) {
            $session_user['two_factor_verified'] = true;
        } else {
            $session_user['two_factor_verified'] = false;
        }
        SessionManager::set('user', $session_user);

        // TODO: Display a welcome message and redirect based on role:
        //       admins go to the admin dashboard, customers go to the user dashboard
        if ($session_user['two_factor_verified'] ?? false) {
            if ($user['role'] === 'admin') {
                return $this->redirect($request, $response, '2fa.verify');
            } else {
                return $this->redirect($request, $response, '2fa.verify');
            }
        } else {
            if ($user['role'] === 'admin') {
                FlashMessage::success("Welcome " . SessionManager::get('user')['user_name']);
                return $this->redirect($request, $response, 'admin/users/2fa-dashboard');
            } else {
                FlashMessage::success("Welcome " . SessionManager::get('user')['user_name']);
                return $this->redirect($request, $response, 'user.dashboard');
            }
        }
    }

    /**
     * Logout the current user (GET request).
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        SessionManager::destroy();
        FlashMessage::success('You have successfully been logged out.');
        return $this->redirect($request, $response, 'auth.login');
    }

    /**
     * Display user dashboard (protected route).
     */
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        // TODO:
        // 1. Query the database to check whether the current user has 2FA enabled.
        $status = $this->twoFactorAuthModel->isEnabled(SessionManager::get('user')['user_id']);
        // 2. Render 'dashboard.php', passing the 2FA status so the
        //    view can display the correct toggle button.

        $data = [
            'title' => 'Dashboard',
            'has2FA' => $status
        ];

        return $this->render($response, 'user/dashboard.php', $data);
    }
}
