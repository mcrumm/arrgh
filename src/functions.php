<?php

namespace Arrgh;

use Doctrine\Common\Collections\Collection;
use LogicException;
use Traversable;
use stdClass;

/**
 * Create an Arry object from an array of elements.
 *
 * @param array $elements
 *
 * @return Arry
 */
function arry(array $elements) {
    return new Arry($elements);
}

/**
 * @param array|Collection|Traversable $elements
 *
 * @return Arry
 */
function coerce($elements) {
    if ($elements instanceof Arry) {
        return $elements;
    } elseif (!is_array($elements) && !is_object($elements)) {
        return arry([$elements]);
    }

    return arry(to_array($elements));
}

/**
 * @param mixed $elements
 *
 * @return Arry
 */
function compact($elements) {
    return coerce($elements)->filter(function ($i) { return !is_null($i); });
}

/**
 * @param mixed $elements
 *
 * @return Arry
 */
function concat($elements) {
    return flatten($elements, 1);
}

/**
 * @param mixed $elements
 * @param int   $depth
 *
 * @return Arry
 */
function flatten($elements, $depth = INF) {
    return reduce($elements, function (Arry $arry, $element) use ($depth) {
        $element = ($element instanceof Collection) ? $element->toArray() : $element;

        if (is_array($element)) {
            if (1 === $depth) {
                return $arry->concat(coerce($element));
            }

            return $arry->concat(flatten($element, $depth-1));
        }

        $arry[] = $element;
        return $arry;

    }, new Arry());
}

/**
 * @param $elements
 * @param callable|null $p
 *
 * @return Arry
 */
function filter($elements, callable $p = null) {
    $elements = is_array($elements) ? $elements : unwrap($elements);
    return new Arry(array_values(array_filter($elements, $p)));
}

/**
 * @param $elements
 * @param callable $func
 *
 * @return Arry
 */
function flat_map($elements, callable $func) {
    return concat(coerce($elements)->map($func));
}

/**
 * @param array|Collection|Traversable $elements  List of elements being reduced.
 * @param callable                     $reduction Reduction function.
 * @param mixed                        $initial   Initial value passed to array_reduce.
 *
 * @return Arry
 */
function reduce($elements, callable $reduction, $initial = null)
{
    return coerce(array_reduce(unwrap($elements), $reduction, $initial));
}

/**
 * @param mixed $item
 *
 * @return array
 *
 * @throws LogicException When the item cannot be cast to an array.
 */
function to_array($item)
{
    if ($item instanceof Collection) {
        return $item->toArray();
    } elseif ($item instanceof Traversable) {
        return iterator_to_array($item);
    } elseif ($item instanceof stdClass) {
        return (array)$item;
    } elseif (is_array($item)) {
        return $item;
    }

    throw new LogicException;
}

/**
 * Returns an array of values from the given item.
 *
 * @param mixed $item
 *
 * @return array
 *
 * @throws LogicException When the item is not array-ish, and therefore cannot be unwrapped.
 */
function unwrap($item) {
    return array_values(to_array($item));
}

/**
 * @param array|Collection|Traversable $a
 * @param array|Collection|Traversable $b
 *
 * @param null $combiner
 *
 * @return Arry
 */
function zip($a, $b, $combiner = null) {
    $combiner = $combiner ?: function ($a, $b) {
        return [$a, $b];
    };

    $results = [];
    $max = max(count($a), count($b));
    for ($i=0; $i < $max; $i++) {
        $newA = isset($a[$i]) ? $a[$i] : null;
        $newB = isset($b[$i]) ? $b[$i] : null;
        $results[] = $combiner($newA, $newB);
    }

    return arry($results);
}
