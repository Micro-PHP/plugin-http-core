<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\Http\Business\Response\ResponseCallbackFactoryInterface;
use Micro\Plugin\Http\Exception\HttpInternalServerException;
use Micro\Plugin\Http\Exception\ResponseInvalidException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteExecutor implements RouteExecutorInterface
{
    public function __construct(
        private UrlMatcherInterface $urlMatcher,
        private ContainerRegistryInterface $containerRegistry,
        private ResponseCallbackFactoryInterface $responseCallbackFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request, bool $flush = true): Response
    {
        $route = $this->urlMatcher->match($request);
        $this->containerRegistry->register(Request::class, fn (): Request => $request);

        $callback = $this->responseCallbackFactory->create($route);
        try {
            $response = $callback();
        } catch (ResponseInvalidException $exception) {
            throw new HttpInternalServerException($request, $exception);
        }

        if ($flush) {
            $response->send();
        }

        return $response;
    }
}
