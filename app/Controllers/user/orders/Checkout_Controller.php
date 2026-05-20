<?php

declare(strict_types=1);

namespace App\Controllers\User\Orders;

use DI\Container;
use App\Controllers\BaseController;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Checkout_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    //default loading of checkout view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [];
        $data['product_list'] = SessionManager::get('cart', []);
        $data['itemCount'] = $data['total'] = 0;
        foreach ($data['product_list'] as $productId => $productDetails) {
            $data['itemCount'] += $productDetails['quantity'];
            $data['total'] += $productDetails['quantity'] * $productDetails['price'];
        }

        return $this->render($response, '/user/orders/Checkout_View.php', $data);
    }

    public function clear(Request $request, Response $response, array $args): Response
    {
        SessionManager::remove('cart');
        return $this->redirect($request, $response, 'home.index');
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
