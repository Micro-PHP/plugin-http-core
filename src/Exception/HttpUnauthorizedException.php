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

namespace Micro\Plugin\Http\Exception;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpUnauthorizedException extends HttpException
{
    public function __construct(string $message = 'Unauthorized.', \Throwable $previous = null)
    {
        parent::__construct($message, 401, $previous);
    }
}
