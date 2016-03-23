<?php 

require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject{
    protected static $table_name = "users";
    protected static $db_fields = array('id', 'username', 'password', 'first_name', 'last_name');
    public $id;
    public $username;
    public $password;
    public $first_name;
    public $last_name;

    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name." ".$this->last_name;
        } else{
            return "";
        }
    }

    public static function authenticate($username="", $password=""){
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public static function sign_up($username="", $password="", $first_name=""){
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
        $first_name = $database->escape_value($first_name);

        // Checa si el usuario ya existe
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username='{%username}'";
        $result_array = self::find_by_sql($sql);

        // Si el usuario no existe
        if(empty($result_array)){
            // Crear un nuevo usuario
            $sql = "INSERT INTO users(username, password, first_name) ";
            $sql .= "VALUES('{$username}','{$password}', '{$first_name}')";
            if($database->query($sql)){
                return true;
            } else{
                return false;
            }
        } else{
            return false;
        }
    }
    
}

?>