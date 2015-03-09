@chrome @en.m.wikipedia.beta.wmflabs.org @firefox @login @test2.m.wikipedia.org @vagrant
Feature: Table of contents

  Background:
    Given I am using the mobile site

  Scenario: Don't show table of contents on mobile
    Given I am viewing the site in mobile mode
    When I go to a page that has sections
    Then I do not see the table of contents

  Scenario: Show table of contents on tablet
    Given I am viewing the site in tablet mode
    When I go to a page that has sections
    Then I see the table of contents
