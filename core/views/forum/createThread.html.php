<?php include(VIEWS.'/header.html.php'); ?>





<form action="createThread" method="post">
<!-- Form Name -->
<legend>Créer un sujet</legend>

<!-- Text input-->
<div class="form-group">
  <label class="control-label" for="threadTitle">Nom du sujet</label>  
  <input id="threadTitle" name="threadTitle" type="text" placeholder="Sujet" class="form-control input-md" required="">
</div>

<!-- Textarea -->
<div class="form-group">
  <label class="control-label" for="postText">Message</label>         
  <textarea style="height: 150px;" class="form-control" id="postText" placeholder="Entrez votre message" name="postText"></textarea>
</div>

<!-- Button -->
<div class="form-group">
    <input type="submit" class="btn btn-primary btn-login-submit" value="Valider" />
</div>
</form>







<?php include(VIEWS.'/footer.html.php') ?>