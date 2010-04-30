<h1>Editar paralelo</h1>
<?php echo form_open("cursos/update") ?>
  <?php echo hidden('id', $vals) ?>

  <div class="fl" style="">

    <?php echo input('anio', 'Año', $vals) ?>
    <?php echo select('usuario_id', 'Profesor', $vals['usuario_id'], $profesores) ?>
    <?php echo select('materia_id', 'Materia', $vals['materia_id'], $materias) ?>
    <?php echo select('paralelo_id', 'Paralelo', $vals['paralelo_id'], $paralelos) ?>
    <?php echo checkbox('activo', 'Activo', $vals) ?>

  </div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Actualizar') ?>
</form>

