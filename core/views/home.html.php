<?php include('header.html.php') ?>



<table class="table">

<thead>
        <tr>
          <th>Sujet</th>
          <th>Utilisateurs</th>
          <th>Posts</th>
        </tr>
</thead>
<tbody>


<?php
foreach($threads as $thread){
?>

        <tr>
            <td><a href="viewThread?threadId=<?php echo($thread['info']->getProperty('uid')); ?>"><?php echo($thread['info']->getProperty('title')); ?></a>    
          <?php if(count($thread['posts']) <= 1){ ?><span class="label label-primary">Nouveau</span><?php } ?>
          </td>
          

          <td><?php echo(array_values($thread['posts'])[0]['author']->getProperty('username') ); ?></td>
          <td><span class="badge"><?php echo(count($thread['posts'])); ?></span></td>
        </tr>
      <h4></h4>
   
 



<?php
}
?>

    
    
  </tbody>    
</table> 
    
    


<?php include('footer.html.php') ?>