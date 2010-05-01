<h1>Alumnos del curso (

<?php echo $paralelo['nivel'].' '.$paralelo['curso'].' '.$paralelo['paralelo'] ?>
)</h1>


<?php echo select('alumnos', 'Alumnos', '', $alumnos_list) ?>
<button id="alumnos_button" style="font-size:0.9em;">Agregar</button>

<div style="clear:both;"></div>

<h2>Alumos</h2>

<?php echo form_open("/asignar/curso") ?>

<?php echo hidden('id', $curso); ?>

<table class="decorated" id="table_alumnos">
  <tr>
    <th style="width: 300px">Alumno</th>
    <th>Código</th>
    <th>Sexo</th>
    <th></th>
  </tr>
  <?php $alumnos_seleccionados = array(); ?>

  <?php foreach($alumnos->result() as $alumno): ?>
  <tr>
    <td><input type="hidden" name="alumnos[]" value="<?php echo $alumno->id ?>" /><?php echo $alumno->alumno ?></td>
    <td><?php echo $alumno->codigo ?></td>
    <td><?php echo $alumno->sexo ?></td>
    <td><a href="javascript:" class="delete">borrar</a></td>
  </tr>
  <?php $alumnos_seleccionados[$alumno->id] = true; ?>
  <?php endforeach; ?>

</table>


<?php echo form_submit('submit', 'Asignar') ?>

</form>

<?php 
$alumnos = $this->Alumno_model->getAll()->result_array();
$arr = array();
foreach($alumnos as $v) {
  $arr[$v['id']] = $v;
}
?>

<script type="text/javascript">
var alumnos = <?php echo json_encode($arr); ?>;
var alumnos_seleccionados = <?php echo json_encode($alumnos_seleccionados) ?>;
$(document).ready(function() {


  /**
   * Crea el nombre completo del usuario
   */
  function nombreCompleto(obj) {
    var campos = ['primer_nombre', 'segundo_nombre', 'paterno', 'materno'];
    str = [];
    for(k in campos) {
      str.push(obj[campos[k]] );
    }
    return str.join(" ");
  }

  /**
   * Verifica si el objeto principal esta con los valores y lo adiciona
   */
  function adicionarAlumno() {
    var val = $('select[name=alumnos]').val();
    if(val != '' && !alumnos_seleccionados[val]) {
      var input = '<input type="hidden" name="alumnos[]" value="${1}" />'.replace(/\$\{1}/, val);
      var template = ['<tr>','<td>', input, '${1}</td>', '<td>${2}</td>', '<td>${3}</td>',
        '<td>','<a href="javascript:" class="delete">', 'borrar', '</a>',
        '</td>', '</tr>'];
      alumnos_seleccionados[val] = true;
      var html = template.join('');
      html = html.replace(/\$\{1}/, nombreCompleto(alumnos[val] ));
      html = html.replace(/\$\{2}/, alumnos[val]['codigo'] ).replace(/\$\{3}/, alumnos[val]['sexo']);

      $('#table_alumnos').append(html);
    }else {
      alert('Usted ya adiciono el alumno seleccionado');
    }
  }

  $('#alumnos_button').click(function() { adicionarAlumno() });

  $('#table_alumnos a.delete').live("click", function(e) {
    $(this).parents("tr:first").addClass("marked");
    var val = $(this).parents("tr").find("input:hidden").val();
    if(confirm('Esta seguro de borrar al alumno')) {
      delete(alumnos_seleccionados[val]);
      $(this).parents("tr:first").remove();
      $(this).parents("tr:first").removeClass("marked");
    }else{
      $('form').append("<input type='hidden' name='_delete[]' value='" + val + "' />");
      $(this).parents("tr:first").removeClass("marked");
      e.stopPropagation();
    }
  });

  // Formulario
  $('form').submit(function() {
    var submit = false;
    for(k in alumnos_seleccionados) {
      submit = true;
      break;
    }

    if(!submit) {
      alert("Debe tener al menos un alumno seleccionado");
      return false;
    }
  });
});
</script>
