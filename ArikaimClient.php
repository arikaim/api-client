<?php
/**
 * Arikaim Api Client
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Client;

use Arikaim\Client\ApiClientInterface;
use Arikaim\Client\Utils\Curl;
use Arikaim\Client\Api\Ui;

/**
 * Arikaim Client
 */
class ArikaimClient implements ApiClientInterface
{   
    /**
     * Api endpoint
     *
     * @var string
     */
    protected $endpoint;

    /**
     * Api key
     *
     * @var string
     */
    private $apiKey;

    /**
     * Verbose level
     *
     * @var integer
     */
    private $verbose = 0;

    /**
     * Request headers
     *
     * @var array
     */
    protected $headers = [];

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $endpoint
     */
    public function __construct(string $apiKey, string $endpoint)
    {
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;

        $this->addHeader('Authorization',$this->apiKey);
        $this->addHeader('Content-Type','application/json');
    }

    /**
     * Ui api
     *
     * @return object
     */
    public function ui()
    {
        return new Ui($this);
    } 

    /**
     * Get request headers
     *
     * @return array
     */
    protected function getRequestHeades(): array
    {
        return $this->headers;
    }

    /**
     * Add header
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function addHeader(string $key, string $value): void
    {
        $this->headers[] = $key . ': ' . $value;
    }

    /**
     * Api request
     *
     * @param string $method
     * @param string $path
     * @param mixed $data
     * @return mixed
     */
    public function request(string $method, string $path, $data = null)
    {
        $headers = $this->getRequestHeades();   
        $url = $this->endpoint . $path;

        $this->consoleMsg("$method Url: $url");
      
        $response = Curl::request($url,$method,$data,$headers);
        $data = \json_decode($response,true);

        return (\is_array($data) == true) ? $data : $response;
    }

    /**
     * Set verbose level
     *
     * @param integer $level
     * @return void
     */
    public function setVerbose(int $level): void
    {
        $this->verbose = $level;
    }

    /**
     * Show console msg
     *
     * @param string $msg
     * @return void
     */
    protected function consoleMsg(string $msg): void
    {
        if ($this->verbose > 0) {
            echo "$msg \n";
        }
    }
}
