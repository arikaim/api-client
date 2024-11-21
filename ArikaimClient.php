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

use GuzzleHttp\Client;

use Arikaim\Client\ApiResponse;
use Arikaim\Client\Api\Ui;

/**
 * Arikaim Client
 */
class ArikaimClient
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
     * Request headers
     *
     * @var array
     */
    protected $headers;

    /**
     * Timeout value
     *
     * @var float
     */
    private $timeout;

    /**
     *  GuzzleHttp client
     */
    private $client;

    /**
     * Constructor
     *
     * @param string $apiKey
     * @param string $endpoint
     * @param mixed $timeout
     */
    public function __construct(string $apiKey, string $endpoint, $timeout = null)
    {
        $this->timeout = $timeout ?? 2.0;
        $this->apiKey = $apiKey;
        $this->endpoint = $endpoint;
        $this->headers = [];

        $this->client = new Client([         
            'base_uri' => $this->endpoint,        
            'timeout'  => $this->timeout
        ]);
    }

    /**
     * Get GuzzleHttp\Client
     *
     * @return object
     */
    public function client(): object
    {
        return $this->client;
    }

    /**
     * Remove header
     *
     * @param string $key
     * @return void
     */
    public function removeHeader(string $key): void
    {
        unset($this->headers[$key]);
    }

    /**
     * Save base64 encoded file
     *
     * @param [type] $data
     * @param string $fileName
     * @return boolean
     */
    function saveEncodedFile($data, string $fileName): bool
    {
        if (\base64_decode($data,true) !== false) {
            $data = \base64_decode($data);
        }
       
        try {
            $file = fopen($fileName,"wb"); 
            \fwrite($file,$data); 
            \fclose($file); 
        } catch (\Exception $e) {
            echo $e->getMessage();
            return False;
        }
    
        return True;
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
    public function setHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    /**
     * Api request
     *
     * @param string $method
     * @param string $path
     * @param mixed $data
     * @param string $contentType
     * @return mixed
     */
    public function request(
        string $method, 
        string $path, 
        $data = null, 
        string $contentType = 'application/json'
    )
    {
        $this->setHeader('Content-Type',$contentType);
        if (empty($this->apiKey) == false) {
            $this->setHeader('Authorization',$this->apiKey);
        }
       
        $body = (\is_array($data) == true) ? \json_encode($data) : $data;

        $response = $this->client->request($method,$path,[
            'headers' => $this->getRequestHeades(),
            'body'    => $body
        ]);

        return $this->getApiResponse($response); 
    }

    /**
     * Get api response
     *
     * @param object $response
     * @return ApiResponse
     */
    protected function getApiResponse(object $response): ApiResponse
    {
        try {
            $data = \json_decode($response->getBody(),true);
            return ApiResponse::createFromArray($data);
        } catch (\Exception $e) {
            ApiResponse::createErrorResponse($e->getMessage(),$response->getStatusCode());
        }
    }

    /**
     * Upload file
     *
     * @param string $path
     * @param string $fileName
     * @param string $fieldKey
     * @param array|null $data
     * @return void
     */
    public function upload(string $path, string $fileName, string $fieldKey, array $data = [])
    {
        if (empty($this->apiKey) == false) {
            $this->setHeader('Authorization',$this->apiKey);
        }

        $multipart[] = [
            'name'     => $fieldKey,
            'contents' => \GuzzleHttp\Psr7\Utils::tryFopen($fileName, 'rb')
        ];

        foreach($data as $key => $value) {
            $multipart[] = [
                'name'     => $key,
                'contents' => $value
            ];
        };

        $response = $this->client->request('POST',$path,[
            'headers'   => $this->getRequestHeades(),
            'multipart' => $multipart
        ]);

        return $this->getApiResponse($response);
    }

    /**
     * POST request
     *
     * @param string $path
     * @param mixed $data
     * @return mixed
     */
    public function post(string $path, $data = null)
    {
        return $this->request('POST',$path,$data);
    }

    /**
     * PUT request
     *
     * @param string $path
     * @param mixed $data
     * @return mixed
     */
    public function put(string $path, $data = null)
    {
        return $this->request('PUT',$path,$data);
    }

    /**
     * GET request
     *
     * @param string $path
     * @param mixed $data
     * @return mixed
     */
    public function get(string $path, $data = null)
    {
        return $this->request('GET',$path,$data);
    }

    /**
     * DELETE request
     *
     * @param string $path
     * @param mixed $data
     * @return mixed
     */
    public function delete(string $path)
    {
        return $this->request('DELETE',$path);
    }
}
