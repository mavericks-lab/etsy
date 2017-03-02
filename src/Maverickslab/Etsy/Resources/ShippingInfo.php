<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/19/15
 * Time: 9:09 AM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class ShippingInfo {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester )
    {
        $this->requester = $requester;
    }



    public function createShippingInfo( $listingId, $parameters )
    {
        $this->requester->resource = "/listings/{$listingId}/shipping/info";

        return $this->requester->post( $parameters );
    }

} 