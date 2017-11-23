<?php


namespace Shoarma\Test\Helpers;


use function Shoarma\this;

abstract class Abstrac
{
    public function getChildFunction() {
        return this('childFunction');
    }

    abstract protected function childFunction();
}