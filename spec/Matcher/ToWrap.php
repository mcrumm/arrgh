<?php

namespace Arrgh\Matcher;

use Arrgh\Arry;

/**
 * Custom matcher for `toContain` on Arry.
 */
class ToWrap
{
    /**
     * @var array
     */
    private static $_description;

    /**
     * Checks that `$actual` is of the `$expected` type.
     *
     * @param  Arry  $actual   The actual value.
     * @param  array $expected The expected value.
     *
     * @return boolean
     */
    public static function match(Arry $actual, array $expected)
    {
        $actual = $actual->toArray();

        self::_buildDescription($actual, $expected);

        return $actual === $expected;
    }

    /**
     * Build the description of the current `::match()` call.
     *
     * @param string $actual   The actual type.
     * @param string $expected The expected type.
     */
    public static function _buildDescription($actual, $expected)
    {
        $description = "wrap the expected array.";
        $params['actual'] = $actual;
        $params['expected'] = $expected;
        static::$_description = compact('description', 'params');
    }

    /**
     * Returns the description report.
     */
    public static function description()
    {
        return static::$_description;
    }
}
