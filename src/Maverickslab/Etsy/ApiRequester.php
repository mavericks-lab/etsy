<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/16/15
 * Time: 10:56 PM
 */

namespace Maverickslab\Etsy;


use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Plugin\Oauth\OauthPlugin;
use Guzzle\Service\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Maverickslab\Etsy\Exceptions\EtsyException;
use OAuth;
use OAuthException;

class ApiRequester {

    /**
     * @var
     */
    private $client;

    private $baseUrl = 'https://openapi.etsy.com/v2';

    private $oauth;

    private $url;

    public $tokenSecret;

    public $storeToken;

    public  $resource;

    public $associations;

    public function __construct(Client $client){
        $this->client = $client;
        $this->oauth =  new OAuth($this->getClientId(), $this->getClientSecret());
    }


    public function install(){
        $requestToken = $this->oauth->getRequestToken( $this->getRequestTokenUrl (), $this->getInstallationRedirectUrl () );
        return $requestToken;
    }


    public function getAccessToken($response_params){
        if(!isset($response_params['request_secret']) || is_null($response_params['request_secret']))
            throw new EtsyException('The request secret has not been provided');

        if(!isset($response_params['oauth_token']) || is_null($response_params['oauth_token']))
            throw new EtsyException('No Oauth token provided');

        $request_token = $response_params['oauth_token'];
        $oauth_verifier = $response_params['oauth_verifier'];

        $this->oauth->setToken($request_token, $response_params['request_secret']);
        $oauthToken = $this->oauth->getAccessToken($this->baseUrl.'/oauth/access_token', null, $oauth_verifier);

        return $oauthToken;
    }



    public function get( $protected = true, $resourceId = null, $options = [] )
    {
        $this->url = $this->baseUrl.$this->resource;

        if(!is_null($resourceId))
            $this->url .= '/'.$resourceId;

        return $this->makeGetRequest( $protected, $options );
    }

    public function post ( $postData )
    {
        return $this->makeOauthRequest( 'POST', $postData );
    }

    public function put ( $postData )
    {
        return $this->makeOauthRequest('PUT', $postData);
    }


    private function makeOauthRequest ( $method, $postData )
    {
        try{
            $this->setToken();
            $headers[] = 'Content-Type: application/x-www-form-urlencoded';
            $this->oauth->setRequestEngine(OAUTH_REQENGINE_CURL);
            $this->url = $this->baseUrl.$this->resource;

            $this->oauth->fetch($this->url, $postData, $method, $headers);
            $response = json_decode($this->oauth->getLastResponse(), true);
            return $response;
        }catch(OAuthException $e){
            $errors[] = $this->oauth->getLastResponse();
            throw new EtsyException('Etsy Exception', $errors);
        }
    }

    private function makeGetRequest( $protected, $parameters ){
        $this->appendAssociations();
        if($protected){
            $this->oauth = new OAuth($this->getClientId(), $this->getClientSecret(), OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
            $this->setToken();
            $this->url = $this->url.$this->getQueryString( $parameters );
            $this->oauth->fetch($this->url, null, OAUTH_HTTP_METHOD_GET);
            $json = $this->oauth->getLastResponse();
            return json_decode($json, true);
        }
        $headers = $this->getHeaders();
        $headers[] = 'Content-Type: application/json';
        $parameters['api_key'] = $this->getClientId();
        $this->url = $this->url.$this->getQueryString( $parameters );

        return $this->client->get($this->url, $headers)->send()->json();
    }


    public function getQueryString($options)
    {
        if(sizeof($options) > 0){
            $binder = (strpos($this->url, '?') !== FALSE) ? '&' : '?';
            return $binder.http_build_query($options);
        }
    }



    public function getClientId()
    {
        $clientId = config('etsy.CLIENT_ID');

        if(is_null($clientId))
        {
            throw new EtsyException('No Etsy Client ID provided');
        }

        return $clientId;
    }


    public function getClientSecret()
    {
        $clientSecret = config('etsy.CLIENT_SECRET');

        if(is_null($clientSecret))
        {
            throw new EtsyException('No Etsy Client Secret provided');
        }

        return $clientSecret;
    }



    public function getStoreToken()
    {
        if(is_null($this->storeToken))
        {
            throw new EtsyException('Access token not provided');
        }
        return $this->storeToken;
    }



    public function getHeaders()
    {
        return [
            'x-api-key: '.config('etsy.CLIENT_ID')
        ];
    }

    /**
     * @return string
     */
    private function getRequestTokenUrl ()
    {
        return $this->baseUrl . '/oauth/request_token';
    }

    private function getInstallationRedirectUrl ()
    {
        $redirect_url = config ( 'etsy.INSTALLATION_REDIRECT_URL' );
        if(is_null($redirect_url))
            throw new EtsyException(' Installation redirect url not provided ');

        return $redirect_url;
    }

    private function setToken()
    {
        if(is_null($this->storeToken))
            throw new EtsyException(' Store token not provided');

        if(is_null($this->tokenSecret))
            throw new EtsyException('Token secret not provided');

            $this->oauth->setToken ( $this->storeToken, $this->tokenSecret );
    }

    private function appendAssociations ()
    {
        if(sizeof($this->associations) > 0){
            $this->url .= '?includes='.implode(',', $this->associations);
        }
    }


}