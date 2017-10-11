<?php


namespace Shoarma;


use Shoarma\Partial\Argument;

class Partial
{
    /**
     * @var Argument[]
     */
    protected $predefinedArguments;

    /**
     * @var callable
     */
    protected $call;

    /**
     * Partial constructor.
     * @param callable $call
     * @param Argument[] $predefinedArguments
     */
    public function __construct(callable $call, $predefinedArguments) {
        $this->call = $call;
        $this->predefinedArguments = $predefinedArguments;
    }

    /**
     * @param callable $call
     * @param mixed[]|Argument[] $predefinedArguments
     * @return Partial
     */
    public static function create(callable $call, $predefinedArguments): Partial {
        $args = [];
        $usedArg = false;

        foreach ($predefinedArguments as $arg) {
            if ($arg instanceof Argument) {
                $usedArg = true;
                $args[] = $arg;
                continue;
            }

            $args[] = new Argument\Still($arg);
        }

        if (!$usedArg) {
            $args[] = new Argument\Range(0, null);
        }

        return new Partial($call, $args);
    }

    public function __invoke(...$arguments)
    {
        $resolved = [];
        $call = $this->call;

        foreach ($this->predefinedArguments as $predefinedArgument) {
            $resolved[] = $predefinedArgument->resolve($arguments);
        }

        return $call(...array_merge(...$resolved));
    }
}