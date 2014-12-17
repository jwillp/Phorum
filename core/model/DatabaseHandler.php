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

    private static function logQuery($query, $parameters){
        
        foreach($parameters as $cle => $valeur){   
            $query = str_replace("{". $cle . "}", $valeur, $query);
        }

        
        
        
        $myfile = fopen("cypher.cql", "a");
        fwrite($myfile, $query);
        fclose($myfile);
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
    public static function createUser($userName, $password, $email, $gravatar){
        
       $client = DatabaseHandler::getInstance();
       $queryString = "CREATE (n:User {username: {username}, 
           password: {pass}, 
           email: {email} ,
           gravatar: {gravatar},
           regDate: {date}
           })
           RETURN n;";
       
       $param = array(
           'username' => $userName,
           'pass' => $password,
           'email' => $email,
           'gravatar' => $gravatar,
           'date' => date("Y-m-d H:i:s"),
        );
       $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
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
     * Retourne la totalité des Threads
     */
    public static function getThreads(){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH (n:Thread)
                        RETURN n";
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString);
        
        $threads = array();
        $result = $query->getResultSet();
        foreach ($result as $row) {
           $threads[] = $row['Thread'];
        }  
        return $threads;
    }
    
    /**
     * Retourne un thread selon son Id
     * Attention ne retourne pas les threads du post!
     * @param type $threadId le Id du thread voulu
     */
    public static function getThread($threadId){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH (n:Thread)
                        WHERE n.uid = {uid}
                        RETURN n";
        $param = array(
            'uid' => $threadId,
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
        foreach ($result as $row) {
           return $row['n'];
        }  
    }
    
    
    
    /**
     * Retournel les post dans l'ordre d'un Thread
     * Avec son auteur array('info', 'author')
     * @param type $threadUid
     * @return type
     */
    public static function getPosts($threadUid){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH (t:Thread)-[:PRECEDES*]->(b:Post),  (b:Post)-[:WRITTEN_BY]->(u:User)
                        WHERE t.uid = {uid}
                        return distinct b, u;";
        
        $param = array(
            'uid' => $threadUid,
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
        $posts = array();
        foreach ($result as $row) {
            $post = array(
                'info' => $row['b'],
                'author' => $row['u'],
            );
           $posts[] = $post;
        }  
        return $posts;
    }
    
    
    /**
     * Retourne un Post individuel
     * @param type $postId
     * @return type
     */
    public static function getPost($postId){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH (n:Post)-[:WRITTEN_BY]-(u:User)
                        WHERE n.uid = {uid}
                        RETURN n, u";
        $param = array(
            'uid' => $postId,
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
        foreach ($result as $row) {
            $post = array();
            $post['info'] = $row['n'];
            $post['author'] = $row['u'];
            
           return $post;
        } 
    }
    
    
    public static function getPostsByUser($username){
        $client = DatabaseHandler::getInstance();
        $queryString = "MATCH (p:Post)-[:WRITTEN_BY]->(user), (p:Post)-[:PRECEDES*]->(t:Thread)
                        WHERE user.username = {username}
                        return distinct p, t, user;";
        
        $param = array(
            'username' => $username,
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
        $posts = array();
        foreach ($result as $row) {
            $post = array(
                'info' => $row['p'],
                'thread' => $row['t'],
                'author' => $row['user'],
            );
           $posts[] = $post;
        }  
        return $posts;
    }

    
    /**
     * Ajoute un Thread à la base de données avec un titre
     * @param type $title
     * @return type
     */
    public static function createThread($title){
        $client = DatabaseHandler::getInstance();
        $queryString = "CREATE (n:Thread { uid: {uid}, title: {title}, date: {date} })-[:PRECEDES]->(n)
                        RETURN n";
        
        
        $param = array(
            'title' => $title,
            'uid' => uniqid(),
            'date' => date("Y-m-d H:i:s"),
        );
          
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);

        DatabaseHandler::logQuery($query->getQuery(), $param);
        
        
        $result = $query->getResultSet();
        foreach ($result as $row) {
           return $row['Thread']->getProperty('uid');
        }  
    }

    /**
     * @param type $text
     * @param type $threadId
     */
    public static function createPost($text, $author, $threadId){
        $client = DatabaseHandler::getInstance();
        $queryString = "
            MATCH (before)-[r:PRECEDES]->(root), (user)
            WHERE root.uid = {threadId} AND user.username = {author}
            CREATE UNIQUE (before)-[:PRECEDES]->(p:Post{ uid: {uid}, text: {text}, date: {date} })-[:PRECEDES]->(root)
            CREATE UNIQUE (p)-[:WRITTEN_BY]->(user)
            DELETE r
            RETURN p
        ";
        $param = array(
            'uid' => uniqid(),
            'threadId' => $threadId,
            'author' => $author,
            'text' => $text,
            'date' => date("Y-m-d H:i:s"),
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        
        DatabaseHandler::logQuery($query->getQuery(), $param);
        
        
        $result = $query->getResultSet();
    }
    
    /**
     * Permet de flagger un post comme "Supprimé"
     * @param type $postId
     */
    public static function deletePost($postId){
        $client = DatabaseHandler::getInstance();
        $queryString = "
            MATCH (n:Post)
            WHERE n.uid = {postId}
            SET n:DELETED
            RETURN n;";
        $param = array(
            'postId' => $postId,
        );
        
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        DatabaseHandler::logQuery($query->getQuery(), $param);
        $result = $query->getResultSet();
    }
    
    
    
    
    
    public static function lockThread($threadId){
        $client = DatabaseHandler::getInstance();
        $queryString = "
            MATCH (n:Thread)
            WHERE n.uid = {threadId}
            SET n:LOCKED
            RETURN n;";
        $param = array(
            'threadId' => $threadId,
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
    }
    
    
    public static function unlockThread($threadId){
        $client = DatabaseHandler::getInstance();
        $queryString = "
            MATCH (n:Thread)
            WHERE n.uid = {threadId}
            REMOVE n:LOCKED
            RETURN n
        ";
        $param = array(
            'threadId' => $threadId,
        );
        $query = new Everyman\Neo4j\Cypher\Query($client, $queryString, $param);
        $result = $query->getResultSet();
    }
    
    
    
    
    
    
    
    
}









