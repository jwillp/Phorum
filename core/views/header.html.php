<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo($pageTitle); ?> </title>

    <link href="css/styles.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
  </head>
  <body>
      
      
      <div id="wrapper">
      <div id="header">
          HEADER LOGO
          <nav>
          <?php if(isset($_SESSION['user_name'])){ ?>
          <ul class="nav nav-pills pull-right">
            <li><a href="home">Home</a></li>
            <li><a href="createThread">Creer un sujet</a></li>
            <li><a href="logout">Se Déconnecter</a></li>
          </ul>
          <?php }else{ ?>
            <ul class="nav nav-pills pull-right">
            <li><a href="home">Home</a></li>
            <li><a href="login">Se Connecter</a></li>
            <li><a href="register">S'inscrire</a></li>
          </ul>  
         <?php } ?>
          
              <?php print_r($_SESSION);  ?>
        </nav>
              
      </div>
      <div id="body-page">