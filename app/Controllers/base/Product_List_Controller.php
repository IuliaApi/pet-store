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
        $params = $request->getQueryParams();
        $keyword = (string)($params['search_keyword'] ?? '');
        $sort = (string)($params['sort'] ?? 'name');
        $order = strtoupper((string)($params['order'] ?? 'ASC'));

        $allowedSort = ['name', 'price', 'stock'];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'name';
        }
        if (!in_array($order, ['ASC', 'DESC'], true)) {
            $order = 'ASC';
        }

        $products = $this->productsModel->searchProducts($keyword, null, $sort, $order);
        $sum = count($products);

        $data = [
            'title' => (($sum > 0) ? $sum : 'No') . (($sum === 1) ? ' result ' : ' results ') . (($keyword === '') ? '' : 'for ' . '"' . $keyword . '"'),
            'products' => $products,
            'sort' => $sort,
            'order' => $order,
            'search_keyword' => $keyword,
        ];

        // return $response->withHeader(HEADERS_CONTENT_TYPE, APP_MEDIA_TYPE_JSON)->withStatus(HTTP_OK);

        return $this->render($response, '/base/Product_List_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
