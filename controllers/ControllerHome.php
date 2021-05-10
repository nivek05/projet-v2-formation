<?php
require_once('models/View.php');

class ControllerHome {
    private $_articleManager;
    private $_view;


    public function __construct($url){
        
        if( isset($url) && count($url) > 1){

            throw new Exception ('Page non trouvé');
        }
        else{
            $this->home();
        }
    }
    
    private function home(){
      
        $home = "Home";
        $this->_view = new View('home');
        $this->_view->generate(array('home' => $home));
    }
}