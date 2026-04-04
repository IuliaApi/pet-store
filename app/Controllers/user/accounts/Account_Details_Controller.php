<?php

declare(strict_types=1);

namespace App\Controllers\User\Accounts;

use DI\Container;
use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Account_Details_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    //default loading of verification code view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Account',
            'message' => 'Welcome to your account page',
        ];

        return $this->render($response, '/user/accounts/Account_Details_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
