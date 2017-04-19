<?php
require_once __DIR__ . '/../../vendor/autoload.php';
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

#use Behat\MinkExtension\ServiceContainer\MinkExtension

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends Behat\MinkExtension\Context\MinkContext implements Context, \Behat\Behat\Context\SnippetAcceptingContext
{
	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
	}

	/**
	 * @When I click :arg1
	 */
	public function iClick($arg1)
	{
		throw new PendingException();
	}
	/**
	 * @BeforeScenario
	 */
	public function beforeBigWindow($event) {
		$this->getSession()->resizeWindow(1440, 900, 'current');
	}

	/**
	 * @When I unhide :arg1
	 */
	public function iUnhide($arg1)
	{
		$this->getSession()->executeScript('window.$(\'[name="'.$arg1.'"]\').show()');
	}

	/**
	 * @Given I take a screenshot
	 */
	public function iTakeAScreenshot()
	{
		$screenshot = $this->getSession()->getDriver()->getScreenshot();

		$path = __DIR__.'/../assets/'.time().'.png';
		file_put_contents($path, $screenshot);
	}

	/**
	 * @When I wait :arg1
	 */
	public function iWait($arg1)
	{
		$this->getSession()->wait($arg1);
	}

	/**
	 * @When I click on the text :arg1
	 */
	public function iClickOnTheText($text)
	{
		$session = $this->getSession();
		$element = $session->getPage()->find(
			'xpath',
			$session->getSelectorsHandler()->selectorToXpath('xpath', '*//*[text()="'. $text .'"]')
		);
		if (null === $element) {
			throw new \InvalidArgumentException(sprintf('Cannot find text: "%s"', $text));
		}

		$element->click();
	}

    /**
     * @Given I click on the element with selector :selector
     */
	public function iClickOnTheElementWithSelector2($selector)
    {
        $session = $this->getSession();
        $element = $session->getPage()->find(
            'css',
            $selector
        );

        var_dump(count($element));

        if (null === $element) {
            throw new \InvalidArgumentException(sprintf('Cannot find element by selector: "%s"', $selector));
        }

        $element->click();
    }
}
