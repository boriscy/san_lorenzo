<h1>Editar paralelo</h1>
<?php echo form_open("paralelos/update") ?>
  <?php echo hidden('id', $vals) ?>
  <div class="fl" style="">

    <?php echo input('nivel', 'Nivel', $vals) ?>
    <?php echo input('curso', 'Curso', $vals) ?>
    <?php echo input('paralelo', 'Paralelo', $vals) ?>

  </div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Actualizar') ?>
</form>
