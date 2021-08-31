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
 */
final class Nth implements Operation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(int $step): Closure
    {
        return
            /**
             * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $offset) use ($step): Closure {
                $filterCallback =
                    /**
                     * @param array{0: TKey, 1: T} $value
                     */
                    static fn (array $value, int $key): bool => (($key % $step) === $offset);

                return Pipe::ofTyped3(
                    (new Pack())(),
                    (new Filter())($filterCallback),
                    (new Unpack())()
                );
            };
    }
}
