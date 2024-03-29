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

use Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Micro\Plugin\Http\Exception\HttpNotFoundException;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class UrlMatcher implements UrlMatcherInterface
{
    public function __construct(
        private RouteMatcherInterface $routeMatcher,
        private RouteCollectionInterface $routeCollection,
    ) {
    }

    public function match(Request $request): RouteInterface
    {
        foreach ($this->routeCollection->iterateRoutes() as $route) {
            if (!$this->routeMatcher->match($route, $request)) {
                continue;
            }

            return $route;
        }

        throw new HttpNotFoundException();
    }
}
