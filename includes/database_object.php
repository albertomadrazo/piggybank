<?php

// creo que se puede cambiar la manera de buscar los paths
// investigar ***
require_once(LIB_PATH.DS.'database.php');

class DatabaseObject{

    public static function find_all(){
        return static::find_by_sql("SELECT * FROM ".static::$table_name);
    }

    public static function find_by_id($id=0){
        global $database;
        $result_array =  static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id = {$id} LIMIT 1");
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function find_by_sql($sql=""){
        // MySQL database class instance
        global $database;
        // return the results of the query and assign them
        $result_set = $database->query($sql);
        // declare an array named $object_array
        $object_array = array();
        // loop through all found rows
        while($row = $database->fetch_array($result_set)){
            // and put each in an object
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }

    public static function find_by_sql_without_instantiation($sql=""){
        // MySQL database class instance
        global $database;
        // return the results of the query and assign them
        $result_set = $database->query($sql);
        // declare an array named $object_array
        // $object_array = array();
        // // loop through all found rows
        // while($row = $database->fetch_array($result_set)){
        //     // and put each in an object
        //     $object_array[] = static::instantiate($row);
        // }
        return $result_set; //$object_array;       
    }

    public static function count_all(){
        global $database;
        $sql = "SELECT COUNT(*) FROM ".self::$table_name;
        $result_set = $database->query($sql);
        $row = $database->fetch_array($result_set);
        return array_shift($row);
    }

    private static function instantiate($record){
        // $class_name = get_called_class(); <---- ???
        $object = new static;
        foreach($record as $attribute=>$value){
            if($object->has_attribute($attribute)){
                $object->$attribute = $value;
            }
        }

        return $object;
    }

    private function has_attribute($attribute){
        // get_object_vars returns an associative array with
        // all attributes (including private ones) as the keys
        // and their current values as the value
        $object_vars = get_object_vars($this);
        // We don't care about the value, we just want to know if
        // the key exists
        // Will return true or false
        return array_key_exists($attribute, $object_vars);
    }

    protected function attributes(){
        // return an array of attribute keys and their values
        $attributes = array();
        foreach(self::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes(){
        global $database;
        $clean_attributes = array();
        // sanitize the values before submitting
        // Note: does not alter the actual value of each attribute
        foreach($this->attributes() as $key=>$value){
            $clean_attributes[$key] = $database->escape_value($value);
        }
        return $clean_attributes;
    }

    public function save(){
        // A new record won't have an id yet
        return isset($this->id) ? $this->update() : $this->create();
    }

    protected function create(){
        global $database;
        // Don't forget your SQL syntax and good habits:
        // - INSERT INTO table (key, key) VALUES ('value', 'value')
        // - single-quotes around al values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO ".self::$table_name."(";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        if($database->query($sql)){
            $this->id = $database->insert_id();
            return true;
        } else{
            return false;
        }
    }

    public function update(){
        global $database;
        // - UPDATE table SET key='value', key='value' WHERE condition
        // - single-quotes around all values
        // - escape all values to prevent SQL injection
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value){
            $attribute_pairs[] = "{$key}='{$value}";
        }
        // echo "-->".self::$table_name."<br>";
        $sql = "UPDATE ".self::$table_name."SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE id=". $database->escape_value($this->id);

        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public function delete(){
        global $database;
        // - DELETE FROM table WHERE condition LIMIT 1
        // - escape all values to prevent SQL injection
        // - use LIMIT 1
        $sql = "DELETE FROM ".self::$table_name;
        $sql .= " WHERE id=". $database->escape_value($this->id);
        $sql .= " LIMIT 1";
        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }
}

?>