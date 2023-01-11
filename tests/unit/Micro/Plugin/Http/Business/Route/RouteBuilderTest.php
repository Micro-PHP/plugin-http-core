<?php

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Micro\Plugin\Http\Business\Route;

use Micro\Plugin\Http\Exception\RouteInvalidConfigurationException;
use PHPUnit\Framework\TestCase;

class RouteBuilderTest extends TestCase
{

    const METHOD_DEFAULTS = [
        'PUT', 'POST', 'PATCH', 'GET', 'DELETE'
    ];

    /**
     * @dataProvider dataProvider
     *
     * @param callable|null $action
     * @param string|null $uri
     * @param array|null $methods
     *
     * @return void
     */
    public function testBuild(
        callable|null $action,
        string|null $uri,
        string|null $pattern,
        array|null $methods,
        string|null $allowedException
    )
    {
        $builder = new RouteBuilder();

        if($action) {
            $builder->setAction($action);
        }

        if($uri) {
            $builder->setUri($uri);
        }

        if($methods) {
            $builder->setMethods($methods);
        }

        if($allowedException) {
            $this->expectException($allowedException);
        }

        $route = $builder->build();

        if($allowedException) {
            return;
        }

        $this->assertIsCallable($route->getAction());
        $this->assertEquals($uri, $route->getUri());
        $this->assertEquals($methods ?: self::METHOD_DEFAULTS, $route->getMethods());
        $this->assertEquals($pattern, $route->getPattern());

    }

    public function dataProvider()
    {
        return [
            [ function() {}, '/{test}.{_format}', '/\/(.[aA-zZ0-9-_]+)\.(.[aA-zZ0-9-_]+)/', ['POST'], null ],
            [ function() {}, '/{test}.{_format}', '/\/(.[aA-zZ0-9-_]+)\.(.[aA-zZ0-9-_]+)/', null, null,],
            [ null, '/{test}.{_format}', null, null, RouteInvalidConfigurationException::class],
            [ function() {}, '/test', null, null, null,],
            [ function() {}, null, null, null, RouteInvalidConfigurationException::class ],
        ];
    }
}
