<?php

namespace Arrgh;

use ArrayIterator;
use Composer\Autoload\ClassLoader;
use Doctrine\Common\Collections\ArrayCollection;
use stdClass;

describe('unwrap()', function () {

    beforeEach(function () {
        $this->data = ['a' => 1, 'b' => 2, 'c' => 3];
        $this->expected = [1, 2, 3];
    });

    it('returns array values', function () {
        expect(unwrap($this->data))->toBe($this->expected);
    });

    it('returns the values from an Arry', function () {
        expect(unwrap(new Arry($this->data)))->toBe($this->expected);
    });

    it('returns the values from an Collection', function () {
        expect(unwrap(new ArrayCollection($this->data)))->toBe($this->expected);
    });

    it('returns the values from a Traversable', function () {
        expect(unwrap(new ArrayIterator($this->data)))->toBe($this->expected);
    });

    it('returns the property values from a stdClass', function () {
        $obj = new stdClass();
        $obj->a = 1;
        $obj->b = 2;
        $obj->c = 3;
        expect(unwrap($obj))->toBe($this->expected);
    });

    it('throws an exception for a scalar', function () {
        expect(function () { unwrap('foo'); })->toThrow();
    });

    it('throws an exception for other objects', function () {
        expect(function () { unwrap(new ClassLoader()); })->toThrow();
    });
});
