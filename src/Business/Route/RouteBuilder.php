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

namespace Micro\Plugin\Http\Business\Route;

use Micro\Plugin\Http\Exception\RouteInvalidConfigurationException;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
class RouteBuilder
{
    private string|null $name;
    private string|\Closure|null $action;
    private string|null $uri;
    private array $methods;

    public function __construct(
        private readonly array $methodsByDefault = [
            'PUT', 'POST', 'PATCH', 'GET', 'DELETE'
        ],
    )
    {
        $this->name = null;
        $this->action = null;
        $this->uri = null;
        $this->methods = $this->methodsByDefault;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addMethod(string $method): self
    {
        if(!in_array($method, $this->methods)) {
            $this->methods[] = mb_strtoupper($method);
        }

        return $this;
    }

    public function setMethods(array $methods): self
    {
        $this->methods = [];

        foreach ($methods as $method) {
            $this->addMethod($method);
        }

        return $this;
    }

    public function setAction(string|\Closure $action): self
    {
        $this->action = $action;

        return $this;
    }

    public function setUri(string $uri): self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * TODO: Move pattern builder to separate class
     *
     * @return RouteInterface
     *
     * @throws RouteInvalidConfigurationException
     */
    public function build(): RouteInterface
    {
        $exceptions = [];
        if(!$this->uri) {
            $exceptions[] = 'Path can not be empty';
        }

        if(!$this->action) {
            $exceptions[] = 'The route action can not be empty and should be callable.';
        }

        if($this->action && !is_callable($this->action)) {
            $exceptions[] = 'The route action should be callable. Current value: ' . $this->action;
        }

        if(!count($this->methods)) {
            $exceptions[] = 'The route should be contain one or more methods from %s::class.';
        }

        if(count($exceptions)) {
            throw new RouteInvalidConfigurationException(
                ($this->name ?: $this->uri ?: 'Undefined'),
                $exceptions
            );
        }


        $pattern = null;
        $parameters = null;

        $isDynamic = preg_match_all('/\{\s*([^}\s]*)\s*\}/', $this->uri, $matches);
        if($isDynamic) {

            var_dump($isDynamic, $this->name);

            $parameters = $matches[1];
            $pattern = '/' . addcslashes($this->uri, '/.') . '/';

            foreach ($matches[0] as $replaced) {
                $pattern = str_replace($replaced, '(.[aA-zZ0-9-_]+)', $pattern);
            }
        }

        $route =  new Route(
            $this->uri,
            $this->action,
            $this->methods,
            $this->name ?: $this->uri,
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