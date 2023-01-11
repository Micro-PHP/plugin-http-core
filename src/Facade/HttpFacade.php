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

namespace Micro\Plugin\Http\Facade;

use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteCollectionFactoryInterface;
use Micro\Plugin\Http\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class HttpFacade implements HttpFacadeInterface
{
    public function __construct(
        private UrlMatcherFactoryInterface $urlMatcherFactory,
        private RouteCollectionFactoryInterface $routeCollectionFactory
    )
    {

    }

    public function getDeclaredRoutesNames(): iterable
    {
        // TODO: Implement getDeclaredRoutesNames() method.
    }

    /**
     * {@inheritDoc}
     */
    public function match(Request $request = null): RouteInterface
    {
        return $this->urlMatcherFactory
            ->create()
            ->match($request);
    }
}