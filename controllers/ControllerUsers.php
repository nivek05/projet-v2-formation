<?php
require_once('models/View.php');

class ControllerUsers{
    private $_userManager;
    private $_view;

    public function __construct($url){
        
        if(isset($url) && count($url) == 1){
            $this->users();
        }
        elseif( isset($url) && count($url) > 1){

            //
            if(is_numeric($url[1]) || $url[1]=== 'add'){

                $this->userById($url[1]);
            }
            elseif($url[1] === "update"){
                
                $this->id = $_POST['id'];
                $this->name = $_POST['name'];
                $this->pwd = $this->passHash($_POST['pwd']);
               
                $this->update( $this->id,$this->name,$this->pwd);
            }
            elseif($url[1] === "delete"){
                
                $this->id = $_POST['id'];
                var_dump($this->id);
                $this->delete($this->id);
            }
            elseif($url[1] === "insert"){
                $this->name = $_POST['name'];
                $this->pwd = $this->passHash($_POST['pwd']);
                $this->add($this->name, $this->pwd);
            }
            else{
                throw new Exception ('Page non trouvé');
            }
        }
        else{
            
            throw new Exception ('Page non trouvé');
                        
        }
    }

    private function users(){
        $this->_userManager = new UserManager;
        $users = $this->_userManager->getUsers();
        $this->_view = new View('users');
        $this->_view->generate(array('users' => $users));
    }

    private function userById($id){
        if($id != 0){
            $this->_userManager = new UserManager;
            $user = $this->_userManager->getUserById($id);
            $this->_view = new View('editUser');
            $this->_view->generate(array('user' => $user));
        }
        else{
            //Sinon champs vide pour le formulaire
            $this->_view = new View('editUser');
            $this->_view->generate(array('user' => ""));
        }
       
    }

    private function update($id, $name, $pwd){
        $this->_userManager = new UserManager;
        $user = $this->_userManager->updateUser($id, $name, $pwd); 
        
        //On renvoi vers la liste des users
        header('Location:'.URL.'users');
        exit();
    }

    private function delete($id){
        $this->_userManager = new UserManager;
        $user = $this->_userManager->deleteUser($id);
        
        //On renvoi vers la liste des users
        header('Location:'.URL.'users');
        exit();
    }

    private function add($name, $pwd){

        $this->_userManager = new UserManager;
        $user = $this->_userManager->insertUser($name,$pwd);
        
        //On renvoi vers la liste des users
        header('Location:'.URL.'users');
        exit();
       
    }

    //
    private function passHash($pwd){
        //Hash du password 
        $pwdCrypt = password_hash($pwd, PASSWORD_DEFAULT);
        return $pwdCrypt;
    }
}