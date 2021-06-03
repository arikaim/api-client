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
            $data = \json_encode($params);
            $this->client->addHeader('Params',$data);
        }
        
        return $this->client->request('GET','core/api/ui/component/' . $name);
    } 
}
