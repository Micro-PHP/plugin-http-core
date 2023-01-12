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

namespace Micro\Plugin\Http\Business\Response;

use Micro\Plugin\Http\Exception\HttpException;
use Micro\Plugin\Http\Exception\ResponseInvalidException;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface ResponseCallbackInterface
{
    /**
     * @throws ResponseInvalidException
     * @throws HttpException
     */
    public function __invoke(): Response;
}
