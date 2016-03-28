<?php

require_once(LIB_PATH.DS."database.php");

class Cita extends DatabaseObject{
    protected static $table_name = "citas";
    protected static $db_fields = array('user_id', 'texto', 'autor');
    public $user_id;
    public $texto;
    public $autor;

    public function __construct($user_id="", $texto="", $autor=""){
        $this->user_id = $user_id;
        $this->texto = $texto;
        $this->autor = $autor;
    }

    public static function get_random_quote(){
        global $database;

        $citas = static::find_all();
        // print_r($citas);
        // $sql = "SELECT * FROM citas";//.$this->table_name;
        // $result = $database->query($sql);
        // echo $result;
        // print_r($result);
        // print_r($citas);
        $random_quote = rand(0, count($citas)-1);
        return $citas[$random_quote];
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

    // public static function find_all(){
    //     return static::find_by_sql("SELECT * FROM ".static::$table_name);
    // }

    // public static function find_by_id($id=0){
    //     global $database;
    //     $result_array =  static::find_by_sql("SELECT * FROM ".static::$table_name." WHERE id = {$id} LIMIT 1");
    //     return !empty($result_array) ? array_shift($result_array) : false;
    // }

    // public static function find_by_sql($sql=""){
    //     // MySQL database class instance
    //     global $database;
    //     // return the results of the query and assign them
    //     $result_set = $database->query($sql);
    //     // declare an array named $object_array
    //     $object_array = array();
    //     // loop through all found rows
    //     while($row = $database->fetch_array($result_set)){
    //         // and put each in an object
    //         $object_array[] = static::instantiate($row);
    //     }
    //     return $object_array;
    // }

    // private static function instantiate($record){
    //     // $class_name = get_called_class(); <---- ???
    //     $object = new static;
    //     foreach($record as $attribute=>$value){
    //         if($object->has_attribute($attribute)){
    //             $object->$attribute = $value;
    //         }
    //     }

    //     return $object;
    // }

}

?>