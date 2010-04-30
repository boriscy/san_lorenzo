<h1>Nuevo paralelo</h1>
<?php echo form_open("paralelos/create") ?>

  <div class="fl" style="">

    <?php echo input('nivel', 'Nivel') ?>
    <?php echo input('curso', 'Curso') ?>
    <?php echo input('paralelo', 'Paralelo') ?>

  </div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>
</form>

