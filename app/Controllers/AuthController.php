<?php

declare(strict_types=1);

namespace App\Controllers;

use DI\Container;
use App\Controllers\BaseController;
use App\Domain\Models\UserModel;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AuthController extends BaseController
{

    public function __construct(Container $container, private UserModel $userModel)
    {
        parent::__construct($container);
    }
    public function register(Request $request, Response $response, array $args): Response
    {
        $data['data'] = [
            'title' => 'Register | Create a new account',
        ];

        if (isset($_SESSION["account_info"])) {
            $data['data']['account_info'] = $_SESSION["account_info"];
            unset($_SESSION["account_info"]);
        }
        return $this->render($response, "auth/register.php", $data);
    }

    public function store(Request $request, Response $response, array $args): Response
    {
        $form_data = $request->getParsedBody();


        if (!filter_var($form_data))


            SessionManager::Set("account_info", $form_data);
        return $this->redirect($request, $response, "auth.register");
    }
}
