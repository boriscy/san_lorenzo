<h1>Editar paralelo</h1>
<?php echo form_open("cursos/update") ?>
  <?php echo hidden('id', $vals) ?>

  <div class="fl" style="">

    <?php echo input('anio', 'Año', $vals) ?>
    <?php echo select('usuario_id', 'Profesor', $vals['usuario_id'], $profesores) ?>
    <?php echo select('paralelo_id', 'Paralelo', $vals['paralelo_id'], $paralelos) ?>
    <?php echo checkbox('activo', 'Activo', $vals) ?>

  </div>
 <div style="clear:both"></div>

  <fieldset id="materias" >
    <legend>Seleccione las materias del curso</legend>
     <ul class="half">
      <?php foreach($materias as $k => $v): ?>
      <li>
          <label>
<?php 
$checked = false;
if(in_array($k, $vals['materias']))
  $checked = true;
?>
          <?php echo form_checkbox('materias[]', $k, $checked) ?>
          <?php echo $v ?>
          </label>
      </li>
      <?php endforeach; ?>
    </ul>
  </fieldset>

  <br /><br /><br />

  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Actualizar') ?>
</form>

