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

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Component\DependencyInjection\Autowire\AutowireHelperFactoryInterface;
use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteExecutorFactory implements RouteExecutorFactoryInterface
{
    /**
     * @param UrlMatcherFactoryInterface $urlMatcherFactory
     * @param ContainerRegistryInterface $containerRegistry
     * @param AutowireHelperFactoryInterface $autowireHelperFactory
     */
    public function __construct(
        private UrlMatcherFactoryInterface $urlMatcherFactory,
        private ContainerRegistryInterface $containerRegistry,
        private AutowireHelperFactoryInterface $autowireHelperFactory
    )
    {

    }

    /**
     * {@inheritDoc}
     */
    public function create(): RouteExecutorInterface
    {
        return new RouteExecutor(
            $this->urlMatcherFactory->create(),
            $this->containerRegistry,
            $this->autowireHelperFactory->create(),
        );
    }
}