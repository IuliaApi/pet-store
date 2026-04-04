<?php

declare(strict_types=1);

namespace App\Controllers\User\Saves;

use DI\Container;
use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Cart_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    //default loading of appointment booking view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Cart',
            'message' => 'Welcome to your shopping cart page',
        ];

        return $this->render($response, '/user/saves/Cart_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
