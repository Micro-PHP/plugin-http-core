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

namespace Micro\Plugin\Http\Business\Matcher;

use Micro\Plugin\Http\Business\Route\RouteInterface;
use Micro\Plugin\Http\Exception\HttpException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface UrlMatcherInterface
{
    /**
     * @throws HttpException
     */
    public function match(Request $request): RouteInterface;
}
