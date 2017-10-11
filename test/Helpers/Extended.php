<?php


namespace Shoarma\Test\Helpers;


use function Shoarma\fun;

class Extended extends Protec
{
    protected function switch($new) {
        $old = $this->get();
        $this->set($new);
        return $old;
    }

    public function getSet() {
        return fun($this, 'set');
    }

    public function getSwitch() {
        return fun($this, 'switch');
    }
}