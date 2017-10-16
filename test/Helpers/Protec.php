<?php


namespace Shoarma\Test\Helpers;


class Protec extends Priv
{
    protected function set($item) {
        $this->getSetter()($item);
    }

    protected function thisSet($item) {
        $this->getThisSetter()($item);
    }

    protected function get() {
        return $this->getItem();
    }
}