<h1>Importar notas</h1>

<?php echo form_open_multipart('notas/importar') ?>

<?php echo select('paralelo_id', 'Curso', '', $cursos) ?>


<?php echo form_upload('notas_excel') ?>

  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Crear') ?>


</form>
