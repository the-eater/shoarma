<?php


namespace Shoarma\Test\Helpers;


use function Shoarma\fun;

class Priv
{
    private $item;

    public function getItem() {
        return $this->item;
    }

    private function setItem($value) {
        $this->item = $value;
    }

    public function getSetter() {
        return fun($this, 'setItem');
    }
}