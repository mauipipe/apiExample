<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\Http;


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
        return json_encode($this->data);
    }

    /**
     * @param string $httpHeader
     */
    public function setHeader($httpHeader)
    {
        $this->headers[] = $httpHeader;
    }

    /**
     * @return string
     */
    public function getHeader()
    {
        return implode(' ', $this->headers);
    }
}