<?php

class CategoryManager extends Model{


    //Select -> toutes les catégories
    public function getCategories(){
        $this->getDatabase();
        return $this->getAll('category', 'Category');
    }

    //Edit category -> retourne la category selon l'id
    public function getCategoryById($id){
        $this->getDatabase();
        return $this->getById('category', 'Category', $id);
    }

    //Mise a jour d'un article
    public function updateCategory($id, $name){

        $reqUpdate = $this->getDatabase()->prepare('UPDATE category SET category_name = :name WHERE id = :id');
        $reqUpdate->bindValue(':id', $id, PDO::PARAM_INT);
        $reqUpdate->bindValue(':name', $name, PDO::PARAM_STR);
        $reqUpdate->execute();
        
        return $reqUpdate;
    }

    //Suppression d'un article
    public function deleteCategory($id){

        $reqDelete = $this->getDatabase()->prepare('DELETE FROM category WHERE id = :id');
        $reqDelete->bindValue(':id', $id, PDO::PARAM_INT);
        $reqDelete->execute();

        return $reqDelete;
    }

    //Ajout d'un article
    public function insertCategory($name){

        $reqInsert = $this->getDatabase()
        ->prepare('
        INSERT INTO category
            (category_name)
        VALUES
            (:name)
        ');
        $reqInsert->bindValue(':name', $name, PDO::PARAM_STR);
        $reqInsert->execute();

        return $reqInsert;
    }
}