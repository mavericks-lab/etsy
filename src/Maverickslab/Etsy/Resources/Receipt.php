<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/18/15
 * Time: 9:41 PM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class Receipt {

    /**
     * @var ApiRequester
     */
    private $requester;

    public function __construct ( ApiRequester $requester ){
        $this->requester = $requester;
    }


    public function getAllShopReceipts ( $shopId, $parameters=[], $background= false, $status = 'all')
    {
        $this->requester->resource = ($background) ? '/shops/'.$shopId.'/receipts': '/shops/'.$shopId.'/receipts/'.$status ;

        return $this->requester->get( true, null, $parameters );
    }

    public function updateReceipt( $receiptId, $receipt_details )
    {
        $this->requester->resource = '/receipts/'.$receiptId;

        return $this->requester->put( $receipt_details );
    }

    public function submitTracking($shopId, $receiptId, $tracking_data )
    {
        $this->requester->resource = "/shops/{$shopId}/receipts/{$receiptId}/tracking";

        return $this->requester->post( $tracking_data );
    }

}