<?php
class DB {

    /** @var pdo is in anstance of the PHP Data Objects class */
    protected $pdo;
    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    /**
     * DB class constructor
     */
    function __construct() {
        if(!is_readable('../config/config.php'))
            die("Can't open config file.");
        include '../config/config.php';
        if(!isset($config))
            die("Config not set");
        if(!isset($config['db']))
            die("Config:db not set");
        foreach(['host', 'name', 'user', 'pass', 'options'] as $setting) {
            if(!isset($config['db'][$setting]))
                die("Config:db:$setting not set\n");
        }
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['name']}";
        try {
            $this->pdo = new PDO($dsn, $config['db']['user'], $config['db']['pass']);
        } catch (PDOException $e) {
            die("Connection to database failed: ${$e->getMessage()}\n");
        }
    }

    /**
     * Query the database and return the result
     * 
     * This function takes a SQL query string and returns the result as a PDOStatement object
     */
    public function query(string $sql, ?array $args = NULL): PDOStatement {
        if(is_null($args) || empty($args)) {
            // If the $args is null or empty, return a simple PDOStatement::query()
            return $this->pdo->query($sql);
        } else {
            // Otherwise, use a prepared statement
            return $this->pdo->prepare($sql)->execute($args);
        }
    }

    /**
     * Get any table
     */
    public function get_table($tablename): array {
        return $this->query("SELECT * FROM $tablename")->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Safely insert many rows into a table
     * 
     * @param tablename table to insert into
     * @param rows row data
     * 
     * @return array result status
     * 
     */
    public function insert_many(string $tablename, array $rows): array {
        $results = [
            'status' => 200,
            'rows' => 0,
            'message' => 'OK'
        ];
        $columns = array_keys($rows[0]);
        $params = array();
        foreach($columns as $column) {
            $params[] = ":$column";
        }
        $sql = "INSERT INTO $tablename (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $params) . ');';
        try {
            $statement = $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'rows' => 0,
                'message' => 'Error. Could not prepare query. PDOException: ' . $e->getMessage()
            ];
        }
        foreach($rows as $row) {
            $data = array();
            foreach($columns as $column) {
                $data[":$column"] = $row[$column];
            }
            try {
                if($statement->execute($data))
                    $results['rows'] += $statement->rowCount();
                else
                    $results['message'] = 'Error. Could not execute insert for unknown reason.';
            } catch (PDOException $e) {
                $results['status'] = 500;
                $results['message'] = 'Error. Could not execute insert. PDOException: ' . $e->getMessage();
                return $results;
            }
        }
        return $results;
    }

    /**
     * Safely update many rows in a table by ID
     * 
     * @param tablename table to update
     * @param rows row data
     * 
     * @return array result status
     * 
     */
    public function update_many(string $tablename, array $rows): array {
        $results = [
            'status' => 200,
            'rows' => 0,
            'message' => 'OK'
        ];
        $columns = array_keys($rows[0]);
        $updates = array();
        foreach($columns as $column) {
            if($column != 'id')
                $updates[] = "$column = :$column";
        }
        $sql = "UPDATE $tablename SET " . implode(', ', $updates) . ' WHERE id = :id;';
        try {
            $statement = $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'rows' => 0,
                'message' => 'Error. Could not prepare update. PDOException: ' . $e->getMessage()
            ];
        }
        foreach($rows as $row) {
            $data = array();
            foreach($columns as $column) {
                $data[":$column"] = $row[$column];
            }
            try {
                if($statement->execute($data))
                    $results['rows'] += $statement->rowCount();
                else
                    $results['message'] = 'Error. Could not execute update for unknown reason.';
            } catch (PDOException $e) {
                $results['status'] = 500;
                $results['message'] = 'Error. Could not execute update. PDOException: ' . $e->getMessage();
                return $results;
            }
        }
        return $results;
    }

    /**
     * Safely delete many rows in a table by ID
     * 
     * @param tablename table to delete from
     * @param rows row data
     * 
     * @return array result status
     * 
     */
    public function delete_many(string $tablename, array $rows): array {
        $results = [
            'status' => 200,
            'rows' => 0,
            'message' => 'OK'
        ];
        $columns = array_keys($rows[0]);
        $where = array();
        foreach($columns as $column) {
            $where[] = "$column = :$column";
        }
        $sql = "DELETE FROM $tablename WHERE " . implode(' AND ', $where) . ';';
        try {
            $statement = $this->pdo->prepare($sql);
        } catch (PDOException $e) {
            return [
                'status' => 500,
                'rows' => 0,
                'message' => 'Error. Could not prepare delete. PDOException: ' . $e->getMessage()
            ];
        }
        foreach($rows as $row) {
            $data = array();
            foreach($columns as $column) {
                $data[":$column"] = $row[$column];
            }
            try {
                if($statement->execute($data))
                    $results['rows'] += $statement->rowCount();
                else
                    $results['message'] = 'Error. Could not execute delete for unknown reason.';
            } catch (PDOException $e) {
                $results['status'] = 500;
                $results['message'] = 'Error. Could not execute delete. PDOException: ' . $e->getMessage();
                return $results;
            }
        }
        return $results;
    }
}
?>