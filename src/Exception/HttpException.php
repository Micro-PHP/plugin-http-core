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

namespace Micro\Plugin\Http\Exception;

use Micro\Plugin\Http\Business\Route\RouteInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class HttpException extends \RuntimeException
{
    private readonly RouteInterface|null $route;

    private readonly Request|null $request;

    public function __construct(
        string $message = '',
        int $code = 0,
        Request $request = null,
        RouteInterface|null $route = null,
        ?\Throwable $previous = null
    )
    {
        parent::__construct($message, $code, $previous);

        $this->route = $route;
    }

    /**
     * @return RouteInterface|null
     */
    public function getRoute(): RouteInterface|null
    {
        return $this->route;
    }

    /**
     * @return Request|null
     */
    public function getRequest(): Request|null
    {
        return $this->request;
    }
}