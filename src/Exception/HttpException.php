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
class HttpException extends \RuntimeException
{
    private readonly Request|null $request;

    public function __construct(
        string $message = '',
        int $code = 0,
        Request $request = null,
        ?\Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->request = $request;
    }

    public function getRequest(): Request|null
    {
        return $this->request;
    }
}
