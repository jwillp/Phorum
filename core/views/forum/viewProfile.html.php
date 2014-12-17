<?php include(VIEWS.'/header.html.php'); ?>

<div class="container">
    
    
    
    <div class="row well profileView">
        
        <div id="gravatar" class="col-md-2 text-right" >
            <img src="<?php echo($user->getProperty('gravatar')) ?>" alt="<?php echo($user->getProperty('username')) ?>" class="img-thumbnail">
        </div>
        <div class="col-md-10 profileInfo">
            <h2><?php echo($user->getProperty('username')) ?></h2>
            <p><strong>Inscrit depuis:</strong> <?php echo($user->getProperty('regDate')) ?></p>
            <p><strong>Nombre de messages:</strong> <?php echo(count($posts)) ?></p>
        </div>
        
        <h3>Contributions récentes</h3>
            
        
        
        <?php foreach($posts as $post):?>
        <hr>
            Dans le sujet: <a href="viewThread?threadId=<?php echo($post['thread']->getProperty('uid')); ?>"><?php echo($post['thread']->getProperty('title')); ?></a>
            <?php include(VIEWS.'/forum/postView.html.php'); ?>
        <?php endforeach; ?>
        
        
    </div>
    
    
    
    
</div>
<?php include(VIEWS.'/footer.html.php'); ?>