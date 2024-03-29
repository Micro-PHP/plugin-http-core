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

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class Route implements RouteInterface
{
    /**
     * @param array<class-string, string|null>|class-string|\Closure|object $controller
     *
     * @phpstan-ignore-next-line
     */
    public function __construct(
        private string $uri,
        private string|array|object $controller,
        private array $methods,
        private string|null $name,
        private string|null $pattern = null,
        private array|null $parameters = null
    ) {
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getController(): callable|string|array|object
    {
        return $this->controller;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getName(): string|null
    {
        return $this->name;
    }

    public function getPattern(): string|null
    {
        return $this->pattern;
    }

    public function getParameters(): array|null
    {
        return $this->parameters;
    }
}
