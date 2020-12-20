<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use EmptyIterator;
use Generator;
use Iterator;
use LimitIterator;

/**
 * @psalm-template TKey
 * @psalm-template TKey of array-key
 * @psalm-template T
 */
final class Drop extends AbstractOperation
{
    /**
     * @psalm-return Closure(int...): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @psalm-return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static fn (int ...$offsets): Closure =>
                /**
                 * @psalm-param Iterator<TKey, T> $iterator
                 *
                 * @psalm-return Generator<TKey, T>
                 */
                static function (Iterator $iterator) use ($offsets): Generator {
                    if (!$iterator->valid()) {
                        return new EmptyIterator();
                    }

                    return yield from new LimitIterator($iterator, array_sum($offsets));
                };
    }
}
