<?php

namespace Shoarma\Test;

use PHPUnit\Framework\TestCase;
use Shoarma\Exception\Scope;
use function Shoarma\fun;
use function Shoarma\getCallerClass;
use function Shoarma\getParentClasses;
use Shoarma\Test\Helpers\Abstrac;
use Shoarma\Test\Helpers\Extended;
use Shoarma\Test\Helpers\Priv;
use Shoarma\Test\Helpers\Protec;
use function Shoarma\Test\Helpers\unscopedFun;
use function Shoarma\Test\Helpers\unscopedThis;
use function Shoarma\Test\Helpers\unscopedUnsafeFun;
use function Shoarma\wrap;
use Shoarma\Wrap\Inside;

class Functions extends TestCase
{
    public function testFunUnsafePrivate() {
        $this->expectException(Scope::class);

        $class = new Priv();
        fun($class, 'setItem')(1);
    }

    public function testFunUnsafeProtected() {
        $this->expectException(Scope::class);

        $class = new Protec();
        fun($class, 'set')(1);
    }

    public function testFunUnscoped() {
        $this->assertInstanceOf(\Closure::class, unscopedFun());
    }

    public function testFunUnsafeUnscopedProtected() {
        $this->expectException(Scope::class);

        unscopedUnsafeFun();
    }

    public function testFun() {
        $priv = new Priv();
        $setter = $priv->getSetter();
        $setter(1);
        $this->assertEquals(1, $priv->getItem());

        $extended = new Extended();

        // ->getSetter defined in Priv as public
        $getSetter = fun($extended, 'getSetter');

        // ->setItem defined in Priv, ->getSetter in Priv
        $setter = $getSetter();
        $setter(2);
        $this->assertEquals(2, $extended->getItem());

        // ->switch defined in Extended, ->getSwitch in Extended
        $switcher = $extended->getSwitch();

        $this->assertEquals(2 , $switcher(3));
        $this->assertEquals(3, $extended->getItem());

        // ->set defined in Protect, ->getSet in Extended
        $set = $extended->getSet();
        $set(4);
        $this->assertEquals(4, $extended->getItem());
    }

    public function testThis() {
        $priv = new Priv();
        $setter = $priv->getThisSetter();
        $setter(1);
        $this->assertEquals(1, $priv->getItem());

        $extended = new Extended();

        // ->setItem defined in Priv, ->getSetter in Priv
        $setter = $extended->getThisSetter();
        $setter(2);
        $this->assertEquals(2, $extended->getItem());

        // ->switch defined in Extended, ->getSwitch in Extended
        $switcher = $extended->getThisSwitch();

        $this->assertEquals(2 , $switcher(3));
        $this->assertEquals(3, $extended->getItem());

        // ->set defined in Protect, ->getSet in Extended
        $set = $extended->getThisSet();
        $set(4);
        $this->assertEquals(4, $extended->getItem());

        $protectedChildFunction = $priv->getChildFunction();
        $this->assertEquals(4, $protectedChildFunction());
    }

    public function testThisUnsafePrivate() {
        $this->expectException(Scope::class);

        $class = new Extended();
        $class->thisUnsafeSetItem(2);
    }

    public function testUnscopedThis() {
        $this->expectException(Scope::class);

        unscopedThis();
    }

    public function testCalledFromClass() {
        $this->assertEquals(self::class, getCallerClass(1));
        $this->assertNotEquals(TestCase::class, getCallerClass(1));
    }

    public function testGetParentClasses() {
        $this->assertEquals([Abstrac::class], getParentClasses(Priv::class));
    }

    public function testWrap() {
        $test = function ($arg) {
            return 1 + $arg;
        };

        $wrapOne = wrap($test, function ($next, $arg) {
            return $next() + $arg;
        });

        $wrapTwo = wrap($test, function () {
            return 2;
        });

        $wrapThree = wrap($test, function (Inside $next) {
            return $next(5);
        });

        $this->assertEquals(3, $test(2));
        $this->assertEquals(5, $wrapOne(2));
        $this->assertEquals(2, $wrapTwo(2));
        $this->assertEquals(6, $wrapThree(2));
    }
}
