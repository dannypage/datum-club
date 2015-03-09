Given(/^I switch to desktop$/) do
  on(ArticlePage).desktop_link_element.click
end

Then(/^I click on the page$/) do
  on(ArticlePage).content_wrapper_element.click
end

Then /^I should see the edit icon$/ do
  on(ArticlePage).edit_button_holder_element.when_present.should be_visible
end

# FIXME: Consolidate with code in editor_steps.rb
# Confusingly we have 2 touch areas when it comes to the edit button
# This is one is needed to triggers the edit CTA and is needed for pageactions.feature
# The one in editor_steps.rb triggers the actual editor
Given(/^I click the edit icon holder$/) do
  on(ArticlePage).edit_button_holder_element.when_present.click
end

Given(/^I click the escape button$/) do
  on(ArticlePage).escape_button_element.when_present.click
end

Given(/^I click continue$/) do
  on(ArticlePage).continue_button_element.when_present.click
end

Given(/^I click submit$/) do
  on(ArticlePage) do |page|
    page.spinner_loading_element.when_not_present
    page.submit_button_element.when_present.click
  end
end

Given(/^I am viewing an article$/) do
  step "I am at a random page"
end

# Watch star
Then(/^I see the watch star$/) do
  on(ArticlePage).watch_link_element.should be_visible
end

When(/^I click the watch star$/) do
  on(ArticlePage).watch_link_element.when_present.click
end

When(/^I click the unwatch star$/) do
  on(ArticlePage).unwatch_link_element.when_present.click
end

Then /^the watch star is selected$/ do
  on(ArticlePage).watch_link_element.parent.class_name.should match "watched"
end

Then /^the watch star is not selected$/ do
  on(ArticlePage).watch_link_element.should exist
end

# Toast notifications
Then(/^I see a toast notification$/) do
  on(ArticlePage).toast_element.when_present.should be_visible
end

Then(/^I see a toast with message "(.*)"$/) do |text|
  on(ArticlePage).toast_element.when_present.text.should match text
end

Then(/^I see a toast error$/) do
  on(ArticlePage).toast_element.when_present.class_name.should match "error"
end

Then(/^the text of the first heading is "(.*)"$/) do |title|
   on(ArticlePage) do |page|
    page.wait_until do
      page.first_heading_element.when_present.text.include? title
    end
    page.first_heading_element.when_present.text.should match title
  end
end

When(/^I click on the history link in the last modified bar$/) do
  on(ArticlePage).last_modified_bar_history_link_element.when_present.click
end

Then /^I see drawer with message "(.+)"$/ do |text|
  on(ArticlePage).drawer_element.when_present.text.should match text
end

Then(/^I should see the error box message "(.+)"$/) do |error_message|
  on(ArticlePage).error_message.should match (error_message)
end

