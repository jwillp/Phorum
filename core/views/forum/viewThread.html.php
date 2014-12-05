<?php include(VIEWS.'/header.html.php'); ?>





<h1><?php echo($thread->getProperty('title')) ?></h1>


<?php foreach($posts as $post){?>
<div class="panel panel-primary">
    
    
   
    
    <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          <?php echo($post['author']->getProperty('username')) ?></h3>
    </div>
    

  <div class="panel-body">
    <?php echo($post['info']->getProperty('text')) ?>
  </div>
    

  
  <?php if ($post === end($posts) && $userConnected == true){ ?>
        <div class="panel-footer">
            
            <form action="createPost" method="post">
                <div class="form-group">
                  <label class="control-label" for="postText">Réponse</label>         
                  <textarea style="height: 150px;" class="form-control" id="postText" placeholder="Entrez votre message" name="postText"></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-login-submit" value="Valider" />
                </div>
                <input type="hidden" name="threadId" value="<?php echo($thread->getProperty('uid')) ?>">
            </form>
            
        </div>
  <?php } ?>
  
  
</div>

<?php } ?>







<?php include(VIEWS.'/footer.html.php') ?>