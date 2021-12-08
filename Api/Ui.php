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

use Arikaim\Client\Api\Api;

/**
 * Arikaim Ui api
 */
class Ui extends Api
{   
    /**
     * Fetch ui component
     *
     * @param string $name
     * @param mixed $params
     * @return mixed
     */
    public function fetchComponent(string $name, $params = null)
    {
        if (\is_array($params) == true) {         
            $this->client->addHeader('Params',\json_encode($params));
        }
        
        return $this->client->request('GET','core/api/ui/component/' . $name);
    } 

    /**
     * Fetch ui protected component
     *
     * @param string $extensionName 
     * @param string $name
     * @param mixed $params
     * @param string $method
     * @return mixed
     */
    public function fetchProtectedComponent(string $name, string $extensionName, $params = null, string $method = 'GET')
    {       
        $params = (\is_array($params) == true) ? $this->client->addHeader('Params',\json_encode($params)) : $params;                  
        $path = 'api/' . $extensionName . '/ui/component/' . $name;

        return $this->client->request($method,$path,$params);
    } 
}
