<?php include('header.html.php') ?>

<div class="jumbotron">
      <div class="container">
        <h1>Bienvenue sur <?php echo(SITE_NAME) ?></h1>
        <p>DynamiKoncept est fier de vous accueillir sur son tout nouveau forum de discussion «<?php echo(SITE_NAME) ?>» développé en partenariat avec ACME inc. </p>
        <p><a class="btn btn-primary btn-lg" href="learnMore" role="button">Apprenez-en plus »</a></p>
      </div>
</div>


<div class="container">


    <table class="table table-striped">
    <thead>
            <tr>
              <th>Sujet</th>
              <th>Auteur</th>
              <th>Nombre de messages</th>
              <th>Dernier message</th>
              <?php if(@in_array("Admin", $_SESSION['user_roles'])): ?>
                <th>Actions</th>
              <?php endif;?>
              
            </tr>
    </thead>
    <tbody>


    <?php foreach($threads as $thread): ?>
            <?php 
            // VÉRIFICATION VERROU DU THREAD
            $labels = array();
            foreach( $thread['info']->getLabels() as $lbl){
              $labels[] = $lbl->getName();
            }
            $threadLocked = in_array('LOCKED', $labels);
            ?>
            <tr>
              <td><a href="viewThread?threadId=<?php echo($thread['info']->getProperty('uid')); ?>"><?php echo($thread['info']->getProperty('title')); ?></a>    
              <?php if(count($thread['posts']) <= 1): ?><span class="label label-primary">Nouveau</span><?php endif; ?>
              </td>


              <td><a href="viewProfile?user=<?php echo(array_values($thread['posts'])[0]['author']->getProperty('username') ); ?>"><?php echo(array_values($thread['posts'])[0]['author']->getProperty('username') ); ?></a></td>
              <td><span class="badge"> <span class="glyphicon glyphicon-comment"></span> <?php echo(count($thread['posts'])); ?></span></td>
              
               <td><?php echo( end($thread['posts'])['info']->getProperty('date')    ); ?></td>
              
            <?php if(@in_array("Admin", $_SESSION['user_roles'])): ?>
               <td>
                   <?php if($threadLocked == true): ?>    
                        <a href="unlockThread?threadId=<?php echo($thread['info']->getProperty('uid')) ?>" class="btn btn-success"><span class="glyphicon glyphicon-lock"></span> Déverrouiller</a> 
                  <?php else: ?>      
                        <a href="lockThread?threadId=<?php echo($thread['info']->getProperty('uid')) ?>" class="btn btn-danger"><span class="glyphicon glyphicon-lock"></span> Verrouiller</a> 
                  <?php endif;?> 
              </td>
            <?php endif;?>
              

            </tr>

    <?php endforeach; ?>
    
     <?php if (empty($threads) == True): ?>
       <td>Il n'y a aucun post pour le moment</td>
     <?php endif; ?>
    


      </tbody>    
    </table> 

    
</div>

<?php include('footer.html.php') ?>