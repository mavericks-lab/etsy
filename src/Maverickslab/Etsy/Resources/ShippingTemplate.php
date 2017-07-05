<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/19/15
 * Time: 9:09 AM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class ShippingTemplate {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester )
    {
        $this->requester = $requester;
    }


    public function getAllUserShippingTemplate ( $userId, $parameters )
    {
        $this->requester->resource = '/users/'.$userId.'/shipping/templates';

        return $this->requester->get( true, null, $parameters );
    }

    public function getShippingTemplate( $shippingTemplateId)
    {
        $this->requester->resource = "/shipping/templates/{$shippingTemplateId}";
        return $this->requester->get( true );
    }

    public function getAllShippingTemplateEntries( $shippingTemplateId )
    {
        $this->requester->resource = "/shipping/templates/{$shippingTemplateId}/entries";

        return $this->requester->get(true);
    }

    public function createShippingTemplate( $parameters )
    {
        $this->requester->resource = '/shipping/templates';

        return $this->requester->post( $parameters );
    }

    public function updateShippingTemplate( $shippingTemplateId, $parameters = [] )
    {
        $this->requester->resource = "/shipping/templates/{$shippingTemplateId}";
        return $this->requester->put( $parameters );
    }

    public function deleteShippingTemplate( $shippingTemplateId )
    {
        $this->requester->resource = "/shipping/templates/{$shippingTemplateId}";
        return $this->requester->delete();
    }

} 