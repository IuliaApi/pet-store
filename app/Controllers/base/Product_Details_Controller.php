<?php

declare(strict_types=1);

namespace App\Controllers\Base;

use DI\Container;
use App\Controllers\BaseController;
use App\Domain\Models\ProductsModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use function intval;
use function is_array;

/**
 * Product_Details_Controller is the controller for the product detail page
 * Requires a products model to be receive any information required by the view
 */
class Product_Details_Controller extends BaseController
{
    public function __construct(
        Container $container,
        private ProductsModel $productsModel
    ) {
        parent::__construct($container);
    }

    /**
     * default loading of a product's details view page
     * fetches a single product by the id passed via the uri parameter
     * because our thumbnails only point to the file name we need to map them correctly in the controller
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        $product = $this->productsModel->getById(intval($args['id']));

        if (is_array($product) && !empty($product['thumbnail'])) {
            $product['thumbnail'] = base_url('/assets/images/products/' . rawurlencode($product['thumbnail']));;
        }

        $data = [
            'product' => $product
        ];

        return $this->render($response, '/base/Product_Details_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
