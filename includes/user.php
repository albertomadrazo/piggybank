<?php 

require_once(LIB_PATH.DS."database.php");

class User extends DatabaseObject{
    protected static $table_name = "users";
    protected static $db_fields = array('id', 'username', 'password', 'full_name', /*'last_name', */'email');
    public $id;
    public $username;
    public $password;
    public $full_name;
    public $email;
    // public $last_name;

    public function full_name(){
        if(isset($this->first_name) && isset($this->last_name)){
            return $this->first_name." ".$this->last_name;
        } else{
            return "";
        }
    }

    public function get_name_in_array(){
        return explode(" ", $this->full_name);
    }

    public static function authenticate($username="", $password=""){
        global $database;
        $username = $database->escape_value($username);

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username = '{$username}' ";
        $sql .= "LIMIT 1";

        $result_array = self::find_by_sql($sql);
        echo "result_array = ";
        print_r($result_array);
        echo "<br>password = ". $password."<br>";

        $mierda = "caca";
        $vri = password_hash($mierda, PASSWORD_DEFAULT);
        echo "<br>".$vri."<br>";
        var_dump(password_verify($mierda, $vri));

        $encrypted_password = trim($result_array[0]->password);


        if(password_verify($password, $encrypted_password) == true){
            return !empty($result_array) ? array_shift($result_array) : false;
        } else{
            echo "<strong><br>Contraseña equivocada.</strong><br>";
        }
    }


    public static function sign_up($username="", $password="", $full_name="", $email=""){
        global $database;
        $username = $database->escape_value($username);
        // Checar que no modifique mi cadena hasheada
        $password = password_hash(trim($password), PASSWORD_DEFAULT);
        $full_name = $database->escape_value($full_name);
        $email = $database->escape_value($email);

        // Checa si el usuario ya existe
        $sql = "SELECT * FROM users ";
        $sql .= "WHERE username='{$username}'";
        $result_array = self::find_by_sql($sql);

        // Si el usuario no existe
        if(empty($result_array)){
            // Crear un nuevo usuario
            $sql = "INSERT INTO users(username, password, full_name, email) ";
            $sql .= "VALUES('{$username}','{$password}', '{$full_name}', '{$email}')";
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