<?php

declare(strict_types=1);

namespace App\Controllers\User\Saves;

use App\Helpers\SessionManager;
use DI\Container;
use App\Controllers\BaseController;
use App\Domain\Models\ProductsModel;
use App\Helpers\FlashMessage;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Cart_Controller extends BaseController
{
    public function __construct(Container $container, private ProductsModel $productsModel)
    {
        parent::__construct($container);
    }

    //default loading of product cart view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data = [];
        $data['cart'] = SessionManager::get('cart', []);
        $data['itemCount'] = count($data['cart']);
        $data['total'] = 0;
        foreach ($data['cart'] as $productId => $productDetails) {
            $data['total'] +=$productDetails['quantity']*$productDetails['price'];
        }
        $data[] = [
            'title' => 'Cart',
            'message' => 'Welcome to your shopping cart page',
        ];

        return $this->render($response, '/user/saves/Cart_View.php', $data);
    }

    public function add(Request $request, Response $response, array $args): Response
    {
        $productId = $request->getParsedBody();
        // Validate that the product ID is greater than 0. If not, set an error flash message and redirect to cart.index.
        if(!$productId>0){
            FlashMessage::error('Invalid product id');
            return $this->redirect($request, $response, 'products.index');
        }
        // Fetch the product from the database using $this->productsModel->findById($productId). If the product is not found (returns false), set an error flash message and redirect.
        
        // Read the current cart from the session.
        // If the product already exists in the cart, increment its quantity by 1.
        // If the product does not exist in the cart, add a new entry with the product’s id, name, price (fetched from the database), and a quantity of 1.
        // Write the updated cart back to the session using SessionManager::set('cart', $cart).
        // Set a success flash message (e.g., "'{product name}' was added to your cart.").
        // Redirect to cart.index
        return $this->render($response, 'index');
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
