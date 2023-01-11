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

use Micro\Framework\Kernel\Configuration\PluginConfiguration;
use Micro\Plugin\Http\Configuration\HttpCorePluginConfigurationInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpCorePluginConfiguration extends PluginConfiguration implements HttpCorePluginConfigurationInterface
{
    public function getAccessLoggerName(): string
    {
        return 'default';
    }

    public function getErrorLoggerName(): string
    {
        return 'default';
    }

    public function getRouteLocatorType(): string
    {
        return 'code';
    }
}
