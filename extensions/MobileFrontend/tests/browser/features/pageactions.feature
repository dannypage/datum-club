@chrome @en.m.wikipedia.beta.wmflabs.org @firefox @test2.m.wikipedia.org @vagrant
Feature: Page actions menu when anonymous

  Background:
    Given I am using the mobile site
      And I am viewing an article

  Scenario: Receive notification message - Edit Icon
    When I click the edit icon holder
    Then I see drawer with message "Help improve this page!"

  Scenario: Do not see - Upload Icon
    Then there is not an upload an image to this page button

  Scenario: Receive notification message - Watchlist Icon
    When I click on watchlist icon
    Then I see drawer with message "Keep track of this page and all changes to it."
