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
 *
 * phpcs:disable Generic.Files.LineLength.TooLong
 */
final class Pipe extends AbstractOperation
{
    /**
     * @pure
     *
     * @return Closure(callable(Iterator<TKey, T>): Iterator<TKey, T> ...): Closure(Iterator<TKey, T>): Iterator<TKey, T>
     */
    public function __invoke(): Closure
    {
        return
            /**
             * @param callable(Iterator<TKey, T>): Iterator<TKey, T> ...$operations
             *
             * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
             */
            static fn (callable ...$operations): Closure => array_reduce(
                $operations,
                /**
                 * @param callable(Iterator<TKey, T>): Iterator<TKey, T> $f
                 * @param callable(Iterator<TKey, T>): Iterator<TKey, T> $g
                 *
                 * @return Closure(Iterator<TKey, T>): Iterator<TKey, T>
                 */
                static fn (Iterator $iterator): Iterator => array_reduce($operations, FPT::flip()('call_user_func'), $iterator);
    }
}
