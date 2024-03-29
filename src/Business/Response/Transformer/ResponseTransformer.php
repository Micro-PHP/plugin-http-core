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

namespace Micro\Plugin\Http\Business\Response\Transformer;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Stanislau Komar <kost@micro-php.net>
 */
readonly class ResponseTransformer implements ResponseTransformerInterface
{
    /**
     * @param iterable<ResponseTransformerInterface> $responseTransformersCollection
     */
    public function __construct(
        private iterable $responseTransformersCollection
    ) {
    }

    public function transform(Request $request, Response $response, mixed &$responseData): bool
    {
        $transformed = false;

        foreach ($this->responseTransformersCollection as $responseTransformer) {
            $isTransformed = $responseTransformer->transform($request, $response, $responseData);
            if (false === $isTransformed) {
                continue;
            }

            $transformed = true;
        }

        return $transformed;
    }
}
