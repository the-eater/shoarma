# Shoarma

Bringing back `fun` in functions

## `fun(class $object, string $method)`

returns `\Closure` 

Shorthand replacement for `[$object, $method]`, will also throw when called from wrong context

## `this(string $method)`

returns `\Closure`

Shorthand replacement for `fun($this, $method)`, via magic (`debug_backtrace`) will collect the correct this object

## `partial(callable $call, $arguments)`

returns `\Shoarma\Partial`

Creates a partial for `$call`, `\Shoarma\arg` and `\Shoarma\args` can be used to displace arguments e.g.

```php
<?php

use function \Shoarma\partial;
use function \Shoarma\arg;

$func = function ($one, $two, $three) {
    echo "1. {$one}\n2. {$two}\n3. {$three}\n";
};

$partial = partial($func, [arg(1), "2", arg(0)]);

// This will now print "1. 1\n 2. 2\n3. 3"
$partial(3, 1);
```

### `arg(int $offset)`

returns `\Shoarma\Partial\Argument`

Selects 1 argument for the partial

### `args(int $offset, $length = null)`

returns `\Shoarma\Partial\Argument`

Selects a range of arguments for the partial, if `$length` is null, it will take everything starting at `$offset`

## `wrap(callable $call, callable $wrapper)`

returns `Shoarma\Wrap`

Will return `$wrapper` wrapped around `$call`

`$wrapper` will be called with a `\Shoarma\Wrap\Inside` object around `$call` and the other arguments

e.g.

```php
<?php

use \Shoarma\Wrap\Inside;
use function \Shoarma\wrap;

$func = function ($hello, $world) {
    return "{$hello} {$world}\n";
};

$wrapper = wrap($func, function (Inside $next) {
    // is the same as $next->callOriginal();
    // Will use the arguments given to the wrapper
    return $next(); 
   
    // is the same as $next->callWith('Hello', 'World');
    // so if you really need to call $next with no arguments you can use
    // $next->callWith();
    return $next('Hello', 'World');
});

// Will print "Goodbye mars"
echo $wrapper("Goodbye", "Mars");
``` 