<?php


namespace Shoarma;

use Shoarma\Wrap\Inside;

class Wrap
{
    private $call;
    private $wrapper;

    public function __construct(callable $call, callable $wrapper)
    {
        $this->call = $call;
        $this->wrapper = $wrapper;
    }

    public static function create(callable $call, callable $wrapper): Wrap
    {
        return new Wrap($call, $wrapper);
    }

    public function __invoke(...$arguments)
    {
        $wrapper = $this->wrapper;
        return $wrapper(Inside::create($this->call, $arguments), ...$arguments);
    }
}
