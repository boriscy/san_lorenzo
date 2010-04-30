<h1>Editar usuario</h1>
<?php 
if(!isset($vals))
  $vals = array();
?>

<?php echo form_open("usuarios/update") ?>
  <?php echo hidden('id', $vals) ?>
  <div class="fl" style="width:49%">

    <?php echo input('primer_nombre', 'Primer nombre', $vals ) ?>
    <?php echo input('segundo_nombre', 'Segundo nombre', $vals ) ?>
    <?php echo input('paterno', 'Apellido paterno', $vals) ?>
    <?php echo input('materno', 'Apellido materno', $vals) ?>
  </div>
  <div class="fl" style="width:49%">
    <?php echo input('email', 'Email', $vals) ?>
    <?php echo radio('tipo', 'Tipo', $vals['tipo'], $this->Usuario_model->tipos) ?>
  </div>

  <div style="clear:both"></div>
  <fieldset id="materias" style="display:none">
    <legend>Seleccione materias</legend>
    <ul class="half">
      <?php foreach($materias->result() as $materia): ?>
      <?php 
      $val = false;
      if(isset($vals['materias']) && in_array($materia->id, $vals['materias']) )
        $val = true;
      ?>
      <li>
        <label>
          <?php echo form_checkbox('materias[]', $materia->id, $val) ?>
          <?php echo $materia->nombre . ' (' . $materia->codigo . ')'?>
        </label>
      </li>
      <?php endforeach; ?>
    </ul>
  </fieldset>


  <br /><br /><br />
  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Actualizar') ?>
</form>

<script>
$(document).ready(function() {
  $('input:radio[name=tipo]').click(function(e) {
    if($(this).val() == 'profe'){
      $('#materias').show(300);
    }else {
      $('#materias').hide(300);
      $('#materias input:checkbox').attr("checked", false);
    }
  });

  if($('input:radio[name=tipo][value=profe]').attr("checked") ) {
    $('#materias').show();
  }
});
</script>
