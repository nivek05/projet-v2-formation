<?php

class UserManager extends Model{

    public function getUsers(){
        $this->getDatabase();
        //Argument 1 -> nom de la table Argument 2-> l'entité  
        return $this->getAll('user', 'User');
    }

    //Edit user -> retourne la user selon l'id
    public function getUserById($id){
        $this->getDatabase();
        return $this->getById('user', 'User', $id);
    }

    //Mise a jour d'un user
    public function updateUser($id, $name, $pwd){

        $reqUpdate = $this->getDatabase()->prepare('UPDATE user SET user_name = :name, user_pwd= :pwd WHERE id = :id');
        $reqUpdate->bindValue(':id', $id, PDO::PARAM_INT);
        $reqUpdate->bindValue(':name', $name, PDO::PARAM_STR);
        $reqUpdate->bindValue(':pwd', $pwd, PDO::PARAM_STR);
        $reqUpdate->execute();
        
        return $reqUpdate;
    }

    //Suppression d'un user
    public function deleteUser($id){

        $reqDelete = $this->getDatabase()->prepare('DELETE FROM user WHERE id = :id');
        $reqDelete->bindValue(':id', $id, PDO::PARAM_INT);
        $reqDelete->execute();

        return $reqDelete;
    }

    //Ajout d'un user
    public function insertUser($name, $pwd){

        $reqInsert = $this->getDatabase()
        ->prepare('
        INSERT INTO user
            (user_name, user_pwd)
         
        VALUES
            (:name, :pwd )
           
        ');
        $reqInsert->bindValue(':name', $name, PDO::PARAM_STR);
        $reqInsert->bindValue(':pwd', $pwd, PDO::PARAM_STR);
        $reqInsert->execute();

        return $reqInsert;
    }
}