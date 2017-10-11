<?php

namespace Shoarma;

use ReflectionMethod;
use Shoarma\Exception\Scope;
use Shoarma\Partial\Argument;
use Shoarma\Partial\Argument\Range;

if (! function_exists('Shoarma\fun')) {
    /**
     * A more elegant shorthand for `[$object, $method]` with correct checking of method ownership
     *
     * @param mixed $object
     * @param string $method
     * @return \Closure
     * @throws Scope if not allowed to call from this scope
     */
    function fun($object, $method): \Closure {
        return deepFun($object, $method,3);
    }
}

if (! function_exists('Shoarma\partial')) {
    /**
     * @param callable $call
     * @param mixed[]|Partial\Argument[] $arguments
     * @return callable|Partial
     * @throws Scope if not allowed to call from this scope
     */
    function partial($call, $arguments): callable {
        return Partial::create($call, $arguments);
    }
}

if (! function_exists('Shoarma\wrap')) {
    /**
     * @param $call
     * @param $wrapper
     * @return Wrap
     */
    function wrap($call, $wrapper): Wrap  {
        return Wrap::create($call, $wrapper);
    }
}

if (! function_exists('Shoarma\arg')) {

    function arg($offset): Argument {
        return new Range($offset, 1);
    }
}

if (! function_exists('Shoarma\args')) {

    function args($offset, $length = null): Argument {
        return new Range($offset, $length);
    }
}

if (! function_exists('Shoarma\deepFun')) {
    /**
     * A more elegant shorthand for `[$object, $method]` with correct checking of method ownership
     *
     * @param \stdClass $object
     * @param string $method
     * @param int $depth from where this closure is created
     * @return \Closure
     * @throws Scope if not allowed to call from this scope
     */
    function deepFun($object, $method, $depth): \Closure {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($method);

        $caller = getCallerClass($depth);
        if (!isAllowedToCall($method, $caller)) {
            throw Scope::wrong($method->getDeclaringClass()->getName() . '::' . $method->getName(), $caller);
        }

        return $method->getClosure($object);
    }
}

if (! function_exists('Shoarma\getCallerClass')) {
    /**
     * Get class which called *n* methods or functions ago
     *
     * @param int $deep
     * @return string|null
     */
    function getCallerClass($deep): string {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, $deep + 1);
        return $backtrace[$deep]['class'] ?? null;
    }
}

if (! function_exists('Shoarma\isAllowedToCall')) {
    /**
     * Checks if given class is allowed to call given method
     *
     * @param ReflectionMethod $method
     * @param string $className
     * @return bool
     */
    function isAllowedToCall(ReflectionMethod $method, string $className): bool {
        $declaringClass = $method->getDeclaringClass();

        // No matter what function this is, this is allowed
        if ($className === $declaringClass->getName() || $method->getModifiers() & ReflectionMethod::IS_PUBLIC) {
            return true;
        }

        // private functions may only be called from it's own class
        // that check failed in the previous if
        if($method->getModifiers() & ReflectionMethod::IS_PRIVATE) {
            return false;
        }

        // Only options left is protected, which allows it to be called from it's 'children'
        if (in_array($declaringClass->getName(), getParentClasses($className), true)) {
            return true;
        }

        // It's not allowed
        return false;
    }
}

if (! function_exists('Shoarma\getParentClasses')) {
    /**
     * Get all parent classes of given class
     *
     * @param string $className
     * @return string[]
     */
    function getParentClasses(string $className): array {
        $class = new \ReflectionClass($className);
        $parent = $class;
        $classNames = [];

        while ($parent = $parent->getParentClass()) {
            $classNames[] = $parent->getName();
        }

        return $classNames;
    }
}