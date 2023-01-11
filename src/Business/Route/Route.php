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

use Micro\Plugin\Http\Business\Route\RouteInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class Route implements RouteInterface
{
    /**
     * @param string $uri
     * @param string|\Closure $action
     * @param string[] $methods
     * @param string $name
     * @param string|null $pattern
     * @param string[]|null $parameters
     */
    public function __construct(
        private string          $uri,
        private string|\Closure $action,
        private array           $methods,
        private string          $name,
        private string|null     $pattern = null,
        private array|null      $parameters = null
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * {@inheritDoc}
     */
    public function getAction(): callable
    {
        return $this->action;
    }

    /**
     * {@inheritDoc}
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getPattern(): string|null
    {
        return $this->pattern;
    }

    /**
     * {@inheritDoc}
     */
    public function getParameters(): array|null
    {
        return $this->parameters;
    }
}
