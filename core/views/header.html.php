<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <title> <?php echo($pageTitle); ?> </title>

    
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <link href="css/styles.css" rel="stylesheet">
    
  </head>
  <body>
      
      <nav class="navbar " role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="home">
              <img alt="Brand" class="img-responsive" height="150px" src="img/logo.png">
          </a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">


              <?php if(isset($_SESSION['user_name'])){ ?>
                <ul class="nav nav-pills pull-right">
                    <li>Bonjour, <?php echo $_SESSION['user_name'] ?></li>
                    <li><a href="createThread"  class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Creer un sujet</a></li>
                    <li><a href="logout" class="btn btn-primary"><span class="glyphicon glyphicon-log-out"></span>  Se Déconnecter</a></li>
                </ul>
                <?php }else{ ?>
                  <ul class="nav nav-pills pull-right">
                    <li><a href="register" class="btn btn-success">S'inscrire</a></li>
                    <li><a href="login" class="btn btn-primary"><span class="glyphicon glyphicon-log-in"></span>  Se Connecter</a></li>
                  </ul>  
               <?php } ?>

        </div><!--/.navbar-collapse -->
      </div>
    </nav>
     
    <?php if(isset($_SESSION['message'])): ?>
        <div id="messages" class="alert alert-success"><?php echo $_SESSION['message']?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    