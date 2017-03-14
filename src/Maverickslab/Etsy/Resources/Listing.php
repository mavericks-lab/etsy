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


    public function getAllShopListings ( $shopId, $parameters = [], $status = 'active' )
    {
        $this->requester->resource = '/shops/'.$shopId.'/listings/'.$status;
        
        $response = $this->requester->get( true, null, $parameters );
        
        return $response;
    }


    public function getAllShopDraftListings ( $shopId, $parameters = [])
    {
        $this->requester->resource = '/shops/'.$shopId.'/listings/draft';

        return $this->requester->get( false, null, $parameters );
    }


    public function getListing( $listingId )
    {
        $this->requester->resource = '/listings/';

        return $this->requester->get( true, $listingId);
    }


    public function getListingVariations ( $listingId, $parameters = [] )
    {
        $this->requester->resource = '/listings/'.$listingId.'/variations';

        return $this->requester->get( true, null, $parameters );
    }

    public function updateListing($listingId, $parameters = []){
        $this->requester->resource = '/listings/'.$listingId;
        return $this->requester->put( $parameters);
    }

    public function getAllListingImages( $listingId)
    {
        $this->requester->resource = '/listings/'.$listingId.'/images';
        return $this->requester->get( false);
    }

    public function uploadListingImage( $listingId, $parameters = [])
    {
        $this->requester->resource = '/listings/'.$listingId.'/images';
        return $this->requester->post( $parameters );
    }

    public function deleteListingImage($listingId, $listingImageId)
    {
        $this->requester->resource = "/listings/{$listingId}/images/$listingImageId";
        return $this->requester->delete();
    }

    public function deleteListing($listingId){
        $this->requester->resource = '/listings/'.$listingId;

        return $this->requester->delete();
    }

    public function createListing( $listingData ){
        $this->requester->resource = '/listings';
        return $this->requester->post( $listingData );
    }

    public function createListingVariations( $listingId, $variations )
    {
        $this->requester->resource = '/listings/'.$listingId.'/variations';

        return $this->requester->post( $variations );
    }

    public function updateListingVariations( $listingId, $variations ){
        $this->requester->resource = '/listings/'.$listingId.'/variations';

        return $this->requester->put( $variations );
    }

    public function createListingVariation($listingId, $propertyId, $variation)
    {
        $this->requester->resource = '/listings/'.$listingId.'/variations/'.$propertyId;
        return $this->requester->post( $variation );
    }

}