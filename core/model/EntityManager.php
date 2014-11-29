<?php

class EntityManager {


    private static $instance = NULL;

    /**
     * private constructor means there will only be one instance.
     */
    private function __constructor()
    {
    }

    /**
     *
     * Returns the DB instance or create the intitial connection
     *
     * @return object (PDO)
     *
     * @access public
     *
     */
    public static function getInstance()
    {

            if (!self::$instance) {
                self::$instance = new EntityManager();
            }
            return self::$instance;
    }

    /**
     * Like the constructor, we make __clone private
     * so nobody can clone the instance
     */
    private function __clone()
    {
    }


    /**
     * Retourne la liste des Threads en tant qu'objets
     * @return \Gallery
     */
    public static function getThreads(){
        $threads = array();
        $response = DatabaseManager::getInstance()->query("SELECT * FROM threads");
        while($data = $response->fetch()){
            $thread = new Thread();
            $thread->hydrate($data);

            # TODO get Posts


            $threads[] = $thread;
        }
        return $threads;
    }


    public static function getThread($id){
        $response = DatabaseManager::getInstance()->query("SELECT * FROM threads WHERE id=".$id);
        $thread = new Thread();
        while($data = $response->fetch()){
            $thread->hydrate($data);
            return $thread;       
        }
    }

    
    
    
    
    
    
    
    
    
    
    
    /**
     * Retourne la liste de tous les utilisateurs
     */
    public function getUsers(){
        
    }
    
    /**
     * Retourne un utilisateur selon son id
     */
    public function getUser($id){
        
    }
    

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    



}

?>