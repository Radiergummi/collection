<?php

/**
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Iterator;

/**
 * @immutable
 *
 * @template TKey
 * @template T
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class FoldLeft1 extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable((T|null), T, TKey, Iterator<TKey, T>):(T|null)): Closure(Iterator<TKey, T>): Iterator<int|TKey, null|T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(T|null, T, TKey, Iterator<TKey, T>):(T|null) $callback
             *
             * @return Closure(Iterator<TKey, T>): Iterator<int|TKey, null|T>
             */
            static function (callable $callback): Closure {
                // Point free style.
                return Pipe::ofTyped2(
                    (new ScanLeft1())()($callback),
                    (new Last())()
                );
            };
    }
}
