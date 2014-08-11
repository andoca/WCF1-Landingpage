<?php

/**
 * Data Class to handle LpGenerator queries
 * 
 * @author	Andreas Diendorfer
 * @copyright	2011 Andoca Haustier-WG UG
 * @license	commercial - do not copy!
 *
 */
class LpGenerator {

	/**
	 * queries with calculated sizes
	 * 
	 * @var array
	 */
	public $links = array ();

	/**
	 * queries from cache
	 * 
	 * @var array
	 */
	public $queries = array ();

	/**
	 * max value of query counter
	 *
	 * @var integer
	 */
	protected $maxCounter = 0;

	/**
	 * min value of query counter
	 *
	 * @var integer
	 */
	protected $minCounter = 4294967295;

	public function loadCache($num = false) {
		WCF::getCache()->addResource('andocaLpgenerator', WBB_DIR . 'cache/cache.andocaLpgenerator-' . PACKAGE_ID . '.php', WBB_DIR . 'lib/system/cache/CacheBuilderLpGenerator.class.php', 0, 86400);
		$this->queries = WCF::getCache()->get('andocaLpgenerator');
		$this->links = $this->readQueries($num);
	}

	/**
	 * reads queries from cache and calculates size
	 * 
	 * @param unknown_type $slice
	 */
	public function readQueries($slice = false) {
		// slice list
		if ($slice)
			$queries = array_slice($this->queries, 0, min($slice, count($this->queries)));
		else
			$queries = $this->queries;
		
		// get min / max counter
		foreach ($queries as $query) {
			if ($query ['counter'] > $this->maxCounter)
				$this->maxCounter = $query ['counter'];
			if ($query ['counter'] < $this->minCounter)
				$this->minCounter = $query ['counter'];
		}
		// assign sizes
		foreach ($queries as $idx=>$query) {
			$queries [$idx] ['size'] = $this->calculateSize($query ['counter']);
		}
		// sort alphabetically
		ksort($queries);
		// return tags
		return $queries;
	}

	/**
	 * Calculate the size of the query in a weighted list
	 *
	 * @param	integer 	$counter 	the number of times a query has been performed
	 * @return	double 		the size to calculate
	 */
	public function calculateSize($counter) {
		$maxSize = 200;
		$minSize = 80;
		if ($this->maxCounter == $this->minCounter) {
			return 100;
		} else {
			return ($maxSize - $minSize) / ($this->maxCounter - $this->minCounter) * $counter + $minSize - (($maxSize - $minSize) / ($this->maxCounter - $this->minCounter)) * $this->minCounter;
		}
	}
}
?>