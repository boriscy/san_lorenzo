<h1>Notas</h1>

<?php echo link_to("Importar notas", "/notas/new_import", array('class' => 'import')) ?>


<?php 
$anios = array();
for($i = 2000; $i < 2100; $i++)
  $anios[$i] = $i;
?>
<h2>Buscar notas por alumno</h2>
<div id="buscar" style="border: 1px solid #D0D2CF; padding: 0px 20px;">
<?php echo form_open("/notas/edit", array('method' => 'get') ) ?>
  <?php echo select('alumno_id', 'Buscar por nombre', '', $alumnos) ?>
  <?php echo input('codigo', 'Buscar por código') ?>
  <?php echo select('anio', 'Año', date('Y'), $anios); ?>

  <input type="submit" name="buscar" value="Buscar"/>
</form>
</div>

<script>
$(document).ready(function() {
  $('form').submit(function(e) {
    var codigo = $('input[name=codigo]').val(), alumno_id = $('select[name=alumno_id]').val(), anio = $('select[name=anio]').val();
    var url = "<?php echo site_url() ?>" + '/notas/edit/codigo:' + codigo + '/alumno_id:' + alumno_id + '/anio:' + anio;
    e.stopPropagation();
    window.location = url;
    return false;
  });
});
</script>
