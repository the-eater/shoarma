<?php


namespace Shoarma\Partial;

interface Argument
{
    public function resolve($arguments): array;
}
