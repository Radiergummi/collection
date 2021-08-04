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

/**
 * @immutable
 *
 * @template TKey
 * @template T
 */
final class Column extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(mixed): Closure(Iterator<TKey, T>): Generator<int, mixed>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param mixed $column
             *
             * @return Closure(Iterator<TKey, T>): Generator<int, mixed>
             */
            static function ($column): Closure {
                /** @var Closure(Iterator<TKey, T>): Generator<int, iterable<TKey, T>> $pipe */
                $pipe = Pipe::of()(
                    Transpose::of(),
                    Filter::of()(
                        static fn ($value, $key): bool => $key === $column
                    ),
                    Head::of(),
                    Flatten::of()(1)
                );

                // Point free style.
                return $pipe;
            };
    }
}
