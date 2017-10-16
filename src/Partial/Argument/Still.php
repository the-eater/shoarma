<?php


namespace Shoarma\Partial\Argument;

use Shoarma\Partial\Argument;

class Still implements Argument
{
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function resolve($arguments): array
    {
        return [$this->value];
    }
}
