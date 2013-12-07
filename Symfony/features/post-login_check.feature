Feature: POST login_check

  @javascript
  Scenario: Will return a 200 when user successfully logs in
    And I set header "Content-Type" with value "application/x-www-form-urlencoded"
    When I send a POST request to "/login_check" with form data:
    """
    _username=bob&_password=bob
    """
    And the response code should be 200
    And the response should contain json:
    """
    {"success":true,"message":{"username":"bob"}}
    """