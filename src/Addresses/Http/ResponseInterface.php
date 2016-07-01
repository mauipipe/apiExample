<?php
/**
 * @author davidcontavalli 
 */

namespace Addresses\Http;

interface ResponseInterface
{
    /**
     * @return string
     */
    public function getStatusCode();
    
    /**
     * @param string $httpHeader
     */
    public function setHeader($httpHeader);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @return array
     */
    public function getHeaders();
}