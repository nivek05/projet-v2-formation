<?php

class ArticleManager extends Model{
    //Select tout les articles
    public function getArticles(){

        $this->getDatabase();
        //Argument 1 -> nom de la table Argument 2-> l'entité  
        return $this->getAll('article', 'Article'); 
    }

    //Select d'un article par son ID
    public function getArticleById($id){

        $this->getDatabase();
        return $this->getById('article', 'Article', $id);
    }

    //Selection des articles avec inner join category
    public function getArticleInnerJoinCategory(){
        $reqSelect = $this->getDatabase()->prepare('
        SELECT
            a.id, article_name, article_title, article_content, article_category, c.category_name
        FROM
            article a
        INNER JOIN
            category c ON a.article_category = c.id
        ');
        
        $reqSelect->execute();
        while ($data = $reqSelect->fetch(PDO::FETCH_ASSOC)) {
            $var[] = new Article($data);
        }
        return $var;
        $reqSelect->closeCursor();
         
    }



    //Mise a jour d'un article
    public function updateArticle($id, $name, $title, $content, $categoryId){

        $reqUpdate = $this->getDatabase()->prepare('UPDATE article SET article_name = :name , article_title = :title, article_content = :content, article_category = :category WHERE id = :id');
        $reqUpdate->bindValue(':id', $id, PDO::PARAM_INT);
        $reqUpdate->bindValue(':name', $name, PDO::PARAM_STR);
        $reqUpdate->bindValue(':title', $title, PDO::PARAM_STR);
        $reqUpdate->bindValue(':content', $content, PDO::PARAM_STR);
        $reqUpdate->bindValue(':category', $categoryId, PDO::PARAM_INT);

        $reqUpdate->execute();
        
        return $reqUpdate;
    }

    //Suppression d'un article
    public function deleteArticle($id){

        $reqDelete = $this->getDatabase()->prepare('DELETE FROM article WHERE id = :id');
        $reqDelete->bindValue(':id', $id, PDO::PARAM_INT);
        $reqDelete->execute();

        return $reqDelete;
    }

    //Ajout d'un article
    public function insertArticle($name, $title, $content, $categoryId){

        $reqInsert = $this->getDatabase()
        ->prepare('
        INSERT INTO article
            (article_name, article_title, article_content, article_category)
        VALUES
            (:name, :title, :content, :categoryId)
        ');
        $reqInsert->bindValue(':name', $name, PDO::PARAM_STR);
        $reqInsert->bindValue(':title', $title, PDO::PARAM_STR);
        $reqInsert->bindValue(':content', $content, PDO::PARAM_STR);
        $reqInsert->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $reqInsert->execute();

        return $reqInsert;
    }



    
}