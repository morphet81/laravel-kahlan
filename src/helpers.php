<?php

use Kahlan\Suite;
use Sofa\LaravelKahlan\Env;

/*
|--------------------------------------------------------------------------
| Laravel context helpers
|--------------------------------------------------------------------------
*/

if (! function_exists('laravel')) {
    /**
     * Mark laravel instance.
     *
     * @param bool $refresh If to start a refresh new application.
     *
     * @return Laravel
     */
    function laravel($refresh = false)
    {
        static $laravel;

        if (! $refresh && $laravel) {
            return $laravel;
        }

        $laravel = new Laravel;

        $app = require realpath('bootstrap/app.php');
        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $laravel->app = $app;

        return $laravel;
    }
}

if (! function_exists('laravel_assert')) {
    /**
     * Due to the issue that, when assertion fails using Laravel "assert*"
     * methods, it throws ExpectationFailedException, for Kahlan it is just
     * a normal exception, the failure message will not be nicely reported.
     *
     * @param $callable
     */
    function laravel_assert($callable)
    {
        expect($callable)->not->toThrow();
    }
}

if (! function_exists('wrap_each')) {
    /**
     * Wrap each spec in given wrappers. Replacement for Laravel's testing traits, eg. `use DatabaseTransactions`
     *
     * @param  string|array $in
     * @param  \Closure $closure
     *
     * @return \Kahlan\Suite
     */
    function wrap_each($in, $closure)
    {
        return Env::wrap($in, $closure);
    }
}

if (! function_exists('using')) {
    /**
     * Wrap each spec in given wrappers. Replacement for Laravel's testing traits, eg. `use DatabaseTransactions`
     *
     * Alias for wrapEach.
     *
     * @param  string|array $wrappers
     * @param  \Closure $closure
     *
     * @return \Kahlan\Suite
     */
    function using($wrappers, $closure)
    {
        return wrap_each($wrappers, $closure);
    }
}

if (! function_exists('fwrap_each')) {
    /** Kahlan focus mode */
    function fwrap_each($in, $closure)
    {
        return Env::wrap($in, $closure, 'focus');
    }
}

if (! function_exists('fusing')) {
    /** Kahlan focus mode */
    function fusing($wrappers, $closure)
    {
        return fwrap_each($wrappers, $closure);
    }
}

if (! function_exists('xwrap_each')) {
    /** Kahlan ignore mode */
    function xwrap_each() { }
}

if (! function_exists('xusing')) {
    /** Kahlan ignore mode */
    function xusing() { }
}


