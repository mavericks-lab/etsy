<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/24/15
 * Time: 2:54 PM
 */

namespace Maverickslab\Etsy;

use Illuminate\Support\Facades\App;


class Etsy {

    public  $requester;

    public function __construct(ApiRequester $requester){
        $this->requester = $requester;
    }



    public function __call($methodName, $arguments){
        $class = $this->resolveClass($methodName);

        return new $class($this->requester);
    }


    public function install()
    {
        return $this->requester->install();
    }


    public function getAccessToken($responseParams)
    {
        return $this->requester->getAccessToken($responseParams);
    }


    public function resolveClass($className)
    {
        $class = $this->getNamespace().$this->sanitizeClassName ( $className );

        if( class_exists($class) ){
            return $class;
        }

        throw new \Exception;
    }


    public function authorization($storeToken = null, $tokenSecret = null)
    {
        $this->requester->storeToken = $storeToken;
        $this->requester->tokenSecret = $tokenSecret;
        return $this;
    }


    public function with ( $associations = [ ] )
    {
        $this->requester->associations = $associations;
        return $this;
    }

    /**
     * @param $className
     * @return bool
     */
    public function sanitizeClassName ( $className )
    {
        if(trim(substr($className, -1)) == 's'){
            $className = chop($className, 's');
        }
        return  ucfirst( $className );
    }


    public function getNamespace()
    {
        return 'Maverickslab\Etsy\Resources\\';
    }
} 