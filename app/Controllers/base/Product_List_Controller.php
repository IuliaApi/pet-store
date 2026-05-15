<?php

declare(strict_types=1);

namespace App\Controllers\Base;

use DI\Container;
use App\Controllers\BaseController;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Product_List_Controller extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $productsModel
    ) {
        parent::__construct($container);
    }

    //filters through the product list based on user input
    public function search(Request $request, Response $response, array $args): Response
    {
        $keyword = $request->getQueryParams()['search_keyword'] ?? '';
        $products = $this->productsModel->searchProducts($keyword);
        $sum = count($products);

        $data['results'] = [
            'title' => (($sum > 0) ? $sum : 'No ') . (($sum === 1) ? ' result ' : 'results ') . 'for ' . '"' . $keyword . '"',
            'products' => $products
        ];

        // return $response->withHeader(HEADERS_CONTENT_TYPE, APP_MEDIA_TYPE_JSON)->withStatus(HTTP_OK);

        return $this->render($response, '/base/Product_List_View.php', $data);
    }

    //default loading of a product's details view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['results'] = [
            'title' => 'Our catalogue',
            'products' => $this->productsModel->getAll()
        ];

        return $this->render($response, '/base/Product_List_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
