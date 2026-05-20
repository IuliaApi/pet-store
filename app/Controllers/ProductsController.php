<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Domain\Models\ProductsModel;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use function strlen;
use function intval;

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
        $params = $request->getQueryParams();
        $query = trim($params['q'] ?? '');
        $products = [];
        if ($query !== '') {
            $products = $this->productsModel->searchProducts($query);
        } else {
            $products = $this->productsModel->getAll();
        }
        // $products = empty($query) ? $this->productsModel->getAll() : $this->productsModel->searchProducts($query);

        $data = [
            'title' => 'Shop · Products',
            'products' => $products,
        ];
        return $this->render($response, 'products/productIndexView.php', $data);
    }

    public function searchApi(Request $request, Response $response, array $args): Response
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
        $result = [
            'success' => true,
            'count' => count($products),
            'query' => $params['q'],
            'category_id' => $category,
            'products' => $products
        ];
        $jsonResponse = json_encode($result);
        $response->getBody()->write($jsonResponse);
        // Return response with proper headers
        return $response
            ->withHeader("Content-Type", 'application/json')
            ->withStatus(200);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
