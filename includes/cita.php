<?php

require_once(LIB_PATH.DS."database.php");

class Cita extends DatabaseObject{
    protected static $table_name = "citas";
    protected static $db_fields = array('user_id', 'texto', 'autor');
    public $user_id;
    public $texto;
    public $autor;

    public function __construct($user_id, $texto, $autor){
        $this->user_id = $user_id;
        $this->texto = $texto;
        $this->autor = $autor;
    }

    protected function attributes(){
        // return an array of attribute keys and their values
        $attributes = array();
        foreach(self::$db_fields as $field){
            if(property_exists($this, $field)){
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
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
    
}

?>