<?php

namespace Arrgh;

describe('zip()', function () {
    it('combines elements from two arrays into an array of tuples', function () {
        expect(zip([1, 2, 3], [4, 5, 6]))->toWrap([[1, 4], [2, 5], [3, 6]]);
    });
});
