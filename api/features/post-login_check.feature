Feature: POST login_check

  Scenario: Will return a 200 when user successfully logs in
    And I set header "Content-Type" with value "application/x-www-form-urlencoded"
    When I send a POST request to "/security/login" with form data:
    """
    _username=bob&_password=bob&_remember_me=1
    """
    And the response code should be 200
    And the response should contain json:
    """
    {
      "username": "bob",
      "email": "bob"
    }
    """