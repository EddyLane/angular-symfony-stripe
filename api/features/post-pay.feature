Feature: POST post_pay

  Background:
    Given no payments exist in the system
    And I set header "Content-type" with value "application/json"


  Scenario: Will return a 403 when not logged in
    When I send a POST request to "/payment/pays.json" with body:
    """
        {
            "token" : 12459
        }
    """
    Then the response code should be 403
    And the response should contain "User not logged in"
    And only the following payments should now exist in the system:
      | id |


  Scenario: Will return 201 when payment successful
  Given I am authenticating as "bob" with "bob" password
    And I generate a stripe token from the following card details:
      | number              | cvc | exp_month | exp_year |
      | 4242 4242 4242 4242 | 123 | 12        | 2013     |
    When I send a POST request to "/payment/pays" with the generated token
    Then the response code should be 201
    And the response should contain json:
    """
        {
            "completed" : true
        }
    """
    And only the following payments should now exist in the system:
      | id | token     | completed |
      | 1  | { token } | true      |


  Scenario: Will return 400 when no token has been posted
   Given I am authenticating as "bob" with "bob" password
    When I send a POST request to "/payment/pays.json" with body:
    """
        {
        }
    """
    Then the response code should be 400
    And only the following payments should now exist in the system:
      | id |

  Scenario: Will return 402 when a card is declined
    Given I am authenticating as "bob" with "bob" password
    And I generate a stripe token from the following card details:
      | number              | cvc | exp_month | exp_year |
      | 4000 0000 0000 0002 | 123 | 12        | 2013     |
    When I send a POST request to "/payment/pays" with the generated token
    Then the response code should be 402
    And the response should contain json:
    """
        {
          "code": 402,
          "message": "Your card was declined."
        }
    """
    And only the following payments should now exist in the system:
      | id |
