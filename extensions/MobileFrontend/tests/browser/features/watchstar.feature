@chrome @en.m.wikipedia.beta.wmflabs.org @firefox @test2.m.wikipedia.org @vagrant
Feature: Manage Watchlist

  Background:
    Given I am logged into the mobile website

  Scenario: Add an article to the watchlist
    Given I am viewing an unwatched page
    When I click the watch star
    Then I see a toast with message about watching the page
      And the watch star is selected

  Scenario: Remove an article from the watchlist
    Given I am viewing a watched page
    When I click the unwatch star
    Then I see a toast with message about unwatching the page
      And the watch star is not selected
