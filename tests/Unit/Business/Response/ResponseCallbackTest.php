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

use Micro\Component\DependencyInjection\Autowire\AutowireHelperInterface;
use Micro\Plugin\Http\Business\Response\ResponseCallback;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ResponseCallbackTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testInvoke(mixed $callable)
    {
        $route = $this->createMock(RouteInterface::class);
        $route
            ->expects($this->once())
            ->method('getController')
            ->willReturn($callable);

        $autowireHelper = $this->createMock(AutowireHelperInterface::class);
        $autowireHelper->expects($this->any())
            ->method('autowire')
            ->willReturn(fn () => new Response());

        $responseCallback = new ResponseCallback(
            $autowireHelper,
            $route,
        );

        $this->assertInstanceOf(Response::class, $responseCallback());
    }

    public function dataProvider()
    {
        return [
            [
                function () {},
            ],
            [
                CallbackTest::class,
            ],
            [
                CallbackTest::class, 'helloWithResponse',
            ],
            [
                CallbackTest::class.'::helloWithResponse',
            ],
            [
                new CallbackTest(), 'helloWithResponse',
            ],
        ];
    }
}
