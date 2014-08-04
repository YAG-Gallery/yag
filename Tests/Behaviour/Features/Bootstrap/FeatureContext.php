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
    public function __construct() {
    }


	/**
	 * @Then I should see the gallery :arg1
	 */
	public function iShouldSeeTheGallery($arg1) {
		$this->assertPageContainsText($arg1);
	}
}
