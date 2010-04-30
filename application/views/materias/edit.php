<h1>Editar materia</h1>
<?php echo form_open("materias/update") ?>
  <?php echo hidden('id', $vals) ?>
  <div class="fl" style="width:300px">

    <?php echo input('nombre', 'Nombre', $vals) ?>
    <?php echo input('codigo', 'Código', $vals) ?>

  </div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Actualizar') ?>
</form>

