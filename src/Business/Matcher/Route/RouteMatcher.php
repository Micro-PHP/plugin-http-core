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

namespace Micro\Plugin\Http\Business\Matcher\Route;

use Micro\Plugin\Http\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteMatcher implements RouteMatcherInterface
{
    /**
     * @param RouteMatcherInterface[] $matchers
     */
    public function __construct(
        private iterable $matchers
    ) {
    }

    public function match(RouteInterface $route, Request $request): bool
    {
        foreach ($this->matchers as $matcher) {
            if (!$matcher->match($route, $request)) {
                return false;
            }
        }

        return true;
    }
}
