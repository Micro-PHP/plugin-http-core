<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Locator;

use Micro\Framework\Kernel\Configuration\ApplicationConfigurationInterface;
use Micro\Framework\Kernel\KernelInterface;
use Micro\Plugin\Http\HttpCorePluginConfiguration;
use Micro\Plugin\Http\Plugin\HttpRouteLocatorPluginInterface;
use PHPUnit\Framework\TestCase;

class RouteLocatorFactoryTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     *
     * @return void
     */
    public function testCreate(string $alias, string|null $allowedException)
    {
        $routeLocatorFactory = new RouteLocatorFactory(
            $this->createKernel($alias, (bool) $allowedException),
            $this->createConfiguration(),
        );

        if ($allowedException) {
            $this->expectException($allowedException);
        }

        $routeLocator = $routeLocatorFactory->create();

        $this->assertInstanceOf(RouteLocatorInterface::class, $routeLocator);
    }

    protected function createConfiguration(): HttpCorePluginConfiguration
    {
        $stub = $this->createMock(ApplicationConfigurationInterface::class);

        return new HttpCorePluginConfiguration($stub);
    }

    protected function createKernel(string $locatorAlias, bool $isLocatorNotFound): KernelInterface
    {
        $stubKernel = $this->createMock(KernelInterface::class);
        $stubLocator = $this->createMock(HttpRouteLocatorPluginInterface::class);

        $stubLocator
            ->expects($this->once())
            ->method('getLocatorType')
            ->willReturn($locatorAlias);

        if (!$isLocatorNotFound) {
            $stubLocator
                ->expects($this->once())
                ->method('createLocator')
                ->willReturn(
                    $this->createMock(RouteLocatorInterface::class)
                );
        }

        $stubKernel
            ->expects($this->once())
            ->method('plugins')
            ->with(HttpRouteLocatorPluginInterface::class)
            ->willReturn([$stubLocator]);

        return $stubKernel;
    }

    protected function dataProvider()
    {
        return [
            ['code', null],
            ['test', \RuntimeException::class],
        ];
    }
}
