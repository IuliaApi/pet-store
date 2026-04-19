<?php

declare(strict_types=1);

namespace App\Controllers\Base;

use DI\Container;
use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Product_List_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    //filters through the product list based on user input
    public function search(): array
    {
        $pdo_values = [];
        $search_keyword = hs($_GET['input']) ?? null;
        $sort = $_GET['value'] ?? 'name'; //A->Z || Z->A = name, price=price, //?rating=?
        $order = $_GET['order'] ?? 'ASC';

        $products_Table = "SELECT * FROM products";

        if ($search_keyword !== null) {
            $products_Table .= " WHERE name LIKE CONCAT('%', :word, '%')";
            $pdo_values["word"] = $search_keyword;
        }

        $products_Table .= " ORDER BY :sort :order";
        $pdo_values["sort"] = $sort;
        $pdo_values["order"] = $order;

        /*
        $statement = $pdo->prepare($products_Table);
        $statement->execute($pdo_values);
        $products[] = $statement->fetchAll();
        */
        $products[] = null; //temp/placeholder

        return $products;
    }

    //default loading of a product's details view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'NUMBER_OF_RESULTS_GOES_HERE',
            'message' => 'Key word used goes here',
        ];

        return $this->render($response, '/base/Product_List_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
