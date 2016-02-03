<?php

namespace Arrgh;

describe('concat()', function () {
   it('flattens a multi-dimensional array into a single array', function () {
       expect(concat([[1, 2, 3], [4, 5, 6]]))->toWrap([1, 2, 3, 4, 5, 6]);
   });
});
