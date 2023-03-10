<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Business\Generator;

use Micro\Plugin\Http\Business\Generator\UrlGeneratorFactory;
use Micro\Plugin\Http\Business\Generator\UrlGeneratorInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactoryInterface;
use PHPUnit\Framework\TestCase;

class UrlGeneratorFactoryTest extends TestCase
{
    public function testCreate()
    {
        $urlGeneratorFactory = new UrlGeneratorFactory(
            $this->createMock(RouteCollectionFactoryInterface::class),
        );

        $this->assertInstanceOf(UrlGeneratorInterface::class, $urlGeneratorFactory->create());
    }
}
