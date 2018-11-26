<?php
class Database {

    const HOST = "localhost",
          DBNAME = "mini_jeu_combat",
          LOGIN = "root",
          PWD = "";
    

    static public function Db(){

        $db = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DBNAME , self::LOGIN , self::PWD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING]);
        return $db;
    }
    
}
?>