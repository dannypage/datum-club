When(/^I click on the first collapsible section heading$/) do
  on(ArticlePage).first_section_element.when_present.click
end

Then(/^I see the content of the first section$/) do
  on(ArticlePage).first_section_content_element.when_present(10).should be_visible
end

Then(/^I do not see the content of the first section$/) do
  on(ArticlePage).first_section_content_element.should_not be_visible
end

Then(/^the heading element with id "(.*?)" is visible$/) do |id|
  # Wait for first section heading to have class showing that the toggling code has loaded
  on(ArticlePage).first_section_element.when_present(15)
  on(ArticlePage).span_element(:id => id).when_present.should be_visible
end
