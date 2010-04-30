<h1>Editar alumno</h1>
<?php echo form_open("alumnos/update") ?>

  <?php echo hidden('id', $vals) ?>
  <div class="fl" style="width:49%">

    <?php echo input('primer_nombre', 'Primer nombre', $vals) ?>
    <?php echo input('segundo_nombre', 'Segundo nombre', $vals) ?>
    <?php echo input('paterno', 'Apellido paterno', $vals) ?>
    <?php echo input('materno', 'Apellido materno', $vals) ?>
    <?php echo input('num_doc', 'Número de documento', $vals) ?>

  </div>

  <div class="fl" style="width:49%">

    <?php echo input('codigo', 'Código', $vals) ?>
    <?php echo input('tipo', 'Tipo', $vals) ?>
    <?php echo input('sexo', 'Sexo', $vals) ?>
    <?php echo input('codrude', 'Codrude', $vals) ?>
    <?php echo input('email', 'Email', $vals) ?>
    <?php echo checkbox('activo', 'Activo', $vals) ?>

  </div>

  <div style="clear:both"></div>

  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Actualizar') ?>
</form>

