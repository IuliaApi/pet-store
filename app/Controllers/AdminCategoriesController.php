<?php

namespace App\Controllers;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Admin Categories controller.
 */
class AdminCategoriesController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [
            'title' => 'Categories',
            'username' => $_SESSION['username'] ?? 'Admin',
            'categories' => [],
        ];

        return $this->render($response, 'admin/categories/categoryIndexView.php', $data);
    }
}
