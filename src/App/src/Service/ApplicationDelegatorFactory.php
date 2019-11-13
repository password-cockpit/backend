<?php

/**
 * container-interop-doctrine
 *
 * @link      http://github.com/DASPRiD/container-interop-doctrine For the canonical source repository
 * @copyright 2016 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace App\Service;

use Expressive\Helper\ServerUrlMiddleware;
use Expressive\Helper\UrlHelperMiddleware;
use App\Middleware\OptionsMiddleware;
use Expressive\Middleware\ImplicitHeadMiddleware;
use Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Psr\Container\ContainerInterface;
use Authentication\Api\V1\Middleware\AuthenticationMiddleware;
use Authorization\Api\V1\Middleware\AuthorizationMiddleware;
use Expressive\Router\Middleware\RouteMiddleware;
use Expressive\Router\Middleware\DispatchMiddleware;
use Tuupola\Middleware\JwtAuthentication;
use App\Middleware\I18nMiddleware;
use App\Middleware\CorsMiddleware;
use App\Middleware\TokenArrayMiddleware;
use App\Middleware\StrictTransportSecurityMiddleware;
use Blast\BaseUrl\BaseUrlMiddleware;
use App\Middleware\ContentSecurityMiddleware;
use Expressive\ProblemDetails\ProblemDetailsMiddleware;

class ApplicationDelegatorFactory
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName Name of the service being created.
     * @param callable $callback Creates and returns the service.
     * @return Application
     */
    public function __invoke(
        ContainerInterface $container,
        $serviceName,
        callable $callback
    ) {
        /** @var $app Application */
        $app = $callback();

        /**
         * Setup middleware pipeline:
         */
        $app->pipe(BaseUrlMiddleware::class);

        $app->pipe(CorsMiddleware::class); //this can be removed in prod since client is same origin as the server (and NOT localhost:4200 -> 10.0.3.150:4344)
        // Middlewares that adds security headers to each request.
        $app->pipe(StrictTransportSecurityMiddleware::class);
        $app->pipe(ContentSecurityMiddleware::class);

        // $app->pipe(ErrorHandler::class);
        $app->pipe(ProblemDetailsMiddleware::class);
        $app->pipe(ServerUrlMiddleware::class);
        $app->pipe(BodyParamsMiddleware::class);

        $app->pipe(RouteMiddleware::class);

        $app->pipe(ImplicitHeadMiddleware::class);
        $app->pipe(OptionsMiddleware::class);
        $app->pipe(UrlHelperMiddleware::class);

        $app->pipe(JwtAuthentication::class);
        $app->pipe(TokenArrayMiddleware::class);

        $app->pipe(AuthenticationMiddleware::class);
        // Translator
        $app->pipe(I18nMiddleware::class);
        $app->pipe(AuthorizationMiddleware::class);

        $app->pipe(DispatchMiddleware::class);

        $app->pipe(NotFoundHandler::class);

        \Expressive\Container\ApplicationConfigInjectionDelegator::injectRoutesFromConfig(
            $app,
            $container->get('config')
        );

        return $app;
    }
}
