<?php

namespace Arrgh;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

describe(Arry::class, function () {
    it('is a Doctrine\Collection', function () {
        expect(new Arry())->toBeAnInstanceOf(Collection::class);
    });

    context('->filter()', function () {
        it('does not preserve keys', function () {
            $arry = (new Arry(["a" => 10, 'b' => 100, 'c' => 1000]))
                ->filter(function($i) {
                    return $i < 1000;
                })
            ;
            expect($arry)->toWrap([10, 100]);
        });
    });

    it('->flatMap()', function () {
        $arry = new Arry([5, 6, 7]);
        $timesTwo = function ($i) { return [$i, $i * 2]; };
        expect($arry->flatMap($timesTwo))->toWrap([5, 10, 6, 12, 7, 14]);
    });

    context('->concat()', function () {
        it('appends values from an array', function () {
            $arry = new Arry([1, 2, 3]);
            expect($arry->concat([4, 5, 6]))->toWrap(range(1, 6));
        });

        it('appends values from a Collection', function () {
            $items = new ArrayCollection([2, 4, 6]);

            $arry = new Arry([1, 3, 5]);

            expect($arry->concat($items))->toWrap([1, 3, 5, 2, 4, 6]);
        });

        it('appends values without regard to keys', function () {
            $arry = new Arry(['a' => 1, 'b' => 2, 'c' => 3]);
            expect($arry->concat(['a' => 4, 'b' => 5, 'f' => 6]))->toWrap(range(1, 6));
        });

        it('appends values at a single level', function () {
            $t = (new Arry([1, 2, [3, 4]]));
            expect($t->concat([5, 6, [7, 8]]))->toWrap([1, 2, [3, 4], 5, 6, [7, 8]]);
        });
    });
});
