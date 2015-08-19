<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 8/19/15
 * Time: 12:08 PM
 */

namespace Maverickslab\Etsy\Resources;


use Maverickslab\Etsy\ApiRequester;

class Country {

    private $requester;

    public function __construct ( ApiRequester $requester )
    {
        $this->requester = $requester;
        $this->requester->resource = '/countries';
    }


    public function getAllCountries( )
    {
        return $this->requester->get( false );
    }
} 