<?php

abstract class Model {
    private static $_database;

    //connection à la base
    private static function setDatabase(){
        self::$_database = new PDO('mysql:host=localhost;dbname=projet_v2', 'root', '');
        self::$_database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }
    //On recupere la connection a la base
    protected function getDatabase(){
        if(self::$_database == null){
            $this->setDatabase();
        }
        
        return self::$_database;
    }

    //recupère toutes les entrées d'une table passé en argument
    protected function getAll($table, $obj){
        $var = [];
        $req = self::$_database->prepare('SELECT * FROM '.$table.' ORDER BY id DESC');
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            
            $var[] = new $obj($data);
        
        }
        return $var;
        $req->closeCursor();
    }

    //recupère une entrée d'une table passé en argument et de l'id
    protected function getById($table, $obj, $id){
        $var = [];
        $req = self::$_database->prepare('SELECT * FROM '.$table.' WHERE id = :id');
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        $req->execute();
        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            
            $var[] = new $obj($data);
        
        }
        return $var;
        $req->closeCursor();
    }
}