Feature:
  In order to see the pictures
  As a website user
  I need to browse through the gallery structure

  Scenario: User browses the gallery structure and sees the galleries
    Given I am on the homepage
    And I go to "home/gallery-list/"
    Then I should see the gallery "Reise"
    And I should see the gallery "Work"

  Scenario: User browses the gallery structure and sees the albums
    Given I am on the homepage
    And I go to "home/gallery-list/"
    When I click on "Reise"
    Then I should see the album "USA"

  Scenario: User browses the gallery structure and sees the images
    Given I am on the homepage
    And I go to "home/gallery-list/"
    And I click on "Reise"
    When I click on "USA"
    Then I should see the image "USA - 0978"

  Scenario: User is able to see a full size image
    Given I am on the homepage
    And I go to "home/gallery-list/"
    And I click on "Reise"
    When I click on "USA - 0978"
    Then I should see "Arches National Park"

  Scenario: User is able to go back to the gallery with the breadcrumb menu
    Given I am on the homepage
    And I go to "home/gallery-list/"
    And I click on "Reise"
    And I click on "USA"
    When I click on "Reise"
    Then I should see the album "USA"

  Scenario: User is able to go back to the gallery list with the breadcrumb menu
    Given I am on the homepage
    And I go to "home/gallery-list/"
    And I click on "Reise"
    When I click on "Alle Galerien"
    Then I should see the gallery "Reise"
    And I should see the gallery "Work"

