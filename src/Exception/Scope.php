<?php


namespace Shoarma\Exception;

class Scope extends \Exception
{
    /**
     * @param string $what
     * @param string $caller
     * @return Scope
     */
    public static function wrong(string $what, ?string $caller)
    {
        if ($caller === null) {
            return new Scope("Tried to call {$what} while unscoped but it's protection is too high (is it as protected or private method?)");
        }

        return new Scope("Tried to call {$what} from class {$caller} but it's protection is too high (is it as protected or private method?)");
    }

    public static function thisWithoutClassScope($method)
    {
        return new Scope("Tried to call {$method} on \$this while outside a class scope");
    }
}
