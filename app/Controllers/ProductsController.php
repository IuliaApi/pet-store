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
}
