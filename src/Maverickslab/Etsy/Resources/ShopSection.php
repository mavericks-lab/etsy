<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/19/15
 * Time: 9:09 AM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class ShopSection {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester )
    {
        $this->requester = $requester;
    }


    public function getAllShopSections ( $shopId, $parameters = [] )
    {
        $this->requester->resource = '/shops/'.$shopId.'/sections';

        return $this->requester->get( false, null, $parameters );
    }


    public function createShopSection($shopId, $parameters)
    {
        $this->requester->resource = '/shops/'.$shopId.'/sections';

        return $this->requester->post( $parameters );
    }



} 