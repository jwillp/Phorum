<?php include(VIEWS.'/header.html.php'); ?>



<div class="container">

<h1><?php echo($thread->getProperty('title')) ?></h1>


<?php foreach($posts as $post):?>
<hr>
    <div class="row">
        <div class="col-md-1">
            <a href="viewProfile?user=<?php echo($post['author']->getProperty('username')) ?>">
                <img src="<?php echo($post['author']->getProperty('gravatar')) ?>" alt="<?php echo($post['author']->getProperty('username')) ?>" class="img-thumbnail">
            </a>
        </div>
        <div class="col-md-11"><?php include(VIEWS.'/forum/postView.html.php'); ?></div>
     </div>
    
    
 <?php endforeach; ?>



<?php 
// VÉRIFICATION VERROU DU THREAD
$labels = $thread->getLabels();
foreach( $thread->getLabels() as $lbl){
  $labels[] = $lbl->getName();
}
$threadLocked = in_array('LOCKED', $labels);
?>
    

              
<!--- RÉPONSE -->
  <?php if($userConnected == true && $threadLocked == false): ?>
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
<?php endif; ?>
              
              
              
<!--- AMDIN PANEL --->         
<?php if(@in_array("Admin", $_SESSION['user_roles'])): ?>
      <?php if($threadLocked == true): ?>    
            <a href="unlockThread?threadId=<?php echo($thread->getProperty('uid')) ?>" class="btn btn-success"><span class="glyphicon glyphicon-lock"></span> Déverrouiller</a> 
      <?php else: ?>      
            <a href="lockThread?threadId=<?php echo($thread->getProperty('uid')) ?>" class="btn btn-danger"><span class="glyphicon glyphicon-lock"></span> Verrouiller</a> 
      <?php endif;?>
<?php endif;?>               



</div>


<?php include(VIEWS.'/footer.html.php') ?>