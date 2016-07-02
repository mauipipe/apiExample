<?php

/**
 * @author davidcontavalli
 */

namespace Addresses\Http;

use Addresses\Serializer\SerializeInterface;

class Response implements ResponseInterface
{
    /**
     * @var array
     */
    private $data;
    /**
     * @var string
     */
    private $type;
    private $statusCode;
    private $headers;

    /**
     * @param array $data
     * @param $statusCode
     * @param $type
     */
    public function __construct(array $data, $statusCode, $type)
    {
        $this->data = $data;
        $this->type = $type;
        $this->statusCode = $statusCode;
        $this->headers = [];
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        $body = [];
        foreach ($this->data as $key => $item) {
            if ($item instanceof SerializeInterface) {
                $item = $item->getData();
            }
            $body[$key] = $item;
        }

        return json_encode($body);
    }

    /**
     * @param string $httpHeader
     */
    public function setHeader($httpHeader)
    {
        $this->headers[] = $httpHeader;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
