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

namespace Micro\Plugin\Http\Test\Unit;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginDependedInterface;
use Micro\Plugin\Http\Business\Locator\RouteLocatorInterface;
use Micro\Plugin\Http\Business\Response\Transformer\ResponseTransformerInterface;
use Micro\Plugin\Http\Exception\HttpBadRequestException;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use Micro\Plugin\Http\HttpCorePlugin;
use Micro\Plugin\Http\Plugin\HttpResponseTransformerPlugin;
use Micro\Plugin\Http\Plugin\HttpRouteLocatorPluginInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class TestPlugin implements DependencyProviderInterface, HttpResponseTransformerPlugin, HttpRouteLocatorPluginInterface, PluginDependedInterface
{
    private Container $container;

    public function weight(): int
    {
        return 10;
    }

    public function createTransformer(): ResponseTransformerInterface
    {
        return new class() implements ResponseTransformerInterface {
            public function transform(Request $request, Response $response, mixed &$responseData): bool
            {
                if ('success' === $responseData) {
                    $response->setContent($responseData);

                    return true;
                }

                if ($responseData instanceof \RuntimeException) {
                    $response->setContent($responseData->getMessage());

                    return true;
                }

                if ('exception' === $responseData) {
                    throw new \Exception($responseData);
                }

                return false;
            }
        };
    }

    public function getLocatorType(): string
    {
        return 'code';
    }

    public function test(Request $request)
    {
        $parameter = $request->get('parameter');
        if ('runtime_transformed' === $parameter) {
            throw new \RuntimeException($parameter);
        }

        if ('bad_request' === $parameter) {
            throw new HttpBadRequestException($request);
        }

        return $parameter;
    }

    public function createLocator(): RouteLocatorInterface
    {
        return new class($this->container) implements RouteLocatorInterface {
            public function __construct(private Container $container)
            {
            }

            public function locate(): iterable
            {
                yield $this->container->get(HttpFacadeInterface::class)
                    ->createRouteBuilder()
                    ->setUri('/{parameter}')
                    ->setName('test')
                    ->setController(TestPlugin::class)
                    ->build()
                ;
            }
        };
    }

    public function provideDependencies(Container $container): void
    {
        $this->container = $container;
    }

    public function getDependedPlugins(): iterable
    {
        return [
            HttpCorePlugin::class,
        ];
    }
}
