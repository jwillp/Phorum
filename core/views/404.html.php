<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 not found</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    <style>
        body {
            background-image: url('img/background.jpg');
            font-family: 'Open Sans', sans-serif!important;
        }
        .loginBox{
            border-radius: 420px;
            background-color: rgba(255,255,255,1);
            
            width: 420px;
            height: 420px;
            padding: 20px;
            margin: auto;
            margin-top: 150px; 
        }
        
        /* Rounded Buttons */
        .btn-login .btn{
            width: 75px;
            height: 75px;
            border-radius: 75px;
        }
    </style>
    
    
    
  </head>
  <body>
    
      <div class="well loginBox text-center">
          <form action="login" method="post">
              <h1 class="text-danger">
                  <span style="font-size: 110px" class="glyphicon glyphicon-remove-circle"></span>
              </h1>
                <h2 class="text-primary">Erreur 404! Sorry Dude...</h2>
                <p>La page que vous avez demandé est introuvable sur ce serveur...</p>
                <p>Peut-être serait-il mieux de retourner à l'accueil?<p/>
                
                <div class="text-center">
                    <a class="btn btn-primary" href='home'>Retourner à l'accueil</a>
                </div>
                
            </form>
      </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>