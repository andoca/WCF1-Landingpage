<?php
// wcf imports
require_once (WCF_DIR . 'lib/system/event/EventListener.class.php');

/**
 * Listens to new incoming search queries from internal search
 * and external search engines (via http referer)
 *
 * @author Andreas Diendorfer
 * @copyright 2011 Andoca Haustier-WG UG
 * @license commercial - do not copy!
 *         
 */
class LpGeneratorListener implements EventListener {

	/**
	 *
	 * @see EventListener::execute()
	 */
	public function execute($eventObj, $className, $eventName) {
		if ($eventName == 'assignVariables') {
			/**
			 * assignVariables is the listener for
			 * internal searches via SearchResultPage
			 */
			
			// check if this search result also has posts
			foreach ($eventObj->result as $result) {
				if ($result ['messageType'] == 'post') {
					$this->updateQueryStrings($eventObj->query);
					break;
				}
			}
			
			WCF::getTPL()->assign(array (
					'allowSpidersToIndexThisPage' => true 
			));
		} else if ($eventName == 'show') {
			/**
			 * show is the listener for
			 * incoming searches (via http referer)
			 */
			if (isset($_SERVER ["HTTP_REFERER"]) && $_SERVER ["HTTP_REFERER"] != '') {
				$ref = $_SERVER ["HTTP_REFERER"];
				$google = array ();
				if (preg_match('/google\./i', $ref)) {
					// we have found a google referer
					$ref .= '&';
					// preg_match('/google\.(.*)\//Uis', $ref, $google
					// ['country']);
					preg_match('/q=(.*)&/UiS', $ref, $google ['q']);
					// preg_match('/start=(.*)&/UiS', $ref, $google ['start']);
					// preg_match('/num=(.*)&/Uis', $ref, $google ['num']);
					if (isset($google ['q'] [1])) {
						$google ['q'] [1] = urldecode($google ['q'] [1]);
						$this->updateQueryStrings($google ['q'] [1], 1);
					}
				}
			}
		}
	}

	/**
	 * updates the query logging table
	 *
	 * @param $q string
	 *       	 the search string of the performed search or referer
	 */
	private function updateQueryStrings($q, $external = 0) {
		// check if this is a search and not a click from the LpGeneratorPage
		if (isset($_SERVER ["HTTP_REFERER"]) && $_SERVER ["HTTP_REFERER"] != '') {
			if (preg_match('/page\=LpGenerator/i', $_SERVER ['HTTP_REFERER']))
				return;
		}
		if (strlen($q) > 3) {
			try {
				$sql = "INSERT INTO 
							wbb" . WBB_N . "_lpgenerator_queries (
								string, 
								counter, 
								external
							) VALUES (
								'" . escapeString($q) . "', 
								1, 
								" . $external . "
							)
						ON DUPLICATE KEY UPDATE 
								counter = counter+1
				";
				WCF::getDB()->sendQuery($sql);
			} catch (Exception $e) {
				error_log($e->getMessage());
				// we catch every exception so that the plugin won't display an
			// error message to the user
			}
		}
	}
}
?>