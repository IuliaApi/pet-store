<?php

declare(strict_types=1);

namespace App\Controllers\user\accounts;

use DI\Container;
use App\Controllers\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Verif_Code_Controller extends BaseController
{
    public function __construct(Container $container)
    {
        parent::__construct($container);
    }

    //default loading of verification code view page
    public function index(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Verification',
            'message' => 'Welcome to the registration page',
        ];

        return $this->render($response, '/user/accounts/Verif_Code_View.php', $data);
    }

    public function error(Request $request, Response $response, array $args): Response
    {
        return $this->render($response, '404.php');
    }
}
