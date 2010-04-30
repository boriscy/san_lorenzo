<h1>Nuevo usuario</h1>
<?php echo form_open("usuarios/create") ?>

  <div class="fl" style="width:49%">

    <?php echo input('primer_nombre', 'Primer nombre') ?>
    <?php echo input('segundo_nombre', 'Segundo nombre') ?>
    <?php echo input('paterno', 'Apellido paterno') ?>
    <?php echo input('materno', 'Apellido materno') ?>

  </div>

  <div class="fl" style="width:49%">

    <?php echo input('login', 'Usuario') ?>
    <?php echo input('password', 'Contraseña') ?>
    <?php echo input('password_confirmation', 'Confirmación contraseña') ?>
    <?php echo input('email', 'Email') ?>

    <?php echo radio('tipo', 'Tipo', '', $this->Usuario_model->tipos) ?>

  </div>

  <div style="clear:both"></div>
  <div style="clear:both"></div>

  <fieldset id="materias" style="display:none">
    <legend>Seleccione materias</legend>
    <ul class="half">
      <?php foreach($materias->result() as $materia): ?>
      <?php 
      $val = false;
      if(isset($_POST['materias']) && in_array($materia->id, $_POST['materias']) )
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
  <?php echo form_submit('submit', 'Crear') ?>
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
