<?php

namespace Shoarma\Test\Helpers;

use function Shoarma\fun;
use function Shoarma\this;

if (! function_exists('Shoarma\Test\Helpers\unscopedUnsafeFun')) {
    function unscopedUnsafeFun()
    {
        $class = new Protec();
        fun($class, 'get');
    }
}

if (! function_exists('Shoarma\Test\Helpers\unscopedFun')) {
    function unscopedFun()
    {
        $class = new Protec();
        return fun($class, 'getSetter');
    }
}

if (! function_exists('Shoarma\Test\Helpers\unscopedThis')) {
    function unscopedThis()
    {
        this('unscopedUnsafeFun');
    }
}
