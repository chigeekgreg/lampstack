<?php
class Controller {

    /** @var db Database interface */
    protected $db;

    protected $name;

    /**
     * Controller class constructor
     */
    function __construct(?string $name = NULL) {
        include_once '../lib/db.php';
        $this->db = new DB();
        if(is_null($name))
            $this->name = preg_replace('/Controller$/', '', get_class($this));
        else
            $this->name = $name;
    }

    /** 
     * Process POST parameters into an associative array
     * 
     * @param postbody $_POST array
     */
    public function process_multipart_params(array &$postbody) {
        $objects = array();
        $params = array_keys($postbody);
        $count = -1;
        foreach($params as $param) {
            if($count == -1 || $count > count($postbody[$param]))
                $count = count($postbody[$param]);
        }
        for($i = 0; $i < $count; $i++) {
            $object = array();
            foreach($params as $param) {
                $object[$param] = $postbody[$param][$i];
            }
            $objects[] = $object;
        }
        return $objects;
    }

    /** 
     * Get all
     */
    public function index(): array {
        return $this->db->get_table($this->name);
    }

    /**
     * Insert multiple new objects
     * 
     * @param objects array of associative arrays.
     */
    public function insert(array $objects) {
        return $this->db->insert_many($this->name, $objects);
    }

    /**
     * Update multiple objects
     * 
     * @param objects array of associative arrays.
     */
    public function update(array $objects) {
        return $this->db->update_many($this->name, $objects);
    }

    /**
     * Update multiple objects
     * 
     * @param objects array of associative arrays.
     */
    public function delete(array $objects) {
        return $this->db->delete_many($this->name, $objects);
    }
}
?>