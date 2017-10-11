<?php


namespace Shoarma\Wrap;


class Inside
{
    /**
     * @var array
     */
    private $arguments;

    /**
     * @var callable
     */
    private $call;

    /**
     * Inside constructor.
     * @param callable $call
     * @param array $arguments
     */
    public function __construct(callable $call, array $arguments)
    {
        $this->call = $call;
        $this->arguments = $arguments;
    }

    /**
     * @param callable $call
     * @param array $arguments
     * @return Inside
     */
    public static function create(callable $call, array $arguments): Inside {
        return new Inside($call, $arguments);
    }

    /**
     * Call this function with different arguments then given
     *
     * @param array ...$arguments
     * @return mixed
     */
    public function callWith(...$arguments) {
        $call = $this->call;
        return $call(...$arguments);
    }

    /**
     * Call this function with the original arguments
     *
     * @return mixed
     */
    public function callOriginal() {
        $call = $this->call;
        return $call(...$this->arguments);
    }

    public function __invoke(...$arguments)
    {
        if (count($arguments) === 0) {
            return $this->callOriginal();
        }

        return $this->callWith(...$arguments);
    }
}