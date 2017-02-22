<?php

namespace Jimmyjs\LaravelCsv;

use Illuminate\Support\Facades\Facade as IlluminateFacade;
/**
 * @see \Jimmyjs\LaravelCsv\CsvLaravelWrapper
 */
class Facade extends IlluminateFacade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-csv';
    }
}
