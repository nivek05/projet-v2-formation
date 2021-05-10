<?php
class View {
    private $_file;
    private $_t;

    public function __construct ($action){
        $this->_file = 'views/'.$action.'.phtml';
    }

    //Genere et affiche la vue
    public function generate ($data){
        //contenu specifique à la vue
        $content = $this->generateFile($this->_file, $data);
        //template
        $view = $this->generateFile('views/template.phtml', array('t' => $this->_t,'content'=> $content));

        echo $view;
    }
    //genere un fichier vue et renvoie le resultat 
    private function generateFile ($file, $data){
        //Si le fichier existe
       if(file_exists($file)){
            extract($data);
            //temporisation
            ob_start();
            require $file;
            return ob_get_clean();
       }
       else{
           throw new Exception("Fichier ".$file. " introuvable");
       }
    }
}