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

use phpDocumentor\Reflection\DocBlock\Tags\Throws;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteNotFoundException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @param string $routeName
     * @return void
     *
     * @throws RouteNotFoundException
     */
    public static function throwsRouteNotFoundByName(string $routeName): void
    {
        throw new self(sprintf('Route "%s" not registered.', $routeName));
    }
}