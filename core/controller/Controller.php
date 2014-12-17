<?php
/**
 * Description of Controller
 *
 * @author Jean-William Perreault
 */

require_once(ROOT."/core/autoloader.php");
@session_start();


class Controller {
    
    
    /**
     * Reçoit une url entrée par l'utilisateur
     * et exécute la méthode du controller correspondante
     */
    public function receiveURL($url){
        $action = $url.'Action';
        if($action == 'Action'){
            $action = 'homeAction';
        }
     
        if (method_exists($this, $action)){
             call_user_func(array($this, $action));
        }else{
            $this->NotFoundAction();
        }
    }
    
    
    public function redirectTo($url, $param=array()){
        if (!empty($param))
            $url = $url."?".implode ("&", $param);

        // TODO GET PARAMETERS
        header("Location:".$url);
        exit();
    }
    
    
    
    /**
     * Appelé par l'URL par défaut soit le nom du site uniqement.
     */
    private function defaultAction(){
        $this->homeAction();
    }
   
    private function homeAction(){

        $threadsData = DatabaseHandler::getThreads();
        $threads = array();
        
        
        foreach($threadsData as $thread){
            $posts = DatabaseHandler::getPosts($thread->getProperty('uid'));
            $threads[] = array(
                'info' => $thread, 
                'posts'  => $posts
            );
        }

        $param = array(
          'pageTitle' => 'Home - '.SITE_NAME,
          'threads' => $threads,
        );
        
        
        $vr = new ViewRenderer();
        $vr->render('home.html.php', $param);
   
    }
    
    /**
     * Page de connexion
     */
    private function loginAction(){

        if($this->isUserAuth()){
           $this->redirectTo("home");
        }
        
        $param = array(
           'pageTitle' => "Inscription"
        );
        
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            if(filter_input(INPUT_POST, 'username-email', FILTER_VALIDATE_EMAIL) != null){
                $user = DatabaseHandler::getUserByEmail($_POST['username-email']);
            }else{
                $user = DatabaseHandler::getUserByName($_POST['username-email']);
            }

           $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
           $password = $this->hashPassword($password);
            
           
           
           
            if($user !== null && $password == $user->getProperty("password")){
                $labels = array();
                foreach ($user->getLabels() as $lbl){
                    $labels[] = $lbl->getName();
                }


                $username = $user->getProperty('username');
                $_SESSION['user_name'] = $username;
                $_SESSION['user_pass'] = $user->getProperty('password');
                $_SESSION['user_roles'] = $labels;
                $this->promptMessage("Connexion effectuée avec succès!");
                $this->redirectTo("home");
            }
            $param['error'] = "Mauvais mot de passe ou nom d'utilisateur";
        }

        $vr = new ViewRenderer();
        return $vr->render("users/login.html.php", $param);
    }

    /**
    * Page d'inscription
    */
    private function registerAction(){
        
        if($this->isUserAuth()){
           $this->redirectTo("home");
        }
        
        $param = array(
           'pageTitle' => "Inscription"
        );
        
        
         if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);        
            $canCreateUser = true;
            
            if($email == null){
                $param['emailError'] = "L'adresse courriel est invalide";
                $canCreateUser = false;
            }
            if(DatabaseHandler::getUserByEmail($email) !== null){
                $param['emailError'] = "L'adresse courriel est déjà utilisée";
                $canCreateUser = false;
            }
            if(DatabaseHandler::getUserByName($username) !== null){
                $param['usernameError'] = "Le nom d'utilisateur est déjà utilisé";
                $canCreateUser = false;
            }
            
            if($canCreateUser == true){
                

                // Génération d'un Gravatar
               $gravatar = $this->get_gravatar($email);
   
                $password = $this->hashPassword($password);
                DatabaseHandler::createUser($username, $password, $email, $gravatar);
                
                $this->redirectTo("login");
            }   
        }
        
        $vr = new ViewRenderer();
        return $vr->render("users/register.html.php", $param);
    }
    
    /**
     * Permet à un utilisateur AUTHENTIFIÉ de se déconnecter
     */
    private function logoutAction(){
        if($this->isUserAuth()){
            session_unset();
        }
        $this->promptMessage("Déconnexion effectuée avec succès!");
        $this->redirectTo("home");
    }
    
    /**
     * Permet à un utilisateur AUTHENTIFIÉ de créer un nouveau
     * Sujet
     */
    private function createThreadAction(){
       if($this->isUserAuth() == False){
           $this->redirectTo("login");
       }
               
       $param = array(
           'pageTitle' => "Création d'un nouveau Sujet"
       );
       
       
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
           
           $threadTitle = filter_input(INPUT_POST, 'threadTitle', FILTER_SANITIZE_STRING); 
           $postText = filter_input(INPUT_POST, 'postText', FILTER_SANITIZE_STRING); 
           $user = $_SESSION['user_name'];
           
           $threadId = DatabaseHandler::createThread($threadTitle);
           DatabaseHandler::createPost($postText, $user, $threadId);
           $this->promptMessage("Création du Thread effectuée avec succès");
           $this->redirectTo("viewThread", array('threadId='.$threadId));
       }
       
       $vr = new ViewRenderer();
       return $vr->render("forum/createThread.html.php", $param);
       
    }
    
    
    /**
     * Permet de voir un thread
     */
    private function viewThreadAction(){
       
        if(!isset($_GET['threadId'])){
           $this->redirectTo('home'); 
        }
        

        $threadId = $_GET['threadId'];
        $thread = DatabaseHandler::getThread($threadId);
        
        if($thread == null){ 
            $this->redirectTo('home');
        }
        
        
        $posts = DatabaseHandler::getPosts($threadId);
        
        
        $param = array(
            'pageTitle' => $thread->getProperty('title'). " - " . SITE_NAME,
            'thread' => $thread,
            'posts' => $posts,
            'userConnected' => $this->isUserAuth(),
        );
        
        
        $vr = new ViewRenderer();
        $vr->render('forum/viewThread.html.php', $param);
    }
    
    /**
     * Permet de créer un nouveau Post(Message)
     */
    private function createPostAction(){
        if($this->isUserAuth() == False){
           $this->redirectTo("login");
       }
       
        $threadId = filter_input(INPUT_POST, 'threadId', FILTER_SANITIZE_STRING);  
        $postText = filter_input(INPUT_POST, 'postText', FILTER_SANITIZE_STRING); 
        $user = $_SESSION['user_name'];
        DatabaseHandler::createPost($postText, $user, $threadId);
        $this->promptMessage("Création du Post effectuée avec succès");
        $this->redirectTo("viewThread", array('threadId='.$threadId));
  
    }
    
    /**
    * Permet de Verouiller un thread
    */
    private function lockThreadAction(){
        if(!isset($_GET['threadId']) || $this->isUserAuth() == false || $this->isUserAdmin() == false)
           $this->redirectTo('home'); 
        $threadId = $_GET['threadId'];
        DatabaseHandler::lockThread($threadId);
        $this->promptMessage("Verrouillage du Thread effectué avec succès");
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }
    
   /**
    * Permet de Déverouiller un thread
    */
    private function unlockThreadAction(){
        
        if(!isset($_SESSION['user_roles'])){
            $this->redirectTo('home'); 
        }
        
        
        if(!isset($_GET['threadId']) || $this->isUserAuth() == false || $this->isUserAdmin() == false)
           $this->redirectTo('home'); 
   
        $threadId = $_GET['threadId'];
        
        DatabaseHandler::unlockThread($threadId);
        $this->promptMessage("Déverrouillage du Thread effectué avec succès");
        $this->redirectTo($_SERVER['HTTP_REFERER']);
    }

    
    /**
     * Permet de d'obtenir le profil d'un membre du forum
     */
    private function viewProfileAction(){
        if(!isset($_GET['user'])){
            $this->NotFoundAction();
        }
        
        $user = DatabaseHandler::getUserByName($_GET['user']);

        if($user === null){
            $this->NotFoundAction();
        }
        
        $posts = DatabaseHandler::getPostsByUser($user->getProperty('username'));

        $param = array(
            'pageTitle' => $user->getProperty('username'). " - ". SITE_NAME,
            'user' => $user,
            'posts' => $posts,
            'userConnected' => false,
        );
        $vr = new ViewRenderer();
        $vr->render('forum/viewProfile.html.php', $param);
    }
    
    
    
    
    
    private function learnMoreAction(){
        $param = array(
            'pageTitle' => "Apprenez en plus à propos de " . SITE_NAME,
        );
        $vr = new ViewRenderer();
        $vr->render('learnMore.html.php', $param);
    }
    
    
    private function deletePostAction(){
         

        if(!isset($_GET['postId']) || $this->isUserAuth() == false){
           $this->promptMessage("PAS DE POST");
           $this->redirectTo('home'); 
        }
            
        if(!isset($_SESSION['user_roles'])){
            $this->redirectTo('home'); 
        }
        
        $postId = $_GET['postId'];
        $post = DatabaseHandler::getPost($postId);
        
        if($post['author']->getProperty('username') != $_SESSION['user_name'] 
                && $this->isUserAdmin() == false){

            $this->redirectTo('home'); 
        }
        
        
        DatabaseHandler::deletePost($postId);
       $this->promptMessage("Suppression du poste effectuée avec succès");
       $this->redirectTo($_SERVER['HTTP_REFERER']);
    }
    
    
    
    
    /**
     * Méthode lancée lorsque la page n'est pas trouvée.
     */
    private function NotFoundAction(){
       header("HTTP/1.0 404 Not Found - Page Not Found");
       $vr = new ViewRenderer();
       $vr->render('404.html.php');
       exit();
    }

    
    
    /***** HELPERS ******/
    
    
    
    
    
    /**
     * Permet de savoir si l'utilisateur actif est authentifié
     */
    private function isUserAuth(){
        return isset($_SESSION['user_name']);
    }
    
    private function isUserAdmin(){
        return in_array("Admin", $_SESSION['user_roles']);
    }
    
    
    
    
    /**
    * Get either a Gravatar URL or complete image tag for a specified email address.
    * GRACIEUSETÉ DE : http://en.gravatar.com/site/implement/images/php/ 
    * @param string $email The email address
    * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
    * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
    * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
    * @param boole $img True to return a complete IMG tag False for just the URL
    * @param array $atts Optional, additional key/value attributes to include in the IMG tag
    * @return String containing either just a URL or a complete image tag
    * @source http://gravatar.com/site/implement/images/php/
    */
   private function get_gravatar( $email, $s = 80, $d = 'identicon', $r = 'x', $img = false, $atts = array() ) {
       $url = 'http://www.gravatar.com/avatar/';
       $url .= md5( strtolower( trim( $email ) ) );
       $url .= "?s=$s&d=$d&r=$r";
       if ( $img ) {
           $url = '<img src="' . $url . '"';
           foreach ($atts as $key => $val) {
                $url .= ' ' . $key . '="' . $val . '"';
            }
            $url .= ' />';
       }
       return $url;
   }
    
    
   private function promptMessage($message){
        $_SESSION['message'] = $message;
   }
   
   
   
   // Hash le mot de passe et retourne sa version hashée
   private function hashPassword($password){
       $salt = "dK$^d#K";
       $hash = sha1($salt . $password);
       return $hash;
   }
    
    
    
    
    
    
}
