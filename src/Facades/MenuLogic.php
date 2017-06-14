<?php

namespace LaravelAdmin\Facades;

use \Illuminate\Support\Facades\Facade;

class MenuLogic extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'menu.logic';
    }
}