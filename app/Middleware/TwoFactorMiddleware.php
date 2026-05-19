<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Domain\Models\TwoFactorAuthModel;
use App\Helpers\SessionManager;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Slim\Routing\RouteContext;

class TwoFactorMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TwoFactorAuthModel $twoFactorModel,
        private ResponseFactoryInterface $responseFactory
    ) {
        $this->twoFactorModel = $twoFactorModel;
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        // TODO: Retrieve the user's authentication status from the session.
        $user = SessionManager::get('user');

        //       If not authenticated, pass the request to the next handler.
        if ($user['is_authenticated'] ?? false) {
            return $handler->handle($request);
        }

        //       If authenticated, check whether the user has 2FA enabled
        //       and whether it has been verified this session.
        //       If 2FA is required but not verified, redirect to the
        //       verification page.
        //
        if ($this->twoFactorModel->isEnabled($user['id']) && !isset($this->twoFactorModel->getSecret($user)['id'])) {
            //       Use the following to generate the verification URL and
            //       create a redirect response:
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $verifyUrl = $routeParser->urlFor('2fa.verify');
            $response = $this->responseFactory->createResponse(302);
            return $response->withHeader('Location', $verifyUrl);
        }
    }
}
