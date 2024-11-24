<?php

class Db{
    
    public $serverName = "localhost";
    public $userName = "root";
    public $password = "Password123";
    public $dbName = "todolistdb"; 

    public function connect(){
        try {
            $dsn = "mysql:host=$this->serverName;dbname=$this->dbName";
            $connect = new PDO($dsn, $this->userName, $this->password);
            $connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            return $connect;
        } catch (PDOException $e){
            echo "Connection failed : ". $e->getMessage();
          }
    }
}