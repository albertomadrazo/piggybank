<?php

class MyPostgresDatabase{
    private $connection;

    function __construct(){
        $this->open_connection();
    }

    public function open_connection(){
        $this->connection = pg_connect("host=".DB_SERVER." port=".DB_PORT." dbname=".DB_NAME." user=".DB_USER." password=".DB_PASS);
        // $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if(pg_last_error()){
            die("Database connection failed: ");
        }
        // if(mysqli_connect_errno()){
        //     die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
        // }
    }

    public function close_connection(){
        if(isset($this->connection)){
            pg_close($this->connection);
            // mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function query($sql){
        $result = pg_query($this->connection, $sql);
        // $result = mysqli_query($this->connection, $sql);
        $this->confirm_query($result);
        if(!$result){
            die("Database query failed.");
        }
        return $result;
    }

    private function confirm_query($result){
        if(!$result){
            die("Database query failed.");
        }
    }

    // prepare strings to be correctly submitted in the query
    public function escape_value($string){
        $escape_string = pg_escape_string($this->connection, $string);
        // $escaped_string = mysqli_real_escape_string($this->connection, $string);
        return $escape_string;
    }

    // "database neutral" functions
    public function fetch_array($result_set){
        return pg_fetch_array($result_set);
        // return mysqli_fetch_array($result_set);
    }

    public function num_rows($result_set){
        return pg_num_rows($result_set);
        // return mysqli_num_rows($result_set);
    }

    public function insert_id(){
        // get the last id inserted over the current db connection
        // return mysqli_insert_id($this->connection);
    }

    public function affected_rows($query){
        return pg_affected_rows($query);
        // return mysqli_affected_rows($this->connection);
    }
}


$database = new MyPostgresDatabase();
// Creo que es un alias
$db =& $database;

?>