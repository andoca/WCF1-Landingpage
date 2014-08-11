<?php
// wcf imports
require_once (WCF_DIR . 'lib/system/cache/CacheBuilder.class.php');

/**
 * Reads the search queries
 * 
 * @author	Andreas Diendorfer
 * @copyright	2011 Andoca Haustier-WG UG
 * @license	commercial - do not copy!
 *
 */
class CacheBuilderLpGenerator implements CacheBuilder {

	/**
	 * list of queries
	 * 
	 * @var	array
	 */
	protected $queries = array ();

	/**
	 * @see CacheBuilder::getData()
	 */
	public function getData($cacheResource) {
		$data = array ();
		if (defined('LPGENERATOR_STOPLIST') && LPGENERATOR_STOPLIST != '') {
			$stopList = ArrayUtil::trim(explode("\n", trim(LPGENERATOR_STOPLIST)));
			foreach ($stopList as $idx=>$stopWord) {
				$stopList [$idx] = escapeString($stopWord);
			}
		} else
			$stopList = array ();
		$sql = "SELECT * FROM wbb" . WBB_N . "_lpgenerator_queries WHERE 1";
		if (count($stopList)) {
			$sql .= " AND string NOT REGEXP '" . implode('|', $stopList) . "'";
		}
		
		if (LPGENERATOR_MINSEARCH > 0)
			$sql .= " AND counter >= " . intval(LPGENERATOR_MINSEARCH);
		
		if (LPGENERATOR_MAXAGE > 0) {
			$timestamp = TIME_NOW - (LPGENERATOR_MAXAGE * 24 * 60 * 60);
			$sql .= " AND UNIX_TIMESTAMP(lastSearched) > " . $timestamp;
		}
		
		if (!LPGENERATOR_GOOGLE) {
			$sql .= " AND external = 0";
		}
		
		$sql .= " ORDER BY counter DESC";
		if (LPGENERATOR_LISTLENGTH > 0) {
			$sql .= " LIMIT " . LPGENERATOR_LISTLENGTH;
		}
		
		$query = WCF::getDB()->sendQuery($sql);
		while ($link = WCF::getDB()->fetchArray($query)) {
			$data [strtolower($link ['string'])] = $link;
		}
		return $data;
	}
}
?>