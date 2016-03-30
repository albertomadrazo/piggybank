<?php

class Ahorro extends DatabaseObject {
   
    protected static $table_name = 'ahorro';
    protected static $db_fields = array('user_id', 'meta_de_ahorro', 'slug', 'total', 'cantidad_a_abonar', 'periodo', 'intervalo', 'ahorro_parcial', 'fecha_inicial', 'fecha_final', 'tipo_de_ahorro');

    public $user_id;
    public $meta_de_ahorro;
    public $total;
    public $cantidad_a_abonar;
    public $periodo;
    public $intervalo;
    public $ahorro_parcial;
    public $fecha_inicial;
    public $fecha_final;
    public $tipo_de_ahorro;
    public $slug;

    public function __construct($user_id, $meta_de_ahorro, $slug, $total, $cantidad_a_abonar, $periodo, $intervalo, $ahorro_parcial, $fecha_inicial, $fecha_final, $tipo_de_ahorro){
        $this->user_id = $user_id;
        $this->meta_de_ahorro = $meta_de_ahorro;
        $this->total = $total;
        $this->cantidad_a_abonar = $cantidad_a_abonar;
        $this->periodo = $periodo;
        $this->intervalo = $intervalo;
        $this->ahorro_parcial = $ahorro_parcial;
        $this->fecha_inicial = $fecha_inicial;
        $this->fecha_final = $fecha_final;
        $this->tipo_de_ahorro = $tipo_de_ahorro;
        $this->slug = $slug;
        // $this->slug = slugify($this->meta_de_ahorro);
    }

    public static function slugify($input){
        // Código tomado de 
        // http://stackoverflow.com/questions/7530238/convert-ascii-and-utf-8-to-non-special-characters-with-one-function
        $string = html_entity_decode($input,ENT_COMPAT,"UTF-8");
        $oldLocale = setlocale(LC_CTYPE, '0');  
        setlocale(LC_CTYPE, 'en_US.UTF-8');
        $string = iconv("UTF-8","ASCII//TRANSLIT",$string);
        setlocale(LC_CTYPE, $oldLocale);

        return strtolower(preg_replace('/[^a-zA-Z0-9]+/','-',$string));
    }

    public static function get_by_user_id($id){
        // Get the database records by user_id, returns an array of arrays
        $metas_array = array();
        $sql = "SELECT * FROM ahorro WHERE user_id = " . $id;
        $result = static::find_by_sql_without_instantiation($sql);

        while($row = mysqli_fetch_assoc($result)){
            array_push($metas_array, $row);
        }

        return $metas_array;
    }

    public static function find_by_sql($sql){
        $sql_array = array();

        $result = static::find_by_sql_without_instantiation($sql);

        while($row = mysqli_fetch_assoc($result)){
            $sql_array[] = $row;
        }

        return $sql_array;
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

    public static function update_savings($abono, $slug, $id){
        global $database;
        $sql = "UPDATE ahorro SET ahorro_parcial=";
        $sql .= $abono;
        $sql .= " WHERE slug='".$slug."' AND user_id='".$id."'";


        $database->query($sql);
        return ($database->affected_rows() == 1) ? true : false;
    }

    public static function delete_goal($id, $slug){
        global $database;
        $sql = "DELETE FROM ahorro WHERE user_id='".$id."' AND slug='".$slug."'";
        $database->query($sql);

        return ($database->affected_rows() == 1) ? true : false;
    }

    public function giveVariablesForTab($id){
        $user_savings = self::get_by_user_id($id);
        $goal = array();
        $subgoal = array(); 

        foreach($user_savings as $meta){
            $subgoal = array();
            foreach($meta as $key=>$value){
                $subgoal[$key] = $value;
            }
            array_push($goal, $subgoal);
        }   

        return json_encode($goal);
    }
}

?>