<?php
require_once ('models/View.php');
class Router{

    private $_ctrl;
    private $_view;

    public function routeReq(){
        try{
            //Chargement des classes
            spl_autoload_register(function($class){
                require_once('models/'.$class.'.php');
            });

            $url = [];
            //On test selon l'action de l'utilisateur
            if(isset($_GET['url'])){

                $url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
                
                $controller = ucfirst(strtolower($url[0]));
                $controllerClass = "Controller".$controller;
                $controllerFile = "controllers/".$controllerClass.".php";

                if(file_exists($controllerFile)){
                    require_once($controllerFile);
                    $this->_ctrl = new $controllerClass($url);
                }else{
                    throw new Exception('Page non trouvé');
                }
            }
            else{
                //Sinon require la home 
                require_once('controllers/ControllerHome.php');
                $this->_ctrl = new ControllerHome($url);
                
            }
            // Gestion des errreurs
        }catch(Exception $e){
            $errorMsg = $e->getMessage();
            $this->_view = new View('errors');
            $this->_view->generate(array('errorMsg' => $errorMsg ));
        }
    }
}
?>