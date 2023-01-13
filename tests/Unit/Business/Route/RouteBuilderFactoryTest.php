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

use Micro\Plugin\Http\Business\Route\RouteBuilderFactory;
use Micro\Plugin\Http\Business\Route\RouteBuilderInterface;
use PHPUnit\Framework\TestCase;

class RouteBuilderFactoryTest extends TestCase
{
    public function testCreate()
    {
        $routeBuilderFactory = new RouteBuilderFactory();

        $this->assertInstanceOf(RouteBuilderInterface::class, $routeBuilderFactory->create());
    }
}
