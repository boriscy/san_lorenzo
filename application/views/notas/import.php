<?php 
$anios = array();
for($i = 2000; $i < 2100; $i++)
  $anios[$i] = $i;
?>



<h1>Importar notas</h1>

<?php echo form_open_multipart('notas/importar') ?>

<?php // echo select('paralelo_id', 'Curso', '', $cursos) ?>

<?php 
$anio = '';
if(!isset($_POST['anio']))
  $anio = date("Y");
?>

<?php echo select('anio', 'Año', $anio, $anios); ?>

<div class="input">
  <label>Archivo excel de notas</label>
  <?php echo form_upload(array('name' => 'notas_excel', 'size' => 50) ) ?>
</div>


  <div style="clear:both"></div>
  <?php echo form_submit('submit', 'Importar') ?>


</form>

<script type="text/javascript">
$(document).ready(function(){
  $('#a_buscar').click(function() {
    $(this).hide(200);
    $('#importar').show(300);
  });
});
</script>