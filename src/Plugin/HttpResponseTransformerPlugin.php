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

namespace Micro\Plugin\Http\Plugin;

use Micro\Plugin\Http\Business\Response\Transformer\ResponseTransformerInterface;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
interface HttpResponseTransformerPlugin
{
    public function weight(): int;

    public function createTransformer(): ResponseTransformerInterface;
}
