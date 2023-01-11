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

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface RouteInterface
{
    /**
     * @return string
     */
    public function getUri(): string;

    /**
     * @return string|null
     */
    public function getPattern(): string|null;

    /**
     * @return callable
     */
    public function getAction(): callable;

    /**
     * @return string[]
     */
    public function getMethods(): array;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return array|null
     */
    public function getParameters(): array|null;
}