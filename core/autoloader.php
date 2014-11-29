<?php
/**
 * Permet de charger automatiquement le fichier nécessaire
 * selon le nom d'une classe
 * @param type $className
 */
function autoload($className)
{   

    $directories = array( 
        'core/controller/',
        'core/model/',
        'core/views/'
    );
    
    foreach ($directories as $directory){
        $path = ROOT . '/' .$directory . $className . '.php';
        if (is_readable($path))
        {
            require_once($path);
            return;
        }
    }
    
    # Class not Found
    

}
spl_autoload_register('autoload');