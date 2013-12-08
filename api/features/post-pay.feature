Feature: POST post_pay

  @javascript
  Scenario: Will return a 403 when not logged in
    Given no payments exist in the system
    And I set header "Content-type" with value "application/json"
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

 @javascript
 Scenario: Will return 201 when payment successful
   Given I send a GET request to "/logout"
   And the response code should be 200
   And I set header "Content-Type" with value "application/x-www-form-urlencoded"
   And I set header "Cookie" with value "PHPSESSID=l2qlhl88r64hj7soi1o3r3tkj4"
   When I send a POST request to "/login_check" with form data:
   """
    _username=bob&_password=bob&_remember_me=1
    """
   And the response code should be 200
   And the response should contain json:
   """
    {"success":true,"message":{"username":"bob"}}
    """
   Given no payments exist in the system
   And I set header "Content-Type" with value "application/json"
   And I set header "Cookie" with value "PHPSESSID=l2qlhl88r64hj7soi1o3r3tkj4"
   And I set header "Host" with value "app.angular-symfony-stripe.local"
   When I send a POST request to "/payment/pays" with body:
   """
        {
            "token" : 12459
        }
    """
   Then print response
   Then the response code should be 201