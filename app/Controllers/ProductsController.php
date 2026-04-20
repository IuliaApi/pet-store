<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\ProductsModel;
use App\Helpers\ViewHelper;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ProductsController extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $productsModel
    ) {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response, array $args): Response
    {
        $products = $this->productsModel->getAll();

        $data = [
            'title' => 'Shop · Products',
            'products' => $products,
        ];

        return $this->render($response, 'products/productIndexView.php', $data);
    }

    public function search(Request $request, Response $response, array $args): Response
    {
        // TODO: Extract query parameters using $request->getQueryParams()
        // - Get 'q' parameter, trim it, default to empty string if not set
        // - Get 'category' parameter, convert to int if set, otherwise null
        $params = $request->getQueryParams();
        if (!isset($params['q'])) {
            $params['q'] = '';
        } else {
            $params['q'] = trim($params['q']);
        }
        $category =  isset($params['category']) ? intval($params['category']) : null;
        // TODO: Validate search term length
        // - If longer than 100 characters, truncate it using substr()
        if (strlen($params['q']) > 100) {
            $params['q'] = substr($params['q'], 0, 100);
        }
        // TODO: Call $this->productsModel->searchProducts() with search term and category ID
        $products = $this->productsModel->searchProducts($params['q'], $category);
        // TODO: Create response data array with these keys:
        // - 'success' => true
        // - 'count' => count of products
        // - 'query' => the search term
        // - 'category_id' => the category ID
        // - 'products' => the products array
        $response[] = [
            'success' => true,
            'count' => count($products),
            'query' => $params['q'],
            'category_id' => $category,
            'products' => $products
        ];
        // TODO: Convert response data to JSON and write to response body
        // @see: https://www.slimframework.com/docs/v4/objects/response.html#returning-json
        // - Use json_encode()
        // - Use $response->getBody()->write()
        $jsonResponse = json_encode($response);
        $response->getBody()->write($jsonResponse);
        // TODO: Return response with proper headers
        // - Set Content-Type: application/json
        // - Set status code 200
        return $response
            ->withHeader("Content-Type", 'application/json')
            ->withStatus(200);
    }
}
