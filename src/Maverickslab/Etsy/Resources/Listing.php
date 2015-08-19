<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/18/15
 * Time: 9:41 PM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class Listing {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester ){
        $this->requester = $requester;
    }


    public function getAllShopActiveListings ( $shopId, $parameters )
    {
        $this->requester->resource = '/shops/'.$shopId.'/listings/active';

        return $this->requester->get( false, null, $parameters );
    }


    public function getAllShopDraftListings ( $shopId, $parameters )
    {
        $this->requester->resource = '/shops/'.$shopId.'/listings/draft';

        return $this->requester->get( false, null, $parameters );
    }

}