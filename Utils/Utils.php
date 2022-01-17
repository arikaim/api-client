<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Client\Utils;

use Exception;

/**
 * Utility static functions
 */
class Utils 
{   
   
    /**
     * Return true if text is valid JSON 
     *
     * @param string|null $text
     * @return boolean
     */
    public static function isJson(?string $jsonText): bool
    {        
        if (empty($jsonText) == true) {
            return false;
        }
        try {           
            return \is_array(\json_decode($jsonText,true));         
        } catch(Exception $e) {
            return false;
        }

        return false;
    }
    
    /**
     * Encode array to JSON 
     *
     * @param array $data
     * @return string
     */
    public static function jsonEncode(array $data)
    {
        return \json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
