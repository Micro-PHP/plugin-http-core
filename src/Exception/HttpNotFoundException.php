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

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpNotFoundException extends HttpException
{
    public function __construct(Request $request, string $message = 'Not Found.', int $code = 404, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $request, null, $previous);
    }
}
