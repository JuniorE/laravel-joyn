<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 2019-06-23
     * Time: 18:55
     */

    if ( !function_exists('joyn')) {
        function joyn()
        {
            return app('joyn.api');
        }
    }
