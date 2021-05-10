<?php

class Category{
    private $_id;
    private $_name;
    
    
    // constructeur
    public function __construct(array $data){
        //var_dump($data);
        $this->hydrate($data);
    }
    //Hydratation des données
    public function hydrate(array $data){
        foreach($data as $key => $value){
            //Récupere le nom du setter qui correspond a l'attribut
            $method = 'set'.ucfirst($key);
            //si le set existe
            if(method_exists($this, $method)){
                $this->$method($value);
                
            }
        }
    }

    public function setId($id){
        $id = (int) $id;
        if($id > 0 ){
            $this->_id = $id;
        }
    }

    public function setCategory_name($name){
       
        if(is_string($name)){
            $this->_name = $name;
        }
    }


    //Recuperation des données
    
    public function getId(){
       
        return $this->_id;
    }
    public function getName(){
       
        return $this->_name;
    }
}