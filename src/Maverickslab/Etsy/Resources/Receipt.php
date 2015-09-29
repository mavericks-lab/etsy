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


    public function getAllShopReceipts ( $shopId, $parameters=[], $status = 'all')
    {
        $this->requester->resource = '/shops/'.$shopId.'/receipts/'.$status;

        return $this->requester->get( true, null, $parameters );
   }

}