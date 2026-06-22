<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Business\Route;

use Micro\Plugin\Http\Business\Route\RouteBuilder;
use Micro\Plugin\Http\Exception\RouteInvalidConfigurationException;
use PHPUnit\Framework\TestCase;

class RouteBuilderTest extends TestCase
{
    public const METHOD_DEFAULTS = [
        'GET', 'POST', 'PUT', 'PATCH', 'DELETE',
    ];

    /**
     * @dataProvider dataProvider
     */
    public function testBuild(
        string|null $routeName,
        callable|string|null $action,
        string|null $uri,
        string|null $pattern,
        array|null $methods,
        array|null $allowedException
    ): void {
        $builder = new RouteBuilder();

        if ($routeName) {
            $builder->setName($routeName);
        }

        if ($action) {
            $builder->setController($action);
        }

        if ($uri) {
            $builder->setUri($uri);
        }

        if ($methods) {
            $builder->setMethods($methods);
        }

        if ($allowedException) {
            $this->expectException($allowedException['class']);
        }

        try {
            $route = $builder->build();
        } catch (RouteInvalidConfigurationException $configurationException) {
            $this->assertNotEmpty($configurationException->getMessages());
            $this->assertEquals($allowedException['messages'], $configurationException->getMessages());

            throw $configurationException;
        }

        $this->assertEquals($action, $route->getController());
        $this->assertEquals($uri, $route->getUri());
        $this->assertEquals($methods ?: self::METHOD_DEFAULTS, $route->getMethods());
        $this->assertEquals($pattern, $route->getPattern());
        $this->assertEquals($routeName, $route->getName());
    }

    public static function dataProvider(): array
    {
        $emptyRouteAction = static function () {};

        return [
            'Correct minimal route: just action and uri' => [
                'routeName' => null,
                'action' => $emptyRouteAction,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => null,
            ],
            'Empty uri: null' => [
                'routeName' => null,
                'action' => $emptyRouteAction,
                'uri' => null,
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'Uri can not be empty.',
                    ],
                ],
            ],
            'Empty uri: empty string' => [
                'routeName' => null,
                'action' => $emptyRouteAction,
                'uri' => '',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'Uri can not be empty.',
                    ],
                ],
            ],
            'Invalid route name 1' => [
                'routeName' => '0invalid',
                'action' => $emptyRouteAction,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'The route name must match "[a-zA-Z][a-zA-Z0-9_]*".',
                    ],
                ],
            ],
            'Invalid route name 2' => [
                'routeName' => '.invalid',
                'action' => $emptyRouteAction,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'The route name must match "[a-zA-Z][a-zA-Z0-9_]*".',
                    ],
                ],
            ],
            'Invalid route name 3' => [
                'routeName' => 'invalid@again',
                'action' => $emptyRouteAction,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'The route name must match "[a-zA-Z][a-zA-Z0-9_]*".',
                    ],
                ],
            ],
            'Empty action' => [
                'routeName' => 'test',
                'action' => null,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'The route action can not be empty.',
                    ],
                ],
            ],
            'Class string action with route name' => [
                'routeName' => 'index',
                'action' => Action::class,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => null,
            ],
            'Class string action with route name null' => [
                'routeName' => null,
                'action' => Action::class,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'The route action should be callable. Examples: `[object, "method|<route_name>"], [Classname, "metnod|<routeName>"], Classname::method, Classname, function() {}` Current value: '.Action::class,
                    ],
                ],
            ],
            'Class string action with empty route name' => [
                'routeName' => '',
                'action' => Action::class,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'The route action should be callable. Examples: `[object, "method|<route_name>"], [Classname, "metnod|<routeName>"], Classname::method, Classname, function() {}` Current value: '.Action::class,
                    ],
                ],
            ],
            'All errors at the same time 1' => [
                'routeName' => '1invalid@',
                'action' => null,
                'uri' => null,
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'Uri can not be empty.',
                        'The route name must match "[a-zA-Z][a-zA-Z0-9_]*".',
                        'The route action can not be empty.',
                    ],
                ],
            ],
            'All errors at the same time 2' => [
                'routeName' => '',
                'action' => Action::class,
                'uri' => null,
                'pattern' => null,
                'methods' => null,
                'allowedException' => [
                    'class' => RouteInvalidConfigurationException::class,
                    'messages' => [
                        'Uri can not be empty.',
                        'The route action should be callable. Examples: `[object, "method|<route_name>"], [Classname, "metnod|<routeName>"], Classname::method, Classname, function() {}` Current value: '.Action::class,
                    ],
                ],
            ],
            'Correct GET route' => [
                'routeName' => 'test',
                'action' => $emptyRouteAction,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => ['GET'],
                'allowedException' => null,
            ],
            'Correct POST route' => [
                'routeName' => 'test',
                'action' => $emptyRouteAction,
                'uri' => '/uri',
                'pattern' => null,
                'methods' => ['POST'],
                'allowedException' => null,
            ],
            'Simple dynamic uri' => [
                'routeName' => 'test',
                'action' => $emptyRouteAction,
                'uri' => '/{test}',
                'pattern' => '/\/([a-zA-Z_][a-zA-Z0-9_]*)$/',
                'methods' => null,
                'allowedException' => null,
            ],
            'Simple dynamic uri with two placeholders' => [
                'routeName' => 'test',
                'action' => $emptyRouteAction,
                'uri' => '/{test}_{another_test}',
                'pattern' => '/\/([a-zA-Z_][a-zA-Z0-9_]*)_([a-zA-Z_][a-zA-Z0-9_]*)$/',
                'methods' => null,
                'allowedException' => null,
            ],
            'Placeholder with default value' => [
                'routeName' => 'test',
                'action' => $emptyRouteAction,
                'uri' => '/{page:0}',
                'pattern' => '/\/([a-zA-Z_][a-zA-Z0-9_]*)$/',
                'methods' => null,
                'allowedException' => null,
            ],
            // TODO: implement regex for placeholders
            // 'Placeholder with regex' => [
            //     'routeName' => 'test',
            //     'action' => $emptyRouteAction,
            //     'uri' => '/{page}',
            //     'placeholders_regex' => [
            //         'page' => '[1-9]\\d*'; // any number without leading zeros
            //     ],
            //     'pattern' => '/\/([a-zA-Z_][a-zA-Z_0-9]*)$/',
            //     'methods' => null,
            //     'allowedException' => null
            // ],
        ];
    }

    public function testClear()
    {
        $builder = new RouteBuilder();

        $routeA = $builder->setName('test')
            ->setController(function () {})
            ->setUri('/{test}.{_format}')
            ->setMethods(['POST'])
            ->build();

        $routeB = $builder->setController(function () {})
            ->setUri('/{test}.{_format}')
            ->setMethods(['POST'])
            ->build();

        $this->assertNotEquals($routeA->getName(), $routeB->getName());
    }
}

/**
 * @internal
 */
final class Action
{
    public function index()
    {
    }
}
