<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Unit\Business\Executor;

use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Executor\RouteExecutor;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherInterface;
use Micro\Plugin\Http\Business\Response\ResponseCallbackFactoryInterface;
use Micro\Plugin\Http\Business\Response\ResponseCallbackInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Micro\Plugin\Http\Exception\HttpException;
use Micro\Plugin\Http\Exception\ResponseInvalidException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteExecutorTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testExecute(bool $isFlush, string|null $exceptionClass)
    {
        $containerRegistry = $this->createMock(ContainerRegistryInterface::class);
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);
        $exception = $exceptionClass ? new $exceptionClass(null) : null;

        if ($isFlush && !$exceptionClass) {
            $response
                ->expects($this->once())
                ->method('send');
        }

        $executor = new RouteExecutor(
            $this->createUrlMatcher($request),
            $containerRegistry,
            $this->createResponseCallbackFactory($response, $exception),
        );

        if ($exceptionClass) {
            $this->expectException(HttpException::class);
        }

        $response = $executor->execute($request);
        $this->assertInstanceOf(Response::class, $response);
    }

    public function dataProvider()
    {
        return [
            [true, null],
            [false, null],
            [false, ResponseInvalidException::class],
        ];
    }

    protected function createResponseCallbackFactory(Response $response, \Throwable|null $throwExceptionInCallback): ResponseCallbackFactoryInterface
    {
        $responseCallbackFactory = $this->createMock(ResponseCallbackFactoryInterface::class);
        $responseCallbackFactory
            ->expects($this->once())
            ->method('create')
            ->withAnyParameters()
            ->willReturn(
                new class($throwExceptionInCallback, $response) implements ResponseCallbackInterface {
                    public function __construct(
                        private readonly \Throwable|null $throwExceptionInCallback,
                        private readonly Response $response
                    ) {
                    }

                    public function __invoke(): Response
                    {
                        if ($this->throwExceptionInCallback) {
                            throw $this->throwExceptionInCallback;
                        }

                        return $this->response;
                    }
                }
            );

        return $responseCallbackFactory;
    }

    protected function createUrlMatcher(Request $request): UrlMatcherInterface
    {
        $route = $this->createMock(RouteInterface::class);
        $urlMatcher = $this->createMock(UrlMatcherInterface::class);
        $urlMatcher
            ->expects($this->once())
            ->method('match')
            ->with($request)
            ->willReturn($route)
        ;

        return $urlMatcher;
    }
}
