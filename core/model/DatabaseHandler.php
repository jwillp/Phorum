<?php
/*********************************************************************************
 * Database Class
 *
 * Classe dresponsable de traduire les communication de l'application avec
 * la base de donnée Neo4j
 *********************************************************************************/

/** POUR CHARGER L'AUTOLOAD DE Neo4jPHP **/

require(ROOT."/vendor/autoload.php");
class DatabaseHandler
{


    private static $instance = NULL;

    /**
     * Cosntructeur privée (aucune instanciation publique)
     */
    private function __constructor()
    {
    }

    /**
     * Retourne l'instance de la base de donnée,
     * si elle nexiste pas déjà elle est instanciée 
     * puis retournée
     * @return object (PDO)
     * @access public
     */
    private static function getInstance()
    {
        $client = new Everyman\Neo4j\Client(DB_HOST, 7474);
        return $client;
    }

    /**
     * On évite que la BD soit clonée
     */
    private function __clone()
    {
    }

    
    /**
     * Créé un utilisateur
     * @param type $userName
     * @param type $password
     * @param type $email
     * @return type
     */
    public static function createUser($userName, $password, $email){
       $queryString = "CREATE (n:User {username: {username}, 
           password: {pass}, 
           email: {email} });";
       
       $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, array('title' => $title));
       $result = $query->getResultSet();
       foreach ($result as $row) {
           return $row['User']->getId();
       } 
    }
    
    /**
     * Trouve un utilisateur selon son nom d'utilisateur
     * @param type $username
     */
    public static function getUserByName($username){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH(u)
        WHERE u.username={username}
        RETURN u;";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, array('username' => $username));
        $result = $query->getResultSet();
        foreach ($result as $row) {
           return $row['User'];
        } 
    }
    
    /**
     * Trouve un utilisateur selon son adresse courriel
     * @param type $email
     * @return type Neoj4php Row
     */
    public static function getUserByEmail($email){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH(u)
        WHERE u.email={email}
        RETURN u;";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, array('email' => $email));
        $result = $query->getResultSet();
        foreach ($result as $row) {
           return $row['User'];
        } 
    }
    
    
    
    

    
    
    /**
     * Ajoute un Thread à la base de données avec un titre
     * @param type $title
     * @return type
     */
    public static function createThread($title){
        $client = DatabaseHandler::getInstance();
        $queryString = "CREATE (n:Thread {title: {title} }) RETURN n";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, array('title' => $title));
        $result = $query->getResultSet();
        foreach ($result as $row) {
           return $row['Thread']->getId();
        }  
    }
    
    public static function createFirstPost($text, $author, $threadId){
        "
        MATCH (node), (user:User)
        WHERE ID(node) = 23 AND ID(user) = 23
        CREATE (post:Post { text:'Sleepless IN Seattle' })
        CREATE (post)-[:FOLLOWS]->(node)
        CREATE (post)-[:WRITTEN_BY]->user;
        ";
    }


    
    
    /**
     * 
     * @param type $text
     * @param type $threadId
     */
    public static function createPost($text, $author, $threadId){
        $client = DatabaseHandler::getInstance();
        $queryString = "
            MATCH (node)
            WHERE node.id = {nodeId}
            CREATE (post:Post { text: {text} })
            CREATE (post)-[:FOLLOWS]->(node);
        ";
        $param = array(
            'title' => $title, 
            'nodeId' => $threadId
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
    }
    
    
    
    
    
    
}









