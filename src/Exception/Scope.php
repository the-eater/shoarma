<?php


namespace Shoarma\Exception;


class Scope extends \Exception
{
    /**
     * @param string $what
     * @param string $caller
     * @return Scope
     */
    public static function wrong($what, $caller) {
        return new Scope("Tried to call {$what} from class {$caller} but is not in scope");
    }
}