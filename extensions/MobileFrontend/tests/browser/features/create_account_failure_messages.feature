@chrome @en.m.wikipedia.beta.wmflabs.org @firefox @test2.m.wikipedia.org @vagrant
Feature: Create failure messages
  Background:
    Given I am on the sign-up page

  Scenario: Create account password mismatch message
    When I sign up with two different passwords
    Then I see an error indicating they do not match
      And I should still be on the sign-up page
