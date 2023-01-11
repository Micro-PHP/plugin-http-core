<?php

declare(strict_types=1);

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Component\DependencyInjection\Autowire\AutowireHelperInterface;
use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\Http\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteExecutor implements RouteExecutorInterface
{
    /**
     * @param UrlMatcherInterface $urlMatcher
     * @param ContainerRegistryInterface $containerRegistry
     * @param AutowireHelperInterface $autowireHelper
     */
    public function __construct(
        private UrlMatcherInterface $urlMatcher,
        private ContainerRegistryInterface $containerRegistry,
        private AutowireHelperInterface $autowireHelper,
    )
    {
    }

    /**
     * TODO: Temporary solution.
     *  - Should implement Response transformers plugin
     *
     * {@inheritDoc}
     */
    public function execute(Request $request, bool $flush = true): Response
    {
        try {
            $route = $this->urlMatcher->match($request);
            $action = $route->getAction();

            $this->containerRegistry->register(Request::class, fn() => $request);
            $autowired = $this->autowireHelper->autowire($action);

            $response = call_user_func($autowired);
            if(is_scalar($response)) {
                $response = new Response($response);
            }

            if($response instanceof Response && $flush) {
                $response->send();
            }

        } catch (HttpException $httpException) {
            $response = new Response($httpException->getMessage(), $httpException->getCode());
            if($flush) {
                $response->send();
            }

            throw $httpException;
        } catch (\Throwable $exception) {
            $response = new Response('Internal server exception', 500);
            if($flush) {
                $response->send();
            }

            throw $exception;
        }
    }
}