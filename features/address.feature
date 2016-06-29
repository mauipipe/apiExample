Feature:
  In order to retrieve a list of addresses
  As a API user
  I should be able to retrieve addresses throw an endpoint

  Scenario: Retrieves a list of addresses
    When I send a "GET" request to "/address"
    And print response
    Then I should have a "200" status code
    And the response should be:
    """
    [
      {
         "name":"test",
         "address":"mercy",
         "nr":23
      },
      {
         "name":"test2",
         "address":"mercy2",
         "nr":45
      }
    ]
    """

  @wip
  Scenario: Retrieves a list of addresses
    When I send a "GET" request to "/address/1"
    And print response
    Then I should have a "200" status code
    And the response should be:
    """
    [
      {
         "name":"test",
         "address":"mercy",
         "nr":23
      }
    ]
    """