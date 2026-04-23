<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Routing\RouteContext;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

// class AdminAuthMiddleware implements MiddlewareInterface
// {
//     public function __construct(private ResponseFactoryInterface $responseFactory) {}

//     public function process(Request $request, RequestHandler $handler): ResponseInterface
//     {

//         // TODO: Retrieve the user's authentication status and role from the session.
//         //       If not authenticated, redirect to the login page.
//         //       If authenticated but not an admin, redirect to the user dashboard
//         //       with an access denied message.
//         //       If both checks pass, allow the request to proceed.
//         //
//         //       Use the same redirect pattern as AuthMiddleware (RouteParser + responseFactory).
//         return $Response ;
//     }
// }
