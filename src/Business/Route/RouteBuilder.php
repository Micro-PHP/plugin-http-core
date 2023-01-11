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

use Micro\Plugin\Http\Exception\RouteInvalidConfigurationException;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteBuilder
{
    private string|null $name;

    /**
     * @var callable|null
     */
    private mixed $action;

    private string|null $uri;

    /**
     * @var array|string[]
     */
    private array $methods;

    /**
     * @param string[] $methodsByDefault
     */
    public function __construct(
        private readonly array $methodsByDefault = [
            'PUT', 'POST', 'PATCH', 'GET', 'DELETE',
        ],
    ) {
        $this->name = null;
        $this->action = null;
        $this->uri = null;
        $this->methods = $this->methodsByDefault;
    }

    /**
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return $this
     */
    public function addMethod(string $method): self
    {
        if (!\in_array($method, $this->methods)) {
            $this->methods[] = mb_strtoupper($method);
        }

        return $this;
    }

    /**
     * @param string[] $methods
     *
     * @return $this
     */
    public function setMethods(array $methods): self
    {
        $this->methods = [];

        foreach ($methods as $method) {
            $this->addMethod($method);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function setAction(callable $action): self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @return $this
     */
    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * TODO: Move pattern builder to separate class.
     *
     * @throws RouteInvalidConfigurationException
     */
    public function build(): RouteInterface
    {
        $exceptions = [];
        $routeName = $this->name ?: $this->uri ?: 'Unnamed_'.rand();

        if (!$this->uri) {
            $exceptions[] = 'Path can not be empty';
        }

        if (!$this->action) {
            $exceptions[] = 'The route action can not be empty and should be callable.';
        }

        if ($this->action && !\is_callable($this->action)) {
            $exceptions[] = 'The route action should be callable. Current value: '.$this->action;
        }

        if (!\count($this->methods)) {
            $exceptions[] = 'The route should be contain one or more methods from %s::class.';
        }

        if (\count($exceptions)) {
            throw new RouteInvalidConfigurationException($routeName, $exceptions);
        }

        $pattern = null;
        $parameters = null;
        /** @psalm-suppress PossiblyNullArgument */
        $isDynamic = preg_match_all('/\{\s*([^}\s]*)\s*\}/', $this->uri, $matches);
        if ($isDynamic) {
            $parameters = $matches[1];
            /** @psalm-suppress PossiblyNullArgument */
            $pattern = '/'.addcslashes($this->uri, '/.').'/';

            foreach ($matches[0] as $replaced) {
                $pattern = str_replace($replaced, '(.[aA-zZ0-9-_]+)', $pattern);
            }
        }
        /**
         * @psalm-suppress PossiblyNullArgument
         * @psalm-suppress MixedArgumentTypeCoercion
         */
        $route = new Route(
            $this->uri,
            $this->action,
            $this->methods,
            $routeName,
            $pattern,
            $parameters
        );

        $this->clear();

        return $route;
    }

    protected function clear(): void
    {
        $this->uri = null;
        $this->action = null;
        $this->methods = $this->methodsByDefault;
    }
}
