<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Exception;

use Micro\Plugin\Http\Exception\HttpException;
use PHPUnit\Framework\TestCase;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
abstract class AbstractHttpExceptionTest extends TestCase
{
    protected $message;

    protected $code;

    public function testConstruct()
    {
        $this->expectException(HttpException::class);
        $this->expectExceptionCode($this->code);
        $this->expectExceptionMessage($this->message);
    }
}
