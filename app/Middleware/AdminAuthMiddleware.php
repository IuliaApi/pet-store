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
use App\Domain\Models\TwoFactorAuthModel;

class AdminAuthMiddleware implements MiddlewareInterface
{
    public function __construct(private ResponseFactoryInterface $responseFactory, private TwoFactorAuthModel $twoFactorModel) {}

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $isAuthenticated = (bool) SessionManager::get('is_authenticated', false);
        // TODO: Retrieve the user's authentication status and role from the session.
        //       If not authenticated, redirect to the login page.
        //       If authenticated but not an admin, redirect to the user dashboard
        //       with an access denied message.
        if (!$isAuthenticated) {
            $loginUrl = $routeParser->urlFor('auth.login');
            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $loginUrl);
        }
        //       If both checks pass, allow the request to proceed.
        if (SessionManager::get('user_role') !== 'admin') {
            FlashMessage::error('Access denied.');
        }

        // After verifying the user is an admin, check if 2FA is enabled:
        $userId = SessionManager::get('user_id');

        if (!$this->twoFactorModel->isEnabled($userId)) {
            FlashMessage::warning('Admin accounts require Two-Factor Authentication. Please enable 2FA to continue.');

            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $setupUrl = $routeParser->urlFor('2fa.setup');

            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $setupUrl);
        }

        //       Use the same redirect pattern as AuthMiddleware (RouteParser + responseFactory).
        $dashboardUrl = $routeParser->urlFor('user.dashboard');
        $response = $this->responseFactory->createResponse(302);
        return $response->withHeader('Location', $dashboardUrl);
        return $handler->handle($request);
    }
}
