<?php

declare(strict_types=1);

namespace App\Controllers\base;

use DI\Container;
use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

/**
 * Controller for the contacts page
 * Our contact information is not stored in a database so there is no model to be used
 */
class Contacts_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    /**
     * default loading of Contact view page
     * @param Request $request
     * @param Response $response
     * @param array $args
     * @return Response
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Contacts',
            'message' => 'Welcome to the contacts page',
        ];

        return $this->render($response, '/base/Contacts_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
