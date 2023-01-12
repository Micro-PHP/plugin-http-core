<?php

require_once 'vendor/autoload.php';

/**
 * This file is part of the Micro framework package.
 *
 * (c) Stanislau Komar <kost@micro-php.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


$config = new \Micro\Framework\Kernel\Configuration\DefaultApplicationConfiguration([]);

$kernel = new \Micro\Kernel\App\AppKernel(
    $config,
    [
        App\TestPlugin::class,
        Micro\Plugin\Locator\LocatorPlugin::class,
        Micro\Plugin\Http\HttpCorePlugin::class,
        Micro\Plugin\Http\HttpRouterCodePlugin::class,
    ],
    'dev',
);

$kernel->run();

$request = \Symfony\Component\HttpFoundation\Request::create('/test');

$kernel->container()->get(\Micro\Plugin\Http\Facade\HttpFacadeInterface::class)
    ->execute($request);