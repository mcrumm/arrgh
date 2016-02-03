<?php

namespace Arrgh;

describe('flatten()', function () {
    it ('flattens mult-dimensional arrays', function () {
        expect(flatten([1, 2, [3, 4], 5, [6, [7, 8]]]))
            ->toWrap(range(1, 8));
    });

    it ('flattens to the specified depth', function () {
        expect(flatten([1, 2, [3, 4, [5, 6]]], 1))
            ->toWrap([1, 2, 3, 4, [5, 6]]);
    });
});
