<h1>Se a importado el archivo excel</h1>

<?php if(count($errors)): ?>
<div class="error">
  <h3>Se ha encontrado los siguientes errores</h3>
  <ul>
    <?php foreach($errors as $error): ?>
    <li><?php echo $error ?></li>
    <?php endforeach; ?>
  </ul>
</div>
<?php else: ?>
<div class="notice">
  <h3>Se ha importado el archivo de excel correctamente</h3>
</div>
<?php endif; ?>

<?php echo link_to( "Haga click aquí para ver la lista de alumnos", "/alumnos"); ?>
