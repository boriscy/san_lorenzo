<h1>Nuevo usuario</h1>
<?php echo form_open("usuarios/create") ?>

  <div class="fl" style="width:300px">

    <?php echo input('primer_nombre', 'Primer nombre') ?>
    <?php echo input('segundo_nombre', 'Segundo nombre') ?>
    <?php echo input('paterno', 'Apellido paterno') ?>
    <?php echo input('materno', 'Apellido materno') ?>

  </div>

  <div class="fl">

    <?php echo input('login', 'Usuario') ?>
    <?php echo input('password', 'Contraseña') ?>
    <?php echo input('password_confirmation', 'Confirmación contraseña') ?>
    <?php echo input('email', 'Email') ?>

  </div>

  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>
</form>

