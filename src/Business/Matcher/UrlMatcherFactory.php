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

namespace Micro\Plugin\Http\Business\Matcher;

use Micro\Plugin\Http\Business\Matcher\Route\RouteMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactoryInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class UrlMatcherFactory implements UrlMatcherFactoryInterface
{
    /**
     * @param RouteCollectionFactoryInterface $routeCollectionFactory
     * @param RouteMatcherFactoryInterface $routeMatcherFactory
     */
    public function __construct(
        private RouteCollectionFactoryInterface $routeCollectionFactory,
        private RouteMatcherFactoryInterface $routeMatcherFactory
    )
    {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): UrlMatcherInterface
    {
        return new UrlMatcher(
            $this->routeMatcherFactory->create(),
            $this->routeCollectionFactory->create(),
        );
    }
}