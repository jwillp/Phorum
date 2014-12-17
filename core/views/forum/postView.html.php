<div class="panel panel-primary post">
    <!-- REGARDER SI LE POST EST FLAGGÉ SUPPRIMÉ -->
    <?php 
        $labels = array();
        foreach( $post['info']->getLabels() as $lbl){
          $labels[] = $lbl->getName();
        }
        $postDeleted = in_array('DELETED', $labels);
    ?>

    
    <div class="panel-heading">
          <h3 class="panel-title"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
          <?php echo($post['author']->getProperty('username')) ?> - <?php echo($post['info']->getProperty('date')) ?></h3>
        
        
        
        <?php if($postDeleted == false): ?>
            <?php if($post['author']->getProperty('username') == $_SESSION['user_name'] 
                    || in_array("Admin", $_SESSION['user_roles']) == true):
             ?>
            <div class="">
                <a href="deletePost?postId=<?php echo($post['info']->getProperty('uid')); ?>" class="btn btn-danger">
                    <span class="glyphicon glyphicon-trash"></span>Supprimer
                </a>
            </div>
            <?php endif; ?>
        <?php endif; ?>
        
        
        
    </div>
    

  <div class="panel-body">
      <?php if($postDeleted == false): ?>
        <?php echo($post['info']->getProperty('text')) ?>
      <?php else: ?>
           <p class="bg-danger text-danger">MESSAGE SUPPRIMÉ</p>
      <?php endif; ?>
  </div>
    

 
</div>

