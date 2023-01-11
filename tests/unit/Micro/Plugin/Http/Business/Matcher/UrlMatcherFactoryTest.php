<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Matcher;

use Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactoryInterface;
use PHPUnit\Framework\TestCase;

class UrlMatcherFactoryTest extends TestCase
{
    public function testCreate()
    {
        $factory = new UrlMatcherFactory(
            $this->createMock(RouteCollectionFactoryInterface::class),
            $this->createMock(RouteMatcherFactoryInterface::class)
        );

        $this->assertInstanceOf(UrlMatcherInterface::class, $factory->create());
    }
}
