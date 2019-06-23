<?php

namespace JuniorE\LaravelJoyn;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JuniorE\LaravelJoyn\Skeleton\SkeletonClass
 */
class LaravelJoynFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-joyn';
    }
}
