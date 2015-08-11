<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/24/15
 * Time: 2:54 PM
 */

namespace Maverickslab\Etsy;

use Maverickslab\Etsy\Exceptions\ShopifyException;

class Etsy {

    /**
     * @var
     */
    public  $requestor;

    public function __construct(ApiRequestor $requestor){

        $this->requestor = $requestor;
    }



    public function __call($methodName, $arguments){
        $class = $this->resolveClass($methodName);

        return new $class($this->requestor);
    }


    public function install()
    {
//        return 'installing';
        return $this->requestor->install();
    }


    public function getAccessToken($responseParams)
    {
        return $this->requestor->getAccessToken($responseParams);
    }


    public function resolveClass($className)
    {
        $class = $this->getNamespace().$this->sanitizeClassName ( $className );
        if( class_exists($class) ){
            return $class;
        }

        throw new \Exception;
    }


    public function shop($storeToken = null, $tokenSecret = null)
    {
        $this->requestor->storeToken = $storeToken;
        $this->requestor->tokenSecret = $tokenSecret;

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
        return 'Maverickslab\Shopify\Resources\\';
    }
} 