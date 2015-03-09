@chrome @en.m.wikipedia.beta.wmflabs.org @firefox @test2.m.wikipedia.org @vagrant
Feature: Toggling sections

  Background:
    Given I am using the mobile site
      And I am viewing the site in mobile mode
      And I go to a page that has sections

  Scenario: Respect the hash on sections
    When I visit the page "Selenium section test page" with hash "#Section_2A"
    Then the heading element with id "Section_2A" is visible

  Scenario: Opening a section on mobile
    When I click on the first collapsible section heading
    Then I see the content of the first section

  Scenario: Closing a section on mobile
    When I click on the first collapsible section heading
      And I click on the first collapsible section heading
    Then I do not see the content of the first section
