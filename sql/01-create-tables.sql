-- 01. SQL Init - Create tables

-- Cleanup
DROP TABLE IF EXISTS test;

-- Entities
\! echo "Creating tables:"

-- test
CREATE TABLE test (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255),
  message TEXT
);
\! echo " * test"

