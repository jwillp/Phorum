<?php
/**
 * Description of Controller
 *
 * @author Jean-William Perreault
 */

require_once(ROOT."/core/autoloader.php");

class Controller {
    //put your code here
    
    /**
     * Reçoit une url entrée par l'utilisateur
     * et exécute la méthode du controller correspondante
     */
    public function receiveURL($url, $data=null){
        $action = $url.'Action';
        if($action == 'Action'){
            $action = 'homeAction';
        }
     
        if (method_exists($this, $action)){
             call_user_func(array($this, $action), $data);
        }else{
            $this->NotFoundAction();
        }
    }
    
    
    public function redirectTo($url){
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

        $vr = new ViewRenderer();
        $vr->render('home.html.php');
   
    }
    
    /**
     * Page de connexion
     */
    private function loginAction(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            

            
            if(filter_input(INPUT_POST, 'username-email', FILTER_VALIDATE_EMAIL) != null){
                $user = DatabaseHandler::getUserByEmail($_POST['username-email']);
            }else{
                $user = DatabaseHandler::getUserByName($_POST['username-email']);
            }

           $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            if($user !== null && $password == $user->getProperty("password")){
                $this->redirectTo("home");
            }
            
            
            $vr = new ViewRenderer();
            $param = array(
                'error' => "Mauvais mot de passe ou nom d'utilisateur"
            );
            return $vr->render("login.html.php", $param);
        }
        
        
        

        $vr = new ViewRenderer();
        return $vr->render("login.html.php", array());
        

    }
    
    
    
    
    /**
     * Page d'inscription
     */
    private function registerAction(){
        
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
   
    
    
    
    
    
    
    
    
    
    
    
    
}
