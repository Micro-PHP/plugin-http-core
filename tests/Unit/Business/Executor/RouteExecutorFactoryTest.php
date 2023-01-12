<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Business\Executor;

use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Executor\RouteExecutorFactory;
use Micro\Plugin\Http\Business\Executor\RouteExecutorInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Response\ResponseCallbackFactoryInterface;
use PHPUnit\Framework\TestCase;

class RouteExecutorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $routeExecutorFactory = new RouteExecutorFactory(
            $this->createMock(UrlMatcherFactoryInterface::class),
            $this->createMock(ContainerRegistryInterface::class),
            $this->createMock(ResponseCallbackFactoryInterface::class),
        );

        $this->assertInstanceOf(
            RouteExecutorInterface::class,
            $routeExecutorFactory->create(),
        );
    }
}
