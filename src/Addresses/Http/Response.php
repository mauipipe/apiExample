<?php

/**
 * @author davidcontavalli 
 */

namespace Addresses\Http;


class Response
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

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function send()
    {

        return json_encode($this->data);
    }

    public function setHeader($httpHeader)
    {
        $this->headers[] = $httpHeader;
    }

    public function getHeader()
    {
        return implode(' ', $this->headers);
    }
}