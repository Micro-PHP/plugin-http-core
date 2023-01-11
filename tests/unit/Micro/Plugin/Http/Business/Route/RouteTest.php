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

use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    const URI = '/{test}';
    const PARAMS = ['test'];

    const PATTERN = '/\/(.[aA-zZ]+)/';

    const METHODS = ['GET', 'POST'];

    const NAME = 'test';

    private RouteInterface $route;

    public function setUp(): void
    {
        $this->route = new Route(
            self::URI,
            function() { return 1; },
            self::METHODS,
            self::NAME,
            self::PATTERN,
            self::PARAMS,
        );
    }

    public function testGetUri()
    {
        $this->assertEquals(self::URI, $this->route->getUri());
    }

    public function testGetParameters()
    {
        $this->assertEquals(self::PARAMS, $this->route->getParameters());
    }

    public function testGetAction()
    {
        $action = $this->route->getAction();
        $this->assertIsCallable($action);

        $this->assertEquals(1, call_user_func($action));

    }

    public function testGetPattern()
    {
        $this->assertEquals(self::PATTERN, $this->route->getPattern());
    }

    public function testGetMethods()
    {
        $this->assertEquals(self::METHODS, $this->route->getMethods());
    }

    public function testGetName()
    {
        $this->assertEquals(self::NAME, $this->route->getName());
    }
}
