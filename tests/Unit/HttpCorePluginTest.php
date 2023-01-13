<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Http\Test\Unit;

use Micro\Framework\Kernel\Configuration\DefaultApplicationConfiguration;
use Micro\Kernel\App\AppKernel;
use Micro\Plugin\Http\Exception\HttpException;
use Micro\Plugin\Http\Facade\HttpFacadeInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class HttpCorePluginTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testPlugin(string $parameter)
    {
        $config = new DefaultApplicationConfiguration([]);

        $kernel = new AppKernel(
            $config,
            [
                TestPlugin::class,
            ],
            'dev',
        );

        $kernel->run();
        $request = Request::create('/'.$parameter);

        $exceptedException = !\in_array($parameter, ['success', 'runtime_transformed']);

        if ($exceptedException) {
            $this->expectException(HttpException::class);
        }

        try {
            $response = $kernel
                ->container()
                ->get(HttpFacadeInterface::class)
                ->execute($request);
        } catch (HttpException $exception) {
            throw $exception;
        }

        $this->assertEquals($response->getContent(), $parameter);
    }

    public function dataProvider()
    {
        return [
            ['success'],
            ['runtime_transformed'],
            ['exception'],
            ['bad_request'],
            ['null'],
        ];
    }
}
