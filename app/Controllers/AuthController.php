<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use App\Controllers\BaseController;
use App\Domain\Models\UserModel;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Helpers\FlashMessage;
use Exception;

class AuthController extends BaseController
{

    public function __construct(Container $container, private UserModel $userModel)
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
        if (!preg_match("/^.{8,}$/i", $form_data['password']) && !preg_match("/\d/", $form_data['password'])) {
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
        // TODO: Extract the identifier and password from the submitted form

        // TODO: Validate that both fields are present

        // TODO: Attempt to verify the credentials using the UserModel

        // TODO: If authentication fails, display an error and redirect to the login page

        // TODO: Store the authenticated user's data in the session
        //       (ID, email, full name, role, and a flag indicating they are authenticated)

        // TODO: Display a welcome message and redirect based on role:
        //       admins go to the admin dashboard, customers go to the user dashboard
        return $response;
    }

    /**
     * Logout the current user (GET request).
     */
    public function logout(Request $request, Response $response, array $args): Response
    {
        session_destroy();
        FlashMessage::success('You have successfully been logged out.');
        return $this->redirect($request, $response, 'login.php');
    }
    /**
     * Display user dashboard (protected route).
     */
    public function dashboard(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'Dashboard'
        ];

        return $this->render($response, 'auth/login.php', $data);
    }
}
