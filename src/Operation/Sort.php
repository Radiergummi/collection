<?php

declare(strict_types=1);

namespace loophp\collection\Operation;

use Closure;
use Generator;
use loophp\collection\Contract\Operation;
use loophp\collection\Iterator\SortableIterableIterator;

final class Sort extends AbstractOperation implements Operation
{
    public function __construct(?callable $callback = null)
    {
        $this->storage['callback'] = $callback ?? static function ($left, $right): int {
            return $left <=> $right;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke(): Closure
    {
        return static function (iterable $collection, callable $callback): Generator {
            yield from new SortableIterableIterator($collection, $callback);
        };
    }
}
