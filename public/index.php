<?php
# Nous permet d'obtenir le parent du parent de index donc
# la racine du projet
define("ROOT", dirname(dirname(__FILE__))); 
define("VIEWS", ROOT.'/core/views');

session_start();
require_once(ROOT."/core/autoloader.php");
require_once(ROOT."/core/config.php");


$controller = new Controller();


$url = isset($_GET['url']) ? $_GET['url'] : 'default';
$controller->receiveURL($url);

    
