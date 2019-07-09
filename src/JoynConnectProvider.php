<?php
    /**
     * Created by PhpStorm.
     * User: JuniorE.
     * Date: 2019-06-23
     * Time: 18:45
     */

    namespace JuniorE\LaravelJoyn;

    use GuzzleHttp\Psr7\Request;
    use Laravel\Socialite\Two\AbstractProvider;
    use Laravel\Socialite\Two\ProviderInterface;

    class JoynConnectProvider extends AbstractProvider implements ProviderInterface
    {
        const JOYN_API_URL = 'https://api.acc.joyn.be';

        /**
         * Get the authentication URL for the provider.
         *
         * @param  string  $state
         * @return string
         */
        protected function getAuthUrl($state)
        {
            // TODO: Implement getAuthUrl() method.

        }

        /**
         * Get the token URL for the provider.
         *
         * @return string
         */
        protected function getTokenUrl()
        {
            return static::JOYN_API_URL . '/oauth/token';
        }

        public function getAccessToken($code)
        {
            $response = $this->getHttpClient()->request('POST', $this->getTokenUrl(), [
                'headers' => ['Authorization' => 'Basic ' . base64_encode($this->clientId . ':' . $this->clientSecret)],
                'query'   => ['grant_type' => 'client_credentials'],
            ]);

            return json_decode($response->getBody(), true)['access_token'];
        }

        /**
         * Get the access token with a refresh token.
         *
         * @param  string  $refresh_token
         *
         * @return array
         */
        public function getRefreshTokenResponse($refresh_token): array
        {
            $response = $this->getHttpClient()->post($this->getTokenUrl(), [
                'headers'     => ['Accept' => 'application/json'],
                'form_params' => $this->getRefreshTokenFields($refresh_token),
            ]);
            return json_decode($response->getBody(), true);
        }

        /**
         * Get the refresh tokenfields with a refresh token.
         *
         * @param  string  $refresh_token
         *
         * @return array
         */
        protected function getRefreshTokenFields($refresh_token): array
        {
            return [
                'client_id'     => $this->clientId,
                'client_secret' => $this->clientSecret,
                'grant_type'    => 'refresh_token',
                'refresh_token' => $refresh_token,
            ];
        }

        /**
         * Get the POST fields for the token request.
         *
         * @param  string  $code
         *
         * @return array
         */
        public function getTokenFields($code)
        {
            return array_add(parent::getTokenFields($code), 'grant_type', 'client_credentials');
        }


        /**
         * Get the raw user for the given access token.
         *
         * @param  string  $token
         * @return array
         */
        protected function getUserByToken($token)
        {
            // TODO: Implement getUserByToken() method.
        }

        /**
         * Map the raw user array to a Socialite User instance.
         *
         * @param  array  $user
         * @return \Laravel\Socialite\Two\User
         */
        protected function mapUserToObject(array $user)
        {
            // TODO: Implement mapUserToObject() method.
        }
    }
