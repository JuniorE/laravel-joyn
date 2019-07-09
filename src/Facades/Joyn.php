<?php

    namespace JuniorE\LaravelJoyn\Facades;

    use Illuminate\Support\Facades\Facade;
    use JuniorE\LaravelJoyn\Wrappers\JoynApiWrapper;


    /**
     * (Facade) Class Joyn.
     *
     * @method static JoynApiWrapper api()
     */
    class Joyn extends Facade
    {
        /**
         * Get the registered name of the component.
         *
         * @return string
         */
        protected static function getFacadeAccessor()
        {
            return 'joyn';
        }
    }
