<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 2019-06-23
     * Time: 18:57
     */

    namespace JuniorE\LaravelJoyn;

    use Illuminate\Contracts\Container\Container;


    class JoynManager
    {

        /**
         * @var Container
         */
        protected $app;

        /**
         * MollieManager constructor.
         *
         * @param  Container  $app
         *
         * @return void
         */
        public function __construct(Container $app)
        {
            $this->app = $app;
        }

        /**
         * @return mixed
         */
        public function api()
        {
            return $this->app['joyn.api'];
        }

    }
