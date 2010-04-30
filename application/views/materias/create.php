<h1>Nueva materia</h1>
<?php echo form_open("materias/create") ?>

  <div class="fl" style="width:300px">

    <?php echo input('nombre', 'Nombre') ?>
    <?php echo input('codigo', 'Código') ?>

  </div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>
</form>

