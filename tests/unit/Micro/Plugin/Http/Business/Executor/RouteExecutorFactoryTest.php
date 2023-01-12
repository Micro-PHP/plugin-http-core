<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Component\DependencyInjection\Autowire\AutowireHelperFactoryInterface;
use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;
use PHPUnit\Framework\TestCase;

class RouteExecutorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $routeExecutorFactory = new RouteExecutorFactory(
            $this->createMock(UrlMatcherFactoryInterface::class),
            $this->createMock(ContainerRegistryInterface::class),
            $this->createMock(AutowireHelperFactoryInterface::class),
        );

        $this->assertInstanceOf(
            RouteExecutorInterface::class,
            $routeExecutorFactory->create(),
        );
    }
}
