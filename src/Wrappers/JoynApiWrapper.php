<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 2019-06-23
     * Time: 19:20
     */

    namespace JuniorE\LaravelJoyn\Wrappers;


    use Illuminate\Contracts\Config\Repository;
    use JuniorE\JoynApiClient\JoynApiClient;
    use JuniorE\JoynApiClient\TokenEndpoint;

    class JoynApiWrapper
    {
        /**
         * @var Repository
         */
        protected $config;
        /**
         * @var JoynApiClient
         */
        protected $client;

        /**
         * MollieApiWrapper constructor.
         *
         * @param  Repository  $config
         * @param  JoynApiClient  $client
         *
         * @return void
         */
        public function __construct(Repository $config, JoynApiClient $client)
        {
            $this->config = $config;
            $this->client = $client;
            $this->setApiKey($this->config->get('joyn.key'));
        }

        /**
         * @param  string  $url
         */
        public function setApiEndpoint($url)
        {
            $this->client->setApiEndpoint($url);
        }

        /**
         * @return string
         */
        public function getApiEndpoint(): string
        {
            return $this->client->getApiEndpoint();
        }

        public function setApiKey($api_key)
        {
            $this->client->setApiKey($api_key);
        }

        /**
         * @param  string  $access_token
         */
        public function setAccessToken($access_token)
        {
            $this->client->setAccessToken($access_token);
        }

        /**
         * @return bool
         */
        public function usesOAuth(): bool
        {
            return $this->client->usesOAuth();
        }

        /**
         * @param $version_string
         * @return JoynApiWrapper
         */
        public function addVersionString($version_string): JoynApiWrapper
        {
            $this->client->addVersionString($version_string);
            return $this;
        }


        /**
         * @return TokenEndpoint
         */
        public function tokens(): TokenEndpoint
        {
            return $this->client->tokens;
        }


    }
