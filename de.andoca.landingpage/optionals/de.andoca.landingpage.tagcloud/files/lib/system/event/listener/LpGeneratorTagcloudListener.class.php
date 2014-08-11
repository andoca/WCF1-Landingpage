<?php
// wcf imports
require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');
require_once (WBB_DIR . 'lib/data/lpgenerator/LpGenerator.class.php');

/**
 * Displays a tagcloud of the most done queries on the index page
 * in the footer
 * 
 * @author	Andreas Diendorfer
 * @copyright	2011 Andoca Haustier-WG UG
 * @license	commercial - do not copy!
 *
 */
class LpGeneratorTagcloudListener implements EventListener {

	/**
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if (LPGENERATOR_TAGCLOUD) {
			$LpGenerator = new LpGenerator();
			$LpGenerator->loadCache(50);
			
			$additionalBoxes = WCF::getTpl()->get('additionalBoxes');
			if (!empty($additionalBoxes)) {
				$cycle = (strripos($additionalBoxes, 'container-1') < strripos($additionalBoxes, 'container-2') ? 'container-1' : 'container-2');
			} else {
				$cycle = ((MODULE_USERS_ONLINE && INDEX_ENABLE_ONLINE_LIST || INDEX_ENABLE_STATS) && !(MODULE_USERS_ONLINE && INDEX_ENABLE_ONLINE_LIST && INDEX_ENABLE_STATS) ? 'container-2' : 'container-1');
			}
			
			// add template
			WCF::getTpl()->assign(array (
					'LpGeneratorQueries' => $LpGenerator->links, 
					'additionalBoxesLpCycle' => $cycle 
			));
			WCF::getTpl()->append('additionalBoxes', WCF::getTpl()->fetch('LpGeneratorQueriesTagcloud'));
		}
	}
}
?>