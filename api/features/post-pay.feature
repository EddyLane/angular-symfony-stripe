Feature: POST post_pay

  Scenario: Will return a 403 when not logged in
    Given no payments exist in the system
    And I set header "Content-type" with value "application/json"
    And I generate a stripe token
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
   Given no payments exist in the system
   And I am authenticating as "bob" with "bob" password
   And I set header "Content-Type" with value "application/json"
   And I generate a stripe token
   When I send a POST request to "/payment/pays" with body:
   """
        {
            "token" : "tok_1036Xh2UK86V8cuWZfVmFXlM"
        }
    """
#   Then print response
   Then the response code should be 201