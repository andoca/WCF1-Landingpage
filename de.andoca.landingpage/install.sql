CREATE TABLE IF NOT EXISTS `wbb1_1_lpgenerator_queries` (
  `queryID` int(11) unsigned NOT NULL auto_increment,
  `string` varchar(255) NOT NULL,
  `counter` int(11) unsigned NOT NULL,
  `external` int(1) unsigned NOT NULL default 0,
  `lastSearched` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  PRIMARY KEY  (`queryID`),
  UNIQUE KEY stringexternal (string, external),
  KEY `counter` (`counter`),
  KEY `external` (`external`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;