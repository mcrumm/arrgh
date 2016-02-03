<?php

namespace Arrgh;

describe('flat_map()', function () {
    it('will concat the results of a map over an array', function () {
        $plusOne = function ($i) { return [$i, $i + 1]; };
        expect(flat_map([1, 3, 5], $plusOne))->toWrap([1, 2, 3, 4, 5, 6]);
    });

    it('will concat the results of a map over an Arry', function () {
        $divThree = function ($i) { return [$i, $i / 3]; };
        expect(flat_map([3, 6, 9], $divThree))->toWrap([3, 1, 6, 2, 9, 3]);
    });
});
