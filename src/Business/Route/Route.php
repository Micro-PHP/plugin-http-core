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
     * @var callable
     */
    private mixed $action;

    /**
     * @param string[]      $methods
     * @param string|null   $pattern
     * @param string[]|null $parameters
     */
    public function __construct(
        private string $uri,
        callable $action,
        private array $methods,
        private string $name,
        private string|null $pattern = null,
        private array|null $parameters = null
    ) {
        $this->action = $action;
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
