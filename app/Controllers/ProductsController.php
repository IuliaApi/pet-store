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
        $params = $request->getQueryParams();
        if (!isset($params['q'])) {
            $params['q'] = '';
        } else {
            $params['q'] = trim($params['q']);
        }
        $category =  isset($params['category']) ? intval($params['category']) : null;
        if (strlen($params['q']) > 100) {
            $params['q'] = substr($params['q'], 0, 100);
        }
        $products = $this->productsModel->searchProducts($params['q'], $category);
        $response[] = [
            'success' => true,
            'count' => count($products),
            'query' => $params['q'],
            'category_id' => $category,
            'products' => $products
        ];
        $jsonResponse = json_encode($response);
        $response->getBody()->write($jsonResponse);
        // TODO: Return response with proper headers
        return $response
            ->withHeader("Content-Type", 'application/json')
            ->withStatus(200);
    }
}
