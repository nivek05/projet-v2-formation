<?php

class Article {
    private $_id;
    private $_name;
    private $_title;
    private $_content;
    private $_categoryId;
    private $_categoryName;

    
    // constructeur
    public function __construct(array $data){
        //$this->_categoryName = $data['categoryName'];
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

    public function setArticle_title($title){
       
        if(is_string($title)){
            $this->_title = $title;
        }
    }

    public function setArticle_content($content){
       
        if(is_string($content)){
            $this->_content= $content;
        }
    }

    public function setArticle_name($name){
       
        if(is_string($name)){
            $this->_name= $name;
        }
    }

    public function setArticle_category($categoryId){
       
        if(is_numeric($categoryId)){
            $this->_categoryId= $categoryId;
        }
    }
    
    


    //Recuperation des données
    
    public function getId(){
       
        return $this->_id;
    }
    public function getTitle(){ 
       
        return $this->_title;
    }
    public function getContent(){
       
        return $this->_content;
    }

    public function getName(){
       
        return $this->_name;
    }

    public function getCategoryId(){
       
        return $this->_categoryId;
    }
    
    public function getCategory(){
       
        return $this->_categoryName;
    }

    public function SetCategory_name($categoryName){
        $this->_categoryName= $categoryName;
       
    }
    
}