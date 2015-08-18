<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/17/15
 * Time: 5:13 PM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;
use Maverickslab\Etsy\Exceptions\EtsyException;

class Shop {

    public function __construct( ApiRequester $requester){
        $this->requester = $requester;
        $this->requester->resource = '/v2/shops';
    }


    public function getAllShops ( $parameters = [] )
    {
        return $this->requester->get( false, null, $parameters );
    }


    public function getShop( $shopId = null, $parameters = [] ){
        if(is_null($shopId))
            throw new EtsyException('Shop id or shop name should be provided');
        
        return $this->requester->get( false, $shopId, $parameters );
    }

    public function getListingShop ( $listingId )
    {
        if(is_null($listingId))
            throw new EtsyException( 'listing id needs to be provided' );

        $this->requester->resource .= '/listing';

        return $this->requester->get( false, $listingId);
    }

} 