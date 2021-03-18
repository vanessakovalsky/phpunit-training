Feature: Login
  In order to log
  As a user
  I need to be able to submit form on login page

  Scenario: Send Login
    Given I am in login page
    When I put 'v.david@kovalibre.com' on email field and 'symfony0520' on password field
    Then I should be redirect to /home
