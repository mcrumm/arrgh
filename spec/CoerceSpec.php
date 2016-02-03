<?php

namespace Arrgh;

use ArrayIterator;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

describe('coerce()', function () {
    context('given an array', function() {
        it('can coerce to Arry', function () {
            expect(coerce([]))->toBeAnInstanceOf(Arry::class);
        });

        it('will contain the given values', function () {
            expect(coerce([1, 2, 3]))->toWrap([1, 2, 3]);
        });
    });

    context('given a scalar', function () {
        it('will contain the scalar', function () {
            expect(coerce('foo'))->toWrap(['foo']);
        });
    });

    context('given an Arry', function () {
        it('returns unchanged', function () {
            $arry = new Arry();
            expect(coerce($arry))->toBe($arry);
        });
    });

    context('given a ' . Collection::class, function () {
        it('uses toArray()', function () {
            $collection = new ArrayCollection([3, 0, 9]);
            expect(coerce($collection))->toWrap([3, 0, 9]);
        });
    });

    context('given a Traversable', function () {
        it('uses iterator_to_array', function () {
            $it = new ArrayIterator([7, 8, 9]);
            expect(coerce($it))->toWrap([7, 8, 9]);
        });
    });
});
