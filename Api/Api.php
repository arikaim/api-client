<?php
/**
 * Arikaim Api Client
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Client\Api;

/**
 * Arikaim base api class
 */
class Api  
{   
    /**
     * ApiClientInterface
     *
     * @var ApiClientInterface
     */    
    protected $client; 

    /**
     * Constructor
     *
     * @param ApiClientInterface $client
     */
    public function __construct(object $client)
    {
        $this->client = $client;
    }    
}
