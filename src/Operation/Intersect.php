<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use Iterator;
use loophp\fpt\FPT;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Intersect extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(T...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param T ...$values
             *
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (...$values): Closure {
                /** @psalm-var Closure(Iterator<TKey, T>): Generator<TKey, T> $filter */
                $filter = Filter::of()(
                    FPT::compose()(
                        FPT::partialLeft()(
                            'in_array'
                        )($values, true),
                        FPT::arg()(0)
                    )
                );

                // Point free style.
                return $filter;
            };
    }
}
