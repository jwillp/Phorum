<?php
/**
 * Description of Controller
 *
 * @author Jean-William Perreault
 */

require_once(ROOT."/core/autoloader.php");
@session_start();

class Controller {
    //put your code here
    
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
          'pageTitle' => 'Phorum - Home',
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

            if($user !== null && $password == $user->getProperty("password")){
                $username = $user->getProperty('username');
                $_SESSION['user_name'] = $username;
                $_SESSION['user_pass'] = $user->getProperty('password');
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
                
                DatabaseHandler::createUser($username, $password, $email);
                
                # Connect the user
                $_SESSION['user_name'] = $username;
                $_SESSION['user_pass'] = $password;
                $this->redirectTo("home");
                
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
            'pageTitle' => $thread->getProperty('title'). "- Phorum",
            'thread' => $thread,
            'posts' => $posts,
            'userConnected' => $this->isUserAuth(),
        );
        
        
        $vr = new ViewRenderer();
        $vr->render('forum/viewThread.html.php', $param);

        
        
        

    }
    
    
    private function createPostAction(){
        if($this->isUserAuth() == False){
           $this->redirectTo("login");
       }
       
        $threadId = filter_input(INPUT_POST, 'threadId', FILTER_SANITIZE_STRING);  
        $postText = filter_input(INPUT_POST, 'postText', FILTER_SANITIZE_STRING); 
        $user = $_SESSION['user_name'];
        DatabaseHandler::createPost($postText, $user, $threadId);
        // TODO Redirect page to thread

        $this->redirectTo("viewThread", array('threadId='.$threadId));
  
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

    
    /**
     * Permet de savoir si l'utilisateur actif est authentifié
     */
    private function isUserAuth(){
        return isset($_SESSION['user_name']);
    }
    
    
    
    
}
