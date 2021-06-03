<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Client;

/**
 * Api Client Interface
 */
interface ApiClientInterface
{    
    /**
     * Send an Api request.
     *
     * @param string $method  HTTP method.
     * @param string Api path
     * @param mixed  Request data
     * @return mixed
     */
    public function request(string $method, string $path, $data = null);

    /**
     * Set header
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader(string $key, string $value): void;
}
