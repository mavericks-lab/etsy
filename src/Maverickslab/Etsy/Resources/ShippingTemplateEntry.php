<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/19/15
 * Time: 9:09 AM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class ShippingTemplateEntry {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester )
    {
        $this->requester = $requester;
    }

    public function createShippingTemplateEntry( $parameters )
    {
        $this->requester->resource = '/shipping/templates/entries';

        return $this->requester->post( $parameters );
    }

    public function getShippingTemplateEntry( $shippingTemplateEntryId )
    {
        $this->requester->resource = "/shipping/templates/entries/{$shippingTemplateEntryId}";
        return $this->requester->get(true);
    }

    public function updateShippingTemplateEntry( $shippingTemplateEntryId, $parameters = [])
    {
        $this->requester->resource = "/shipping/templates/entries/{$shippingTemplateEntryId}";
        return $this->requester->put( $parameters );
    }

    public function deleteShippingTemplateEntry($shippingTemplateEntryId)
    {
        $this->requester->resource = "/shipping/templates/entries/{$shippingTemplateEntryId}";
        $this->requester->delete();
    }

} 