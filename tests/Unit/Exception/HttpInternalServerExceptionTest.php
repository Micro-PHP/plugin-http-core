<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit\Exception;

use Micro\Plugin\Http\Exception\HttpInternalServerException;

class HttpInternalServerExceptionTest extends AbstractHttpExceptionTest
{
    public function testConstruct()
    {
        $this->code = 500;
        $this->message = 'Internal Server Error.';

        parent::testConstruct();

        throw new HttpInternalServerException();
    }
}
