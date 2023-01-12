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

namespace Micro\Plugin\Http\Facade;

use Micro\Plugin\Http\Business\Executor\RouteExecutorFactoryInterface;
use Micro\Plugin\Http\Business\Generator\UrlGeneratorFactoryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteBuilderFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteBuilderInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpFacade implements HttpFacadeInterface
{
    public function __construct(
        private UrlMatcherFactoryInterface $urlMatcherFactory,
        private RouteCollectionFactoryInterface $routeCollectionFactory,
        private RouteExecutorFactoryInterface $routeExecutorFactory,
        private RouteBuilderFactoryInterface $routeBuilderFactory,
        private UrlGeneratorFactoryInterface $urlGeneratorFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function createRouteBuilder(): RouteBuilderInterface
    {
        return $this->routeBuilderFactory->create();
    }

    /**
     * {@inheritDoc}
     */
    public function getDeclaredRoutesNames(): iterable
    {
        return $this->routeCollectionFactory
            ->create()
            ->getRoutesNames();
    }

    /**
     * {@inheritDoc}
     */
    public function match(Request $request): RouteInterface
    {
        return $this->urlMatcherFactory
            ->create()
            ->match($request);
    }

    /**
     * {@inheritDoc}
     */
    public function execute(Request $request, bool $flush = true): Response
    {
        return $this->routeExecutorFactory
            ->create()
            ->execute($request, $flush);
    }

    /**
     * {@inheritDoc}
     */
    public function generateUrlByRouteName(string $routeName, array|null $parameters = []): string
    {
        return $this->urlGeneratorFactory
            ->create()
            ->generateUrlByRouteName($routeName, $parameters);
    }
}
