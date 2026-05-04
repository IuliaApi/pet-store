<?php

declare(strict_types=1);

namespace App\Controllers\user\accounts;

use DI\Container;
use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Login_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    //default loading of the login view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Login',
            'message' => 'Welcome to the login page',
        ];

        return $this->render($response, '/auth/login.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
