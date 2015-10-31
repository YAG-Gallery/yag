<?php
/**
 * RTE view helper.
 * The value of the text area needs to be set via the "value" attribute, as with all other form ViewHelpers.
 *
 * = Examples =
 *
 * <code title="Example">
 * <f:form.rte name="myRteTextArea" rows="5" cols="40" value="This is shown inside the rte textarea" />
 * <f:form.rte property="content" rows="5" cols="40" /><br />
 * </code>
 *
 * Output:
 * The form output is wrapped with some script tags including javascript from rte (tx_rtehtmlarea)  
 * and is modified: Among other things the onsubmit atrribute of the form is set or modified. 
 * <textarea id="RTEareatx_myext_pi1[myRteTextArea]_1" name="tx_myext_pi1[myRteTextArea]" style="position:relative; left:0px; top:0px; height:380px; width:460px; border: 1px solid black;">This is shown inside the textarea</textarea>
 *
 * @package Fluid
 * @subpackage ViewHelpers\Form
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 * @api
 * @scope prototype
 */

use TYPO3\CMS\Core\Utility\GeneralUtility;

class Tx_Yag_ViewHelpers_TceForms_RteViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
{
    /**
     * The width of the RTE will be expanded, if $docLarge is set to TRUE
     *
     * @var boolean
     */
    public $docLarge = false;

    /**
     * Counter for RTE
     *
     * @var int
     */
    public $RTEcounter;

    /**
     * Form name
     *
     * @var string
     */
    public $formName;

    /**
     * Initial JavaScript to be printed before the form (should be in head, but cannot due to IE6 timing bug)
     *
     * @var string
     */
    public $additionalJS_initial = '';

    /**
     * Additional JavaScript to be printed before the form
     *
     * @var array
     */
    public $additionalJS_pre = array();

    /**
     * Additional JavaScript to be printed after the form
     *
     * @var array
     */
    public $additionalJS_post = array();

    /**
     * Additional JavaScript to be executed on submit
     *
     * @var array
     */
    public $additionalJS_submit = array();

    /**
     * Additional JavaScript to be printed before the form
     *
     * @var string
     */
    protected $additionalJS_pre_complete;

    /**
     * Additional JavaScript to be printed after the form
     *
     * @var string
     */
    protected $additionalJS_post_complete;

    /**
     * The completed JavaScript to be executed on submit
     *
     * @var string
     */
    protected $additionalJS_submit_complete;

    /**
     * Array of standard content for rendering form fields from TCEforms
     *
     * @var array
     */
    public $PA = array();

    /**
     * "special" configuration - what is found at position 4 in the types configuration of a field from record, parsed into an array.
     *
     * @var array
     */
    public $specConf = array();

    /**
     * Configuration for RTEs; A mix between TSconfig and otherwise. 
     * Contains configuration for display, which buttons are enabled, additional transformation information etc.
     *
     * @var array
     */
    public $thisConfig = array();

    /**
     * Constructor. Used to create an instance of tx_rtehtmlarea_pi2 used by the render() method.
     */
    public function __construct()
    {
        $this->RTEObj = GeneralUtility::makeInstance('TYPO3\\CMS\\Rtehtmlarea\\Controller\\FrontendRteController');
    }

    /**
     * @var string
     */
    protected $tagName = 'textarea';

    /**
     * Initialize the arguments.
     *
     * @return void
     * @author Sebastian Kurfürst <sebastian@typo3.org>
     * @api
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerTagAttribute('rows', 'int', 'The number of rows of a text area', true);
        $this->registerTagAttribute('cols', 'int', 'The number of columns of a text area', true);
        $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
        $this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', false, 'f3-form-error');
        $this->registerUniversalTagAttributes();
    }


    /**
     * Renders the rte htmlarea.
     *
     * @return string
     * @author Frank Frewer <info@frankfrewer.de>
     * @api
     */
    public function render()
    {
        $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\TimeTracker;

        // ***********************************
        // Creating a fake $TSFE object
        // ***********************************
        $id = isset($HTTP_GET_VARS['id'])?$HTTP_GET_VARS['id']:0;
        $GLOBALS['TSFE'] = GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $TYPO3_CONF_VARS, $id, '0', 1, '', '', '', '');
        $GLOBALS['TSFE']->initFEuser();
        $GLOBALS['TSFE']->fe_user->dontSetCookie = true;
        $GLOBALS['TSFE']->fetch_the_id();
        $GLOBALS['TSFE']->getPageAndRootline();
        $GLOBALS['TSFE']->initTemplate();
        $GLOBALS['TSFE']->tmpl->getFileName_backPath = PATH_site;
        $GLOBALS['TSFE']->forceTemplateParsing = 1;
        $GLOBALS['TSFE']->getConfigArray();
        $GLOBALS['TSFE']->newCObj();

        $name = $this->getName();
        $property = $this->arguments['property'];

        $this->registerFieldNameForFormTokenGeneration($name);

        $this->tag->forceClosingTag(true);
        $this->tag->addAttribute('name', $name);
        $this->tag->setContent($this->getValue());

        $this->setErrorClassAttribute();

        $value = $this->renderChildren();

        // RTE 
        $RTEtypeVal = 'text';
        $this->RTEcounter++;

        $this->PA['itemFormElName'] = $name;
        $this->PA['itemFormElValue'] = $this->getValue();
        $thePidValue = $GLOBALS['TSFE']->id;
        $RTEItem = $this->RTEObj->drawRTE($this, '', $property, $row=array(), $this->PA, $this->specConf, $this->thisConfig, $RTEtypeVal, '', $thePidValue);

        $this->additionalJS_pre_complete = $this->additionalJS_initial.'
		<script type="text/javascript">'. implode(chr(10), $this->additionalJS_pre) . "
		</script>\n";

        $this->additionalJS_post_complete = '
			<script type="text/javascript">'. implode(chr(10), $this->additionalJS_post) . "
			</script>\n";

        $placeHolderElementName = substr_replace($name, '_TRANSFORM_', strlen($name)-strlen($property)-1, 0);

        $submitPost .= "
		var transformField=document.getElementsByName('" . $placeHolderElementName . "').item(0);
		if (transformField) {
			transformField.parentNode.removeChild(transformField);
		}";
        
        $this->additionalJS_submit_complete = implode(';', $this->additionalJS_submit) . $submitPost;

        $this->addRteJsToViewHelperVariableContainer();
        $content = $RTEItem;
        return $content;
    }
    /**
     * Adds the JavaScript that is bound to this rte field to the ViewHelperVariableContainer.
     *
     * @return void
     */
    protected function addRteJsToViewHelperVariableContainer()
    {
        if ($this->viewHelperVariableContainer->exists('Tx_Fluid_ViewHelpers_Form_RteViewHelper', 'rte')) {
            $rte = $this->viewHelperVariableContainer->get('Tx_Fluid_ViewHelpers_Form_RteViewHelper', 'rte');
        } else {
            $rte = array();
        }
        $rte[] = array('pre' => $this->additionalJS_pre_complete,
                 'post' => $this->additionalJS_post_complete,
                 'submit' => $this->additionalJS_submit_complete,
                );
        $this->viewHelperVariableContainer->addOrUpdate('Tx_Fluid_ViewHelpers_Form_RteViewHelper', 'rte', $rte);
    }
}
