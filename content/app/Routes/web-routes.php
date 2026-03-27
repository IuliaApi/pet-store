<?php

declare(strict_types=1);

/**
 * This file contains the routes for the web application.
 */

use App\Controllers\HomeController;
use App\Controllers\AdminDashboardController;
use App\Controllers\AdminProductsController;
use App\Controllers\AdminOrdersController;
use App\Controllers\AdminUsersController;
use App\Controllers\ProductsController;
use App\Middleware\AdminAuthMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


return static function (Slim\App $app): void {


    //* NOTE: Route naming pattern: [controller_name].[method_name]
    $app->get('/', [HomeController::class, 'index'])
        ->setName('home.index');

    $app->get('/home', [HomeController::class, 'index'])
        ->setName('home.index');

    // Public products listing (user-facing)
    $app->get('/products', [ProductsController::class, 'index'])
        ->setName('products.index');

    // Admin Panel Routes
    $app->group('/admin', function ($group) {
        // Dashboard route
        $group->get('/dashboard', [AdminDashboardController::class, 'dashboard'])
            ->setName('admin.dashboard');

        // Products CRUD (admin)
        $group->get('/products', [AdminProductsController::class, 'index'])
            ->setName('admin.products.index');
        $group->get('/products/create', [AdminProductsController::class, 'create'])
            ->setName('admin.products.create');
        $group->post('/products', [AdminProductsController::class, 'store']);
        $group->get('/products/{id}/edit', [AdminProductsController::class, 'edit'])
            ->setName('admin.products.edit');
        $group->post('/products/{id}', [AdminProductsController::class, 'update']);
        $group->get('/products/{id}/delete', [AdminProductsController::class, 'delete'])
            ->setName('admin.products.delete');

        // Orders
        $group->get('/orders', [AdminOrdersController::class, 'index'])
            ->setName('admin.orders.index');

        // Users
        $group->get('/users', [AdminUsersController::class, 'index'])
            ->setName('admin.users.index');
    })->add(AdminAuthMiddleware::class);

    // A route to display PHP configuration information.
    $app->get('/phpinfo', function (Request $request, Response $response, $args) {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_clean();
        $response->getBody()->write($phpinfo);
        return $response;
    });

    // A route to test runtime error handling and custom exceptions.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpBadRequestException($request, "This is a runtime error. Something went wrong");
    });
};
