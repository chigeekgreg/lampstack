-- 02. SQL Init - Load sample data

-- Load sample data from CSV files
\! echo "Loading sample data:"

-- test
LOAD DATA LOCAL INFILE '../seed/test.csv'
INTO TABLE test
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES;
\! echo " * test"
