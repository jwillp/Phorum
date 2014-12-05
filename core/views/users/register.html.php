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
            border-radius: 600px;
            background-color: rgba(255,255,255,1);
            
            width: 600px;
            height: 600px;
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
    </style>
    
    
    
  </head>
  <body>

      <div class="well loginBox">
          <form action="register" method="post">
                <h2 class="text-center">S'inscrire</h2>
               
                <?php if (isset($usernameError)){ ?>
                    <div class="alert alert-danger text-center" role="alert">
                    <?php echo($usernameError); ?>
                    </div>
                <?php }?>
                <div class="form-group">
                    <label for="username">Username</label>
                    <input  required name="username" value='' id="username-email" placeholder="Username" type="text" class="form-control" />
                </div>
                
                
                <?php if (isset($emailError)){ ?>
                    <div class="alert alert-danger text-center" role="alert" >
                    <?php echo($emailError); ?>
                    </div>
                <?php }?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input required name="email" value='' id="username-email" placeholder="Email" type="text" class="form-control" />
                </div>
                
                
                
                
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input required name="password" id="password" value='' placeholder="Password" type="password" class="form-control" />
                </div>
                
                <div class="form-group text-center btn-login">
                    <input type="submit" class="btn btn-success btn-login-submit" value="Valider" />
                </div>
                
            </form>
      </div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>


    
  </body>
</html>