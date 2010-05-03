<h1>Nuevo curso</h1>
<?php echo form_open("cursos/create") ?>

  <div class="fl" style="">

    <?php echo input('anio', 'Año') ?>
    <?php echo select(array(
      'name' => 'usuario_id',
      'label' => 'Profesor',
      'value' => '',
      'options' => $profesores,
      'hint' => 'Seleccione si el profesor dicta todas las materias'
     )) ?>

    <?php echo select('paralelo_id', 'Paralelo', '', $paralelos) ?>
    <?php echo checkbox('activo', 'Activo') ?>

  </div>



 <div style="clear:both"></div>

  <fieldset id="materias" >
    <legend>Seleccione las materias del curso</legend>
    <?php 
     $vals = array();
      if(isset($_POST['materias'])){
        $vals = $_POST['materias'];
      }
     ?>
    <ul class="half">
      <?php foreach($materias as $k => $v): ?>
      <li>
          <label>
<?php 
$checked = false;
if(in_array($k, $vals))
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
  <?php echo form_submit('submit', 'Crear') ?>

</form>

<?php // echo input2(array('name' => 'je', 'hint' => 'Hint', 'required' => true, 'class' => 'nuevo')) ?>
<?php // echo select2(array('name' => 'je', 'hint' => 'Hint', 'required' => true, 'class' => 'nuevo','options' => array(1 => '1', 2 => 'dos'), 'value' => 2 )) ?>


