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

namespace Micro\Plugin\Http\Business\Executor;

use Micro\Component\DependencyInjection\ContainerRegistryInterface;
use Micro\Plugin\Http\Business\Matcher\UrlMatcherFactoryInterface;
use Micro\Plugin\Http\Business\Response\Callback\ResponseCallbackFactoryInterface;
use Micro\Plugin\Http\Business\Response\Transformer\ResponseTransformerFactoryInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class RouteExecutorFactory implements RouteExecutorFactoryInterface
{
    public function __construct(
        private UrlMatcherFactoryInterface $urlMatcherFactory,
        private ContainerRegistryInterface $containerRegistry,
        private ResponseCallbackFactoryInterface $responseCallbackFactory,
        private ResponseTransformerFactoryInterface $responseTransformerFactory
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function create(): RouteExecutorInterface
    {
        return new RouteExecutor(
            $this->urlMatcherFactory->create(),
            $this->containerRegistry,
            $this->responseCallbackFactory,
            $this->responseTransformerFactory
        );
    }
}
