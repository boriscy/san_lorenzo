<h1>Editar usuario</h1>
<?php 
if(!isset($vals))
  $vals = array();
?>

<?php echo form_open("usuarios/update") ?>
  <?php echo form_hidden('id') ?>
  <div class="fl" style="width:300px">

    <?php echo input('primer_nombre', 'Primer nombre', $vals ) ?>
    <?php echo input('segundo_nombre', 'Segundo nombre', $vals ) ?>
    <?php echo input('paterno', 'Apellido paterno', $vals) ?>
    <?php echo input('materno', 'Apellido materno', $vals) ?>
    <?php echo input('email', 'Email', $vals) ?>
  </div>

  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>
</form>
