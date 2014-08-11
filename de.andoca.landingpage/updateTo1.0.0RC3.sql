ALTER TABLE wbb1_1_lpgenerator_queries DROP INDEX string;
ALTER TABLE wbb1_1_lpgenerator_queries ADD UNIQUE stringexternal (string, external);
