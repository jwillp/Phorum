<?php


/**
 * Classe permettant de charger une vue et de l'afficher
 *
 * @author Jean-William Perreault
 */
class ViewRenderer {
    //put your code here
    
    
    /**
     * Permet d'afficher une Vue
     * $viewFile chemin à partir d répertoire de base Views
     */
    public function render($viewFile, $data=array()){
        // On transforme les clés de data en variables qui seront
        // accessibles dans la vue
        extract($data); 
        
        // On tente d'inclure la vue
        $path = VIEWS."/".$viewFile;
        if(file_exists($path)){
            include($path);
        }else{
            die("Impossible de trouver la vue specifiee: ". $path);
        }

    }
    
    
}
