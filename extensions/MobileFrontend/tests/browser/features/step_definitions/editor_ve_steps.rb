Given(/^I am editing a new article with VisualEditor$/) do
  api.create_page "Selenium Test Edit", ""
  step 'I am on the "Selenium Test Edit" page'
  step "I click the edit button"
  step "I click the editor mode switcher button"
  step "I click the VisualEditor button"
  step "VisualEditor has loaded"
end

Given(/^VisualEditor has loaded$/) do
  expect(on(ArticlePage).editor_ve_element.when_present(20)).to exist
end

When(/^I switch to editing the source$/) do
  step "I click the editor mode switcher button"
  step "I click the source editor button"
end

When(/^I look at the VisualEditor toolbar$/) do
  expect(on(ArticlePage).overlay_ve_header_toolbar_element).to exist
end

Then(/^I see a bold button$/) do
  expect(on(ArticlePage).overlay_ve_header_toolbar_bold_button_element).to exist
end

Then(/^I see an italicize button$/) do
  expect(on(ArticlePage).overlay_ve_header_toolbar_italic_button_element).to exist
end

When(/^I edit the article using VisualEditor$/) do
  on(ArticlePage) do |page|
    @text_to_type = "text-#{rand(32 ** 8).to_s(32)}"
    page.editor_ve_element.when_present.send_keys(" ")
    page.editor_ve_element.send_keys(@text_to_type)
    page.wait_until { page.continue_button_element.enabled? }
    page.continue_button
    page.wait_until { page.submit_button_element.enabled? }
    page.confirm(true) { page.submit_button }
    sleep 2 #this gets around a race condition bug in ChromeDriver where both the confirm and the toast are in the page at once, and Chrome reports either "stale element reference: element is not attached to the page document" or "Element does not exist in cache"
    page.wait_until { page.toast.include?("Your edit was saved") }
    page.wait_until { page.content_element.visible? }
  end
end

Then(/^I see the edit reflected in the article content$/) do
  on(ArticlePage) do |page|
    expect(page.content).to include(@text_to_type)
  end
end

Then(/^I see the article content$/) do
  expect(on(ArticlePage).content_element.when_present).to exist
end

Then(/^I no longer see the VisualEditor$/) do
  expect(on(ArticlePage).editor_ve_element).to_not exist
end