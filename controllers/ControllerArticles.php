<?php
require_once('models/View.php');

class ControllerArticles{
    private $_articleManager;
    private $_view;
    
    public function __construct($url, $name=null, $title=null, $content=null, $categoryId=null){
    
        if(isset($url) && count($url) == 1){
            $this->articles();
        }
        elseif( isset($url) && count($url) > 1){

            //
            if(is_numeric($url[1]) || $url[1]=== 'add'){

                $this->articleById($url[1]);
            }
            elseif($url[1] === "update"){
                
                $this->id = $_POST['id'];
                $this->name = $_POST['name'];
                $this->title = $_POST['title'];
                $this->content = $_POST['content'];
                $this->categoryId = $_POST['categoryId'];
                $this->update( $this->id,$this->name, $this->title, $this->content, $this->categoryId);
            }
            elseif($url[1] === "delete"){
                
                $this->id = $_POST['id'];
                $this->delete($this->id);
            }
            elseif($url[1] === "insert"){
                $this->name = $_POST['name'];
                $this->title = $_POST['title'];
                $this->content = $_POST['content'];
                $this->categoryId = $_POST['categoryId'];
                $this->add($this->name, $this->title, $this->content, $this->categoryId);
            }
            else{
                throw new Exception ('Page non trouvé');
            }
        }
        else{
            
            throw new Exception ('Page non trouvé');
                        
        }
    }

    private function articles(){
        $this->_articleManager = new ArticleManager;
        $articles = $this->_articleManager->getArticleInnerJoinCategory(); 
        $this->_view = new View('articles');
        $this->_view->generate(array('articles' => $articles));
    }

    private function articleById($id){
        //On récupère la liste des catégories
        $this->_articleManager = new CategoryManager;
        $categories = $this->_articleManager->getCategories($id);
        

        //si id different de 0
        if($id != 0){
            $this->_articleManager = new ArticleManager;
            $article = $this->_articleManager->getArticleById($id);
            $this->_view = new View('editArticle');
            $this->_view->generate(array(
                'article' => $article,
                'categories' => $categories
            ));
        }
        else{
           
            $this->_view = new View('editArticle');
            $this->_view->generate(array(
                'article' => "",
                'categories' => $categories
            ));
        }
       
    }

    private function update($id, $name, $title, $content, $categoryId){
        $this->_articleManager = new ArticleManager;
        $article = $this->_articleManager->updateArticle($id, $name, $title, $content, $categoryId); 
        
        //On renvoi vers la liste des articles
        header('Location:'.URL.'articles');
        exit();
    }

    private function delete($id){
        $this->_articleManager = new ArticleManager;
        $article = $this->_articleManager->deleteArticle($id);
        
        //On renvoi vers la liste des articles
        header('Location:'.URL.'articles');
        exit();
    }

    private function add($name, $title, $content, $categoryId){
        $this->_articleManager = new ArticleManager;
        $article = $this->_articleManager->insertArticle($name, $title, $content, $categoryId);
        
        //On renvoi vers la liste des articles
        header('Location:'.URL.'articles');
        exit();
       
    }
}