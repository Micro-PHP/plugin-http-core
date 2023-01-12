<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Unit\Business\Response;

use Micro\Component\DependencyInjection\Autowire\AutowireHelperFactoryInterface;
use Micro\Plugin\Http\Business\Response\ResponseCallbackFactory;
use Micro\Plugin\Http\Business\Response\ResponseCallbackInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;

class ResponseCallbackFactoryTest extends TestCase
{
    public function testCreate()
    {
        $responseCallbackFactory = new ResponseCallbackFactory(
            $this->createMock(AutowireHelperFactoryInterface::class),
        );

        $route = $this->createMock(RouteInterface::class);

        $callback = $responseCallbackFactory->create($route);

        $this->assertInstanceOf(ResponseCallbackInterface::class, $callback);
    }
}
