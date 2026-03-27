<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AdminUsersController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'Admin · Users',
            'username' => $_SESSION['username'] ?? 'Admin',
            'users' => [],
        ];

        return $this->render($response, 'admin/users/usersView.php', $data);
    }
}
