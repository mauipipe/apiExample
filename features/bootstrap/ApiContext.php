<?php

use Addresses\DbConnection\DbConnector;
use Addresses\Factory\AddressServiceFactory;
use Addresses\Model\Address;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

class ApiContext implements Context, SnippetAcceptingContext
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param Client $client
     * @param $baseUri
     * @internal param string $baseUrl
     */
    public function __construct($client, $baseUri)
    {
        $this->client = new $client(['base_uri' => $baseUri]);
    }

    /**
     * @Given the system is empty
     */
    public function theSystemIsEmpty()
    {
        DbConnector::destroy();
    }

    /**
     * @Given there are the following address in the system:
     */
    public function thereAreTheFollowingAddressInTheSystem(TableNode $addressTable)
    {
        foreach ($addressTable->getHash() as $item){
            $addressService = AddressServiceFactory::create();
            $addressService->addAddress($item);
        }
        
    }

    /**
     * @When I send a :method request to :url
     */
    public function iSendARequestTo($method, $url)
    {
        $this->response = $this->client->request($method, $url);
    }

    /**
     * @Then I should have a :statusCode status code
     */
    public function iShouldHaveAStatusCode($statusCode)
    {
        $responseStatus = $this->response->getStatusCode();
        $message = sprintf("Status code %d different from expected %d", $responseStatus, $statusCode);

        PHPUnit_Framework_Assert::assertSame((int)$statusCode, $responseStatus, $message);
    }

    /**
     * @Then the response should be:
     *
     * @param PyStringNode $reponse
     */
    public function theResponseShouldBe(PyStringNode $reponse)
    {
        $expectedResponse = json_decode($reponse->getRaw(), 1);
        PHPUnit_Framework_Assert::assertEquals($expectedResponse, json_decode($this->response->getBody()->getContents(), 1));
    }

    /**
     * @Then print response
     */
    public function printResponse()
    {
        $body = $this->response->getBody();
        echo $body;
        $body->rewind(0);
    }
}