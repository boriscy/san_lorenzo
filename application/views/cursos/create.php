<h1>Nuevo curso</h1>
<?php echo form_open("cursos/create") ?>

  <div class="fl" style="">

    <?php echo input('anio', 'Año') ?>
    <?php echo select('usuario_id', 'Profesor', '', $profesores) ?>
    <?php echo select('materia_id', 'Materia', '', $materias) ?>
    <?php echo select('paralelo_id', 'Paralelo', '', $paralelos) ?>
    <?php echo checkbox('activo', 'Activo') ?>

  </div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>
</form>

