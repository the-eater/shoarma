<?php


namespace Shoarma\Test;

use PHPUnit\Framework\TestCase;
use function Shoarma\arg;
use function Shoarma\args;
use function Shoarma\fun;
use function Shoarma\partial;

class Partial extends TestCase
{
    private function makeArray(...$arguments)
    {
        return $arguments;
    }

    public function testAutoPostfix()
    {
        $partial = partial(fun($this, 'makeArray'), [1, 2]);
        $this->assertEquals([1, 2, 3], $partial(3));
    }

    public function testArgsShorthand()
    {
        $partial = partial(fun($this, 'makeArray'), [arg(0), 2, args(1)]);
        $this->assertEquals([1, 2, 3, 4], $partial(1, 3, 4));
    }
}
