Feature: POST post_pay

  Scenario: Will return a 403 when not logged in
   Given no payments exist in the system
    When I set header "Content-type" with value "application/json"
    Then I send a POST request to "/pays.json" with body:
    """
        {
            "token" : 12459
        }
    """
    And the response code should be 403
    And the response should contain "User not logged in"
    And only the following payments should now exist in the system:
    | id |