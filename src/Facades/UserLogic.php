<?php

namespace LaravelAdmin\Facades;

use \Illuminate\Support\Facades\Facade;

class UserLogic extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'user.logic';
    }
}