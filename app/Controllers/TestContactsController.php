<?php

namespace App\Controllers;

use App\Helpers\ViewHelper;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TestController extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }
    public function error(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'errorView.php');
    }
    public function contact(Request $request, Response $response, array $args): Response
    {

        return $this->render($response, 'user\contact_View.php');
    }

}
