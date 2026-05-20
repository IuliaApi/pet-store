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
        $data['itemCount'] = $data['total'] = 0;
        foreach ($data['cart'] as $productId => $productDetails) {
            $data['itemCount'] += $productDetails['quantity'];
            $data['total'] += $productDetails['quantity'] * $productDetails['price'];
        }
        $data['title'] = 'Cart';
        $data['message'] = 'Welcome to your shopping cart page';
        return $this->render($response, '/user/saves/cart_View.php', $data);
    }

    public function add(Request $request, Response $response, array $args): Response
    {
        $productId = intval($request->getParsedBody()['productId']);
        $productIdString = (string)$productId;

        // Validate that the product ID is greater than 0. If not, set an error flash message and redirect to cart.index.
        if ($productId <= 0) {
            FlashMessage::error('Invalid product id');
            return $this->redirect($request, $response, 'cart.index');
        }

        // Fetch the product from the database using $this->productsModel->findById($productId). If the product is not found (returns false), set an error flash message and redirect.
        $product = $this->productsModel->getById($productId);
        if (!$product) {
            FlashMessage::error('Product could not be found');
            return $this->redirect($request, $response, 'cart.index');
        }

        // Read the current cart from the session.
        $cart = SessionManager::get('cart', []);

        // If the product does not exist in the cart, add a new entry with the product’s id, name, price (fetched from the database), and a quantity of 1.
        if (!isset($cart[$productIdString])) {
            $cart[$productIdString] = [
                'product_id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 0,
                'stock_quantity' => $product['stock_quantity']
            ];
        }
        // If the product already exists in the cart, increment its quantity by 1.
        $cart[$productIdString]['quantity']++;
        // Write the updated cart back to the session using SessionManager::set('cart', $cart).
        SessionManager::set('cart', $cart);
        // Set a success flash message (e.g., "'{product name}' was added to your cart.").
        FlashMessage::success($product['name'] . ' was added to your cart.');
        // Redirect to cart.index
        return $this->redirect($request, $response, 'cart.index');
    }

    public function update(Request $request, Response $response, array $args): Response
    {
        $update = $request->getParsedBody();
        $productId = intval($update['productId']);
        $productIdString = (string)$productId;
        $quantity = intval($update['quantity']);
        $cart = SessionManager::get('cart');
        if (!isset($cart[$productIdString])) {
            FlashMessage::error('Cannot update a product that\'s not in the cart');
            return $this->redirect($request, $response, 'cart.index');
        }
        if ($quantity <= 0) {
            FlashMessage::info($cart[$productIdString]['name'] . ' was removed from the cart.');
            unset($cart[$productIdString]);
        } else {
            $stock = $cart[$productIdString]['stock_quantity'];
            if ($quantity > $stock) {
                $cart[$productIdString]['quantity'] = $stock;
                FlashMessage::warning("There are only $stock available. You now only have $cart[$productIdString]['quantity'] of $cart[$productIdString]['name']");
            } else {
                $cart[$productIdString]['quantity'] = $quantity;
                FlashMessage::success("You now have $cart[$productIdString]['quantity'] of $cart[$productIdString]['name']");
            }
        }
        SessionManager::set('cart', $cart);
        return $this->redirect($request, $response, 'cart.index');
    }

    public function remove(Request $request, Response $response, array $args): Response
    {
        $toBeRemoved = $request->getParsedBody();
        $productId = intval($toBeRemoved['productId']);
        $productIdString = (string) $productId;
        $cart = SessionManager::get('cart');
        if (!isset($cart[$productIdString])) {
            FlashMessage::error('Can\'t find ' . $productIdString . ' in cart');
            return $this->redirect($request, $response, 'cart.index');
        }
        unset($cart[$productIdString]);
        SessionManager::set('cart', $cart);
        return $this->redirect($request, $response, 'cart.index');
    }

    public function clear(Request $request, Response $response, array $args): Response
    {
        SessionManager::remove('cart');
        FlashMessage::success('Emptied out the cart');
        return $this->redirect($request, $response, 'cart.index');
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
