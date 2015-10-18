<?php

use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Behat context class.
 */
class FeatureContext extends \Behat\MinkExtension\Context\MinkContext implements SnippetAcceptingContext
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context object.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct()
    {
    }


    /**
     * @Then I should see the gallery :arg1
     * @Then I should see the album :arg1
     * @Then I should see the image :arg1
     */
    public function iShouldSeeTheGallery($arg1)
    {
        $this->assertPageContainsText($arg1);
    }


    /**
     * @When /^(?:|I )click on "(?P<identifier>(?:[^"]|\\")*)"$/
     */
    public function iClickOn($identifier)
    {
        if ($this->getSession()->getPage()->findLink($identifier)) {
            $this->clickLink($identifier);
        } elseif ($this->getSession()->getPage()->findButton($identifier)) {
            $this->pressButton($identifier);
        } else {
            throw new \Behat\Mink\Exception\ElementNotFoundException(
                $this->getSession(), 'link or button', 'id|title|alt|text', $identifier
            );
        }
    }
}
