<?php

namespace Arrgh;

use Closure;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Traversable;

class Arry extends ArrayCollection
{
    /**
     * Filter values based on the predicate function.
     *
     * Note: This implementation of filter does not preserve keys.
     *
     * @param Closure $p
     *
     * @return static
     */
    public function filter(Closure $p)
    {
        return filter($this, $p);
    }

    /**
     * @param Closure $func
     *
     * @return static
     */
    public function flatMap(Closure $func)
    {
        return flat_map($this, $func);
    }

    /**
     * @param array|Collection|Traversable $items
     *
     * @return static
     */
    public function concat($items)
    {
        return new static(array_merge(unwrap($this), unwrap($items)));
    }
}
