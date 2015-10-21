<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/18/15
 * Time: 9:41 PM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class Taxonomy {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester ){
        $this->requester = $requester;
    }


    public function getSellerTaxonomy ( )
    {
        $this->requester->resource = '/taxonomy/seller/get';

        return $this->requester->get( false );
   }


    public function getBuyerTaxonomy()
    {
        $this->requester->resource = '/taxonomy/buyer/get';

        return $this->requester->get( false );
    }

}