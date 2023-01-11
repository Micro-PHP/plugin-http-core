<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Matcher\Route;

use PHPUnit\Framework\TestCase;

class RouteMatcherFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new RouteMatcherFactory();

        $this->assertInstanceOf(RouteMatcherInterface::class, $factory->create());
    }
}
