<?php

namespace Arrgh;

describe('compact()', function () {
    it('removes null values from an array', function() {
        expect(compact([1, 2, null, 4, null, 6]))->toWrap([1, 2, 4, 6]);
    });

    it('does not remove boolean false', function () {
        expect(compact([1, 2, false, 4, null, 6]))->toWrap([1, 2, false, 4, 6]);
    });
});
