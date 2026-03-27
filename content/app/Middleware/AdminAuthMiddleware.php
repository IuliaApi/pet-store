<?php

declare(strict_types=1);

namespace App\Middleware;

use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AdminAuthMiddleware implements MiddlewareInterface
{
    public function __construct(private ResponseFactoryInterface $responseFactory)
    {
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            @session_start();
        }

        $isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

        if ($isAdmin) {
            return $handler->handle($request);
        }

        $response = $this->responseFactory->createResponse(StatusCodeInterface::STATUS_FOUND);
        return $response->withHeader('Location', APP_BASE_URL . '/');
    }
}
