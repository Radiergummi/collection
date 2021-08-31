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
use loophp\collection\Contract\Operation;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class FoldLeft implements Operation
{
    /**
     * @pure
     *
     * @template V
     *
     * @param callable((T|V)=, T=, TKey=, Iterator<TKey, T>=): V $callback
     *
     * @return Closure(V): Closure(Iterator<TKey, T>): Generator<int|TKey, T|V>
     */
    public function __invoke(callable $callback): Closure
    {
        return
            /**
             * @param V $initial
             *
             * @return Closure(Iterator<TKey, T>): Generator<int|TKey, T|V>
             */
            static function ($initial = null) use ($callback): Closure {
                return Pipe::ofTyped2(
                    (new ScanLeft())($callback)($initial),
                    (new Last())
                );
            };
    }
}
