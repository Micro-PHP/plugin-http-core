<?php

require_once 'vendor/autoload.php';

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


function helloWorld()
{
    print_r('Hello, World!');
}

$routes = [
    [ 'video_get_info', '/video/{id}/{action}.{_format}', 'helloWorld', ],
    [ 'video_all', '/video/all', 'helloWorld', ],
    [ 'video_test', '/video/{test}.{_format}', 'helloWorld', ]
];

$routesCompiled = [];

$builder = new \Micro\Plugin\Http\Business\Route\RouteBuilder();
try {

    foreach ($routes as $item) {
        $routesCompiled[] = $builder
            ->setName($item[0])
            ->setUri($item[1])
            ->setAction($item[2])
            ->build();
    }

} catch (\Micro\Plugin\Http\Exception\RouteInvalidConfigurationException $exception) {
    print_r($exception->getMessage());

    foreach ($exception->getMessages() as $message) {
        print_r("\r\n  - " . $message);
    }

    print_r("\r\n");

    exit;

}

readonly class Locator implements \Micro\Plugin\Http\Business\Locator\RouteLocatorInterface {

    public function __construct(private iterable $routes)
    {

    }

    public function locate(): iterable
    {
        foreach ($this->routes as $route) {
            yield $route;
        }
    }
}

$request = \Symfony\Component\HttpFoundation\Request::create('/video/all');

$routeCollectionFactory = new \Micro\Plugin\Http\Business\Route\RouteCollectionFactory(
    new Locator($routesCompiled)
);

$routeMatcherFactory = new \Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherFactory();

$urlMatcherFactory = new \Micro\Plugin\Http\Business\Matcher\UrlMatcherFactory(
    $routeCollectionFactory,
    $routeMatcherFactory,
);

$route = $urlMatcherFactory->create()->match($request);

var_dump($route->getName());

call_user_func($route->getAction());

print_r($request->request->all());

