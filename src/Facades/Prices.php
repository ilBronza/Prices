<?php

namespace IlBronza\Prices\Facades;

use Illuminate\Support\Facades\Facade;

class Prices extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'prices';
    }
}
