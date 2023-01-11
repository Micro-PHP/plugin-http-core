<?php

declare(strict_types=1);

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Business\Router;

use Micro\Plugin\Http\Business\Route\RouteCollection;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class Router
{
    public function __construct(
        RouteCollection $routeCollection
    )
    {
    }

    /**
     * @param Request $request
     *
     * @return RouteInterface
     */
    public function match(Request $request): RouteInterface
    {
        $uri = $request->getUri();
        $method = $request->getMethod();
    }
}