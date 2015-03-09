@chrome @en.m.wikipedia.beta.wmflabs.org @firefox @login @test2.m.wikipedia.org @vagrant
Feature: Manage Watchlist

  Background:
    Given I am logged into the mobile website
      And I am on the "Special:Watchlist" page

  Scenario: Switching to Feed view
    When I switch to the modified view of the watchlist
      And I click the Pages tab
    Then I see a list of diff summary links
      And the modified button is selected

  Scenario: Switching to List view
    When I switch to the modified view of the watchlist
      And I switch to the list view of the watchlist
    Then I see a list of pages I am watching
      And the a to z button is selected
