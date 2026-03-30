<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Admin Orders controller.
 */
class AdminOrdersController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'Admin · Orders',
            'username' => $_SESSION['username'] ?? 'Admin',
            'orders' => [],
        ];

        return $this->render($response, 'admin/orders/orderIndexView.php', $data);
    }
}
