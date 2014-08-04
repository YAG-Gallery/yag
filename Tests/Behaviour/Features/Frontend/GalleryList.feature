Feature:
  In order to see the pictures
  As a website user
  I need to browse through the gallery structure

  Scenario: User browses the gallery structure of the gallery list plugin
    Given I am on the homepage
    And I go to "home/gallery-list/"
    Then I should see the gallery "Reise"
    And I should see the gallery "Work"
