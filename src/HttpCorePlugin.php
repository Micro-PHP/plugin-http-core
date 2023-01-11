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

namespace Micro\Plugin\Http;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Framework\Kernel\Plugin\ConfigurableInterface;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginConfigurationTrait;
use Micro\Plugin\Http\Business\Locator\RouteLocatorFactory;
use Micro\Plugin\Http\Business\Locator\RouteLocatorFactoryInterface;
use Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherFactory;
use Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactory;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactory;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactoryInterface;
use Micro\Plugin\Http\Configuration\HttpCorePluginConfigurationInterface;
use Micro\Plugin\Http\Facade\HttpFacade;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 *
 * @method HttpCorePluginConfigurationInterface configuration()
 */
class HttpCorePlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    private KernelInterface $kernel;

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(Container $container): void
    {
        $container->register(HttpFacadeInterface::class, function (
            KernelInterface $kernel
        ) {
            $this->kernel = $kernel;

            return $this->createFacade();
        });
    }

    protected function createFacade(): HttpFacadeInterface
    {
        $routeCollectionFactory = $this->createRouteCollectionFactory();
        $routeMatcherFactory = $this->createRouteMatcherFactory();

        $urlMatcherFactory = $this->createUrlMatcherFactory(
            $routeCollectionFactory,
            $routeMatcherFactory
        );

        return new HttpFacade(
            $urlMatcherFactory,
            $routeCollectionFactory
        );
    }

    protected function createRouteMatcherFactory(): RouteMatcherFactoryInterface
    {
        return new RouteMatcherFactory();
    }

    protected function createUrlMatcherFactory(
        RouteCollectionFactoryInterface $routeCollectionFactory,
        RouteMatcherFactoryInterface $routeMatcherFactory
    ): UrlMatcherFactoryInterface {
        return new UrlMatcherFactory(
            $routeCollectionFactory,
            $routeMatcherFactory
        );
    }

    /**
     * @throws \RuntimeException
     */
    protected function createRouteCollectionFactory(): RouteCollectionFactoryInterface
    {
        return new RouteCollectionFactory(
            $this->createRouteLocatorFactory()
        );
    }

    protected function createRouteLocatorFactory(): RouteLocatorFactoryInterface
    {
        return new RouteLocatorFactory(
            $this->kernel,
            $this->configuration()
        );
    }
}
