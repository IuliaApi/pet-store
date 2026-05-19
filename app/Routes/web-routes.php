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
use App\Controllers\AdminCategoriesController;
use App\Controllers\UploadController;
use App\Controllers\ProductsController;
use App\Controllers\Base\Product_List_Controller;
use App\Controllers\Base\Product_Details_Controller;
use App\Controllers\Base\Contacts_Controller;
use App\Controllers\User\Accounts\Register_Controller;
use App\Controllers\User\Accounts\Account_Details_Controller;
use App\Controllers\User\Orders\Checkout_Controller;
use App\Controllers\User\Orders\Booking_Controller;
use App\Controllers\User\Saves\Cart_Controller;
use App\Controllers\User\Saves\Schedule_Controller;
use App\Controllers\TestContactsController;
use App\Controllers\AuthController;
use App\Controllers\TwoFactorController;
use App\Middleware\AuthMiddleware;
use App\Middleware\AdminAuthMiddleware;
use App\Middleware\TwoFactorMiddleware;
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

    //Lists of products based on a search page route
    $app->get('/search', [Product_List_Controller::class, 'search'])
        ->setName('search_result.search');

    //specific item page route
    $app->get('/products/{id}', [Product_Details_Controller::class, 'index'])
        ->setName('item.index');

    //Contacts page route
    $app->get('/contacts', [Contacts_Controller::class, 'index'])
        ->setName('contacts.index');

    //Authentication page route
    $app->get('/register', [AuthController::class, 'register'])
        ->setName('auth.register');

    $app->post('/register', [AuthController::class, 'store']);

    $app->get('/login', [AuthController::class, 'login'])
        ->setName('auth.login');

    $app->post('/login', [AuthController::class, 'authenticate']);

    $app->get('/logout', [AuthController::class, 'logout'])
        ->setName('auth.logout');

    $app->get('/dashboard', [AuthController::class, 'dashboard'])
        ->setName('user.dashboard')
        ->add(AuthMiddleware::class);

    //Login page route: shows the login form
    //$app->get('/login', [Login_Controller::class, 'index'])
    //->setName('user.login.index');

    //Registration page route
    $app->get('/registration', [Register_Controller::class, 'index'])
        ->setName('user.registration.index');

    //Account page route
    $app->get('/profile', [Account_Details_Controller::class, 'index'])
        ->setName('user.profile.index');

    //checkout page route
    $app->get('/checkout', [Checkout_Controller::class, 'index'])
        ->setName('user.checkout.index');

    //appointment booking page route
    $app->get('/booking', [Booking_Controller::class, 'index'])
        ->setName('user.booking.index');

    //Shopping cart page route
    $app->get('/cart', [Cart_Controller::class, 'index'])
        ->setName('user.cart.index');

    //Scheduled appointments page route
    $app->get('/schedule', [Schedule_Controller::class, 'index'])
        ->setName('user.schedule.index')
        ->add(AuthMiddleware::class);

    $app->group('/2fa', function ($group) {
        $group->get('setup', [TwoFactorController::class, 'showSetup'])
            ->setName('2fa.setup')
            ->add(AuthMiddleware::class);

        $group->post('verify-and-enable', [TwoFactorController::class, 'verifyAndEnable'])
            ->setName('2fa.enable')
            ->add(AuthMiddleware::class);

        $group->get('verify', [TwoFactorController::class, 'showVerify'])
            ->setName('2fa.verify')
            ->add(AuthMiddleware::class);

        $group->post('verify', [TwoFactorController::class, 'verify'])
            ->setName('2fa.verify.post')
            ->add(AuthMiddleware::class);

        $group->get('disable', [TwoFactorController::class, 'showDisable'])
            ->setName('2fa.disable.show')
            ->add(TwoFactorMiddleware::class)
            ->add(AuthMiddleware::class);

        $group->post('disable', [TwoFactorController::class, 'disable'])
            ->setName('2fa.disable')
            ->add(TwoFactorMiddleware::class)
            ->add(AuthMiddleware::class);
    });

    $app->group('/cart', function ($group) {
        // view the cart
        $group->get('', [Cart_Controller::class, 'index'])
        ->setName('cart.index');

        // cart CRUD
        $group->post('/add', [Cart_Controller::class, 'add'])
        ->setName('cart.add');

        $group->post('/update', [Cart_Controller::class, 'update'])
        ->setName('cart.update');

        $group->post('/remove', [Cart_Controller::class, 'remove'])
        ->setName('cart.remove');

        $group->post('/clear', [Cart_Controller::class, 'clear'])
        ->setName('cart.clear');

    });

    // Admin Panel Routes
    $app->group('/admin', function ($group) {
        // Dashboard route
        $group->get('', [AdminDashboardController::class, 'dashboard'])
            ->setName('admin.dashboard');
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

        // Categories
        $group->get('/categories', [AdminCategoriesController::class, 'index'])
            ->setName('admin.categories.index');

        // Uploads
        $group->get('/upload', [UploadController::class, 'index'])
            ->setName('upload.index');
        $group->post('/upload', [UploadController::class, 'upload'])
            ->setName('upload.process');
    })
        ->add(TwoFactorMiddleware::class)
        ->add(AdminAuthMiddleware::class)
        ->add(AuthMiddleware::class);

    $app->get('/api/products/search', [ProductsController::class, 'search'])
        ->setName('api.products.search');
    // A route to display PHP configuration information.
    $app->get('/phpinfo', function (Request $request, Response $response, $args) {
        ob_start();
        phpinfo();
        $phpinfo = ob_get_clean();
        $response->getBody()->write($phpinfo);
        return $response;
    });
    $app->get('/test_contacts', [TestContactsController::class, 'contact'])
        ->setName('contacts_Views.php');

    // A route to test runtime error handling and custom exceptions.
    $app->get('/error', function (Request $request, Response $response, $args) {
        throw new \Slim\Exception\HttpBadRequestException($request, "This is a runtime error. Something went wrong");
    });
};
