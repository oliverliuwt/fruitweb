<?php
class Database{
    private $username;
    private $password;
    private $host;
    private $db;
    public $connection;
    public function __construct(){
        $this -> username = "oliver5642";//getenv('dbuser');
        $this -> password = "";//getenv('dbpassword');
        $this -> host = "127.0.0.1";//getenv('dbhost');
        $this -> db = "fruit";//getenv('dbname');
        $this -> connect();
    }
    private function connect(){
        $this -> connection = mysqli_connect(
            $this -> host,
            $this -> username,
            $this -> password,
            $this -> db
            );
    }
}
?>