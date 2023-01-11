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

namespace Micro\Plugin\Http\Business\Route;

use Micro\Plugin\Http\Business\Locator\RouteLocatorFactoryInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteCollectionFactory implements RouteCollectionFactoryInterface
{
    public function __construct(
        private RouteLocatorFactoryInterface $routeLocatorFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): RouteCollectionInterface
    {
        $collection = new RouteCollection();

        $locator = $this->routeLocatorFactory->create();
        foreach ($locator->locate() as $route) {
            $collection->addRoute($route);
        }

        return $collection;
    }
}
