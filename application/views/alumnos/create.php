<h1>Nuevo alumno</h1>
<?php echo form_open("alumnos/create") ?>

  <div class="fl" style="width:49%">

    <?php echo input('primer_nombre', 'Primer nombre') ?>
    <?php echo input('segundo_nombre', 'Segundo nombre') ?>
    <?php echo input('paterno', 'Apellido paterno') ?>
    <?php echo input('materno', 'Apellido materno') ?>
    <?php echo input('num_doc', 'Número de documento') ?>

  </div>

  <div class="fl" style="width:49%">

    <?php echo input('codigo', 'Código') ?>
    <?php echo input('tipo', 'Tipo') ?>
    <?php echo input('sexo', 'Sexo') ?>
    <?php echo input('codrude', 'Codrude') ?>
    <?php echo input('email', 'Email') ?>
    <?php echo checkbox('activo', 'Activo') ?>

  </div>

  <div style="clear:both"></div>

  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>
</form>

