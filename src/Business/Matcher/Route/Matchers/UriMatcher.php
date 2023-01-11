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

namespace Micro\Plugin\Http\Business\Matcher\Route\Matchers;

use Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class UriMatcher implements RouteMatcherInterface
{
    /**
     * {@inheritDoc}
     */
    public function match(RouteInterface $route, Request $request): bool
    {
        $uri = $request->getRequestUri();
        $pattern = $route->getPattern();
        if(!$pattern) {
            return $uri === $route->getUri();
        }

        $matched = preg_match_all($pattern, $request->getUri(), $matches);

        if($matched === 0) {
            return false;
        }

        $i = 0;
        foreach ($route->getParameters() as $parameter) {
            $request->request->set($parameter, $matches[++$i][0]);
        }

        return true;
    }
}