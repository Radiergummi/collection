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
final class Random extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(int): Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @return Closure(int): Closure(Iterator<TKey, T>): Generator<TKey, T>
             */
            static function (int $seed): Closure {
                return
                    /**
                     * @return Closure(Iterator<TKey, T>): Generator<TKey, T>
                     */
                    static function (int $size) use ($seed): Closure {
                        // Point free style.
                        return Pipe::ofTyped2(
                            Shuffle::of()($seed),
                            Limit::of()($size)(0)
                        );
                    };
            };
    }
}
