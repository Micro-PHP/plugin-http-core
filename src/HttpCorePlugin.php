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

namespace Micro\Plugin\Http;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\ConfigurableInterface;
use Micro\Framework\Kernel\Plugin\DependencyProviderInterface;
use Micro\Framework\Kernel\Plugin\PluginConfigurationTrait;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpCorePlugin implements DependencyProviderInterface, ConfigurableInterface
{
    use PluginConfigurationTrait;

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(Container $container): void
    {
    }
}
