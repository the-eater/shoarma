<?php


namespace Shoarma\Test\Helpers;

use function Shoarma\fun;
use function Shoarma\this;

class Extended extends Protec
{
    protected function switch($new)
    {
        $old = $this->get();
        $this->set($new);
        return $old;
    }

    protected function thisSwitch($new)
    {
        $old = $this->get();
        $this->thisSet($new);
        return $old;
    }

    public function getSet()
    {
        return fun($this, 'set');
    }

    public function getThisSet()
    {
        return this('set');
    }

    public function getSwitch()
    {
        return fun($this, 'switch');
    }

    public function getThisSwitch()
    {
        return this('thisSwitch');
    }

    public function thisUnsafeSetItem()
    {
        return this('setItem');
    }
}
