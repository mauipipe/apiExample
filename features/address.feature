Feature:
  In order to retrieve a list of addresses
  As a API user
  I should be able to retrieve addresses throw an endpoint

  Background:
    Given the system is empty
    Given there are the following address in the system:
      | name | phone         | street       |
      | Doug | +491232213213 | Lane Steet 2 |
      | Mary | +491232213213 | Lane Steet 5 |

  @multi_result
  Scenario: Retrieves a list of addresses
    When I send a "GET" request to "/address"
    Then I should have a "200" status code
    And print response
    And the response should be:
    """
    [
      {
      	"id": "1",
      	"name": "Doug",
      	"phone": "+491232213213",
      	"street": "Lane Steet 2"
      },
      {
      	"id": "2",
      	"name": "Mary",
      	"phone": "+491232213213",
      	"street": "Lane Steet 5"
      }
    ]
    """

  @single_result
  Scenario: Retrieves a list of addresses
    When I send a "GET" request to "/address/1"
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

  @add_address
  Scenario: Retrieves a list of addresses
    When I send a "POST" request to "/address" with values:
      | name | phone        | street       |
      | Tom  | +49123221373 | Lane Steet 4 |
    And print response
    Then I should have a "201" status code
    When I send a "GET" request to "/address"
    And the response should be:
    """
    [
      {
      	"name": "Doug",
      	"phone": "+491232213213",
      	"street": "Lane Steet 2"
      },
      {
      	"name": "Mary",
      	"phone": "+491232213213",
      	"street": "Lane Steet 5"
      },
      {
      	"name": "Tom",
      	"phone": "+49123221373",
      	"street": "Lane Steet 4"
      }
    ]
    """

  @update_address
  Scenario: Update existing address
    When I send a "PUT" request to "/address/1" with values:
      | name | phone        | street       |
      | Tom  | +49123221373 | Lane Steet 4 |
    And print response
    Then I should have a "200" status code
    When I send a "GET" request to "/address"
    And the response should be:
    """
    [
      {
      	"name": "Tom",
      	"phone": "+49123221373",
      	"street": "Lane Steet 4"
      },
      {
      	"name": "Mary",
      	"phone": "+491232213213",
      	"street": "Lane Steet 5"
      }
    ]
    """