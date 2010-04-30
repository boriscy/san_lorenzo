<h1>Alumnos del curso (
<?php echo $paralelo['nivel'].' '.$paralelo['curso'].' '.$paralelo['paralelo'] ?>
)</h1>

<?php echo select('alumnos', 'Alumnos', '', $alumnos_list) ?>
<button id="alumnos_button">Agregar</button>

<h2>Alumos</h2>

<table class="decorated" id="table_alumnos">
  <tr>
    <th style="width: 300px">Alumno</th>
    <th>Código</th>
    <th></th>
  </tr>

</table>

<?php 
$alumnos = $this->Alumno_model->getAll()->result_array();
$arr = array();
foreach($alumnos as $v) {
  $arr[$v['id']] = $v;
}
?>
<script type="text/javascript">
var alumnos = <?php echo json_encode($arr); ?>;
var lista_alumnos = {};
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
    if(val != '' || !lista_alumnos[val]) {
      var input = '<input type="hidden" name="alumnos[]" value="${1}" />'.replace(/\$\{1}/, val);
      var template = ['<tr>','<td>', input, '${1}</td>', '<td>${2}</td>',
        '<td>','<a href="javascript:" class="delete">', 'borrar', '</a>',
        '</td>', '</tr>'];
      lista_alumnos[val] = true;
      var html = template.join('');
      html = html.replace(/\$\{1}/, nombreCompleto(alumnos[val] ));
      html = html.replace(/\$\{2}/, alumnos[val]['codigo'] );

      $('#table_alumnos').append(html);
    }
  }

  $('#alumnos_button').click(function() { adicionarAlumno() });

  $('#table_alumnos a.delete').live("click", function() {
    var val = $(this).parents("tr").find("input:hidden").val();
    delete(lista_alumnos[val]);
    $(this).parents("tr:first").remove();
  });
});
</script>
