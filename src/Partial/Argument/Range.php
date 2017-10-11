<?php


namespace Shoarma\Partial\Argument;


use Shoarma\Partial\Argument;

class Range implements Argument
{
    private $offset;
    private $length;

    /**
     * Range constructor.
     * @param int $offset
     * @param int|null $length
     */
    public function __construct($offset, $length)
    {
        $this->offset = $offset;
        $this->length = $length;
    }

    public function resolve($arguments): array
    {
        return array_slice($arguments, $this->offset, $this->length);
    }
}