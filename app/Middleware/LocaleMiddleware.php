<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Helpers\SessionManager;
use App\Helpers\TranslationHelper;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;

class LocaleMiddleware implements MiddlewareInterface
{
    private TranslationHelper $translator;

    public function __construct(TranslationHelper $translator)
    {
        $this->translator = $translator;
    }

    public function process(Request $request, RequestHandler $handler): ResponseInterface
    {
        // TODO: Detect the user's preferred locale by checking:
        //       1. The URL query parameter (?lang=)
        
        // $locale = $request->getQueryParams()['lang'] ??
        // SessionManager::get('lang') ??
        // $this->translator->getDefaultLocale();

        //       2. The session (saved from a previous request)
        //       3. The default locale
        //       If a new locale was explicitly requested via URL and is valid,
        //       update the translator and save it to the session.
        //       If no URL parameter is present but a saved locale exists
        //       in the session, set it in the translator.
        //       Store the current locale as a request attribute
        //       and pass the request to the next handler.
        return $handler->handle($request);
    }
}
