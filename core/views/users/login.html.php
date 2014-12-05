<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo($pageTitle); ?></title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    
    <style>
        body {
            background-image: url('img/background.jpg');
            font-family: 'Open Sans', sans-serif!important;
        }
        .loginBox{
            border-radius: 450px;
            background-color: rgba(255,255,255,1);
            
            width: 475px;
            height: 475px;
            padding: 75px;
            margin: auto;
            margin-top: 150px; 
        }
        
        /* Rounded Buttons */
        .btn-login .btn{
            width: 90px;
            height: 90px;
            border-radius: 90px;  
        }
        
        
        .btn-register{
            padding-top: 35px;
            
        }
    </style>
    
    
    
  </head>
  <body>
    
      <div class="well loginBox">
          <form action="login" method="post">
                <h2 class="text-center">Connexion</h2>
                <?php if (isset($error)){ ?>
                    <div class="alert alert-danger text-center" role="alert">
                    <?php echo( @$error ); ?>
                    </div>
                <?php }?>
                
                <div class="form-group">
                    <label for="username-email">Nom d'utilisateur ou Courriel</label>
                    <input name="username-email" value='' id="username-email" placeholder="Nom d'utilisateur ou Courriel" type="text" class="form-control" />
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input name="password" id="password" value='' placeholder="Mot de passe" type="password" class="form-control" />
                </div>
                
                <div class="form-group text-center btn-login">
                    <a href="register" class="btn btn-success btn-register">S'inscrire</a>
                    <input type="submit" class="btn btn-primary btn-login-submit" value="Connexion" />
                </div>
            </form>
      </div>
   
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>