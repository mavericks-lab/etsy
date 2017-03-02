<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/18/15
 * Time: 9:41 PM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class Inventory {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester ){
        $this->requester = $requester;
    }


    public function getAllListingInventory ( $listingId, $parameters = [])
    {
        $this->requester->resource = '/listings/'.$listingId.'/inventory';

        $response = $this->requester->get( false, null, $parameters );
        
        return $response;
    }

    
    public function createListingInventory( $listingId, $postBody = [])
    {
        $this->requester->resource = '/listings/'.$listingId.'/inventory';

        return $this->requester->post( $postBody );
    }

    
    public function updateListingInventory( $listingId, $postBody = [])
    {
        $this->requester->resource = '/listings/'.$listingId.'/inventory';

        return $this->requester->put( $postBody );
    }

}