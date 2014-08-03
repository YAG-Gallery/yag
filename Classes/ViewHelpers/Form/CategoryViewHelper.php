<?php

class Tx_Yag_ViewHelpers_Form_CategoryViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\SelectViewHelper {


	/**
	 * @var \TYPO3\CMS\Extbase\Domain\Repository\CategoryRepository
	 * @inject
	 */
	protected $categoryRepository;


	/**
	 * @var array
	 */
	protected static $categoryDataCache = array();


	/**
	 * Initialize arguments.
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		parent::initializeArguments();

		$this->registerTagAttribute('categoryPid', 'integer', 'The Pid, where the categories should be taken from', TRUE);
		$this->overrideArgument('options', 'array', 'Associative array with internal IDs as key, and the values are displayed in the select box', FALSE);
	}


	/**
	 * @return string
	 */
	public function render() {

		$this->arguments['options'] = $this->buildOptions($this->buildCategoryData());

		return parent::render();
	}


	/**
	 * @param $categories
	 * @return array
	 */
	protected function buildOptions($categories) {
		$options = array();

		foreach($categories as $category) { /** @var \TYPO3\CMS\Extbase\Domain\Model\Category $category */
			$options[$category->getUid()] = $category->getTitle();
		}

		return $options;
	}


	/**
	 * @return array
	 */
	protected function buildCategoryData() {
		$pid = (int) $this->arguments['categoryPid'];

		if(!array_key_exists($pid, self::$categoryDataCache)) {
			self::$categoryDataCache[$pid] = $this->categoryRepository->findByPid($pid);
		}

		return self::$categoryDataCache[$pid];
	}
}
