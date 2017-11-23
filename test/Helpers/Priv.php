<?php


namespace Shoarma\Test\Helpers;

use function Shoarma\fun;
use function Shoarma\this;

class Priv extends Abstrac
{
    private $item;

    public function getItem()
    {
        return $this->item;
    }

    private function setItem($value)
    {
        $this->item = $value;
    }

    public function getSetter()
    {
        return fun($this, 'setItem');
    }

    public function getThisSetter()
    {
        return this('setItem');
    }

    protected function childFunction()
    {
        return 4;
    }
}
