
<?php
require_once('models/View.php');

class ControllerCategories{
    private $_categoryManager;
    private $_view;
    
    public function __construct($url, $name=null){
    
        if(isset($url) && count($url) == 1){
            $this->categories();
        }
        elseif( isset($url) && count($url) > 1){

            //
            if(is_numeric($url[1]) || $url[1]=== 'add'){

                $this->categoryById($url[1]);
            }
            elseif($url[1] === "update"){
                
                $this->id = $_POST['id'];
                $this->name = $_POST['name'];
               
                $this->update( $this->id,$this->name);
            }
            elseif($url[1] === "delete"){
                
                $this->id = $_POST['id'];
                var_dump($this->id);
                $this->delete($this->id);
            }
            elseif($url[1] === "insert"){
                $this->name = $_POST['name'];
                $this->add($this->name);
            }
            else{
                throw new Exception ('Page non trouvé');
            }
        }
        else{
            
            throw new Exception ('Page non trouvé');
                        
        }
    }

    private function categories(){
        $this->_categoryManager = new CategoryManager;
        $categories = $this->_categoryManager->getCategories();
        //require_once('views/home.php');

        $this->_view = new View('categories');
        $this->_view->generate(array('categories' => $categories));
    }

    private function categoryById($id){
        if($id != 0){
            $this->_categoryManager = new CategoryManager;
            $category = $this->_categoryManager->getCategoryById($id);
            $this->_view = new View('editCategory');
            $this->_view->generate(array('category' => $category));
        }
        else{
            $this->_view = new View('editCategory');
            $this->_view->generate(array('category' => ""));
        }
       
    }

    private function update($id, $name){
        $this->_categoryManager = new CategoryManager;
        $category = $this->_categoryManager->updateCategory($id, $name); 
        
        //On renvoi vers la liste des categories
        header('Location:'.URL.'categories');
        exit();
    }

    private function delete($id){
        $this->_categoryManager = new CategoryManager;
        $category = $this->_categoryManager->deleteCategory($id);
        
        //On renvoi vers la liste des categories
        header('Location:'.URL.'categories');
        exit();
    }

    private function add($name){
        $this->_categoryManager = new CategoryManager;
        $category = $this->_categoryManager->insertCategory($name);
        
        //On renvoi vers la liste des categories
        header('Location:'.URL.'categories');
        exit();
       
    }
}