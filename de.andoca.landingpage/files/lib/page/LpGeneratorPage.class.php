<?php
//wcf imports
require_once (WCF_DIR . 'lib/page/AbstractPage.class.php');
require_once (WBB_DIR . 'lib/data/lpgenerator/LpGenerator.class.php');

class LpGeneratorPage extends AbstractPage {

	public $xml = false;

	public $LpGenerator;

	/**
	 * @see Page::readParameters()
	 */
	public function readParameters() {
		parent::readParameters();
		if (isset($_REQUEST ['xml']))
			$this->xml = (bool) intval($_REQUEST ['xml']);
	}

	/**
	 * @see AbstractPage::readData();
	 */
	public function readData() {
		parent::readData();
		$this->LpGenerator = new LpGenerator();
		$this->LpGenerator->loadCache();
	}

	public function show() {
		if ($this->xml)
			$this->templateName = 'lpgeneratorXML';
		else
			$this->templateName = 'lpgeneratorHTML';
		parent::show();
		
		// send xml headers!
		if ($this->xml)
			@header('Content-Type: text/xml; charset=' . CHARSET);
	}

	/**
	 * @see AbstractPage::assignVariables();
	 */
	public function assignVariables() {
		parent::assignVariables();
		WCF::getTPL()->assign(array (
				'links' => $this->LpGenerator->links, 
				'allowSpidersToIndexThisPage' => 'true' 
		));
	}
}
?>