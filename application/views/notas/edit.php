<style type="text/css">
.decorated td{
  text-align: right;
}

.decorated td.l{
  text-align: left;
}

#editor{
  width: 800px;
  padding: 20px 15px;
}
#editor input{
  width: 25px;
  font-size: 10px;
  text-align: right;
}

#editor th, #editor td{
  padding: 5px 4px;
}
#editor span.materia{
  color: #005800;
}

#editor button{
  margin: auto;
}

</style>

<h1>Notas</h1>
<h2><?php echo Alumno_model::nombreCompleto($alumno) ?> - <?php echo $anio ?></h2>

<table class="decorated">
<tr>
  <th>Materia</th>
  <?php foreach($this->Nota_model->columnas as $pos => $val): ?>
    <th><?php echo $val ?></th>
  <?php endforeach; ?>
</tr>

<?php foreach($notas->result() as $nota): ?>
<?php $n = json_decode($nota->notas) ?>
<?php $np = json_decode($nota->notas_profesor) ?>
<tr>
  <td class="l">
    <?php echo link_to($materias[$nota->materia_id], '/notas/find/'.$nota->id . '/'. $nota->alumno_id)  ?>
  </td>
  <?php foreach($this->Nota_model->columnas as $pos => $val): ?>
    <?php $nn = isset($np->{$val}) ? $np->{$val} : $n->{$val}; ?>
    <td><?php echo $nn ?></td>
  <?php endforeach; ?>
</tr>
<?php endforeach; ?>
</table>


<div id="editor" class="dialog">
  <span class="close"></span>
  <h2><?php echo Alumno_model::nombreCompleto($alumno) ?> - <?php echo $anio ?> (<span class="materia"></span>)</h2>
  <table class="decorated">
  <tr>
  <?php foreach($this->Nota_model->columnas as $pos => $val): ?>
    <th><?php echo $val ?></th>
  <?php endforeach; ?>
  </tr>
  
  <input type="hidden" name="nota_id" id="nota_id" value="" />
  <input type="hidden" name="alumno_id" id="alumno_id" value="" />
  <tr>
  <?php foreach($this->Nota_model->columnas as $pos => $val): ?>
    <td><input type="text" name="<?php echo $val ?>" id="<?php echo $val ?>" /></td>
  <?php endforeach; ?>
  </tr>

  </table>
  <br />
  <div>
  <button style="float: left">Salvar</button><span class="loader" style="float:left; margin-left: 4px;display:none;"></span>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function() {
  $('table.decorated tr:even').addClass("even");

  var tr = null;// current TR

  $('table.decorated a').click(function(e) {
    var target = e.target || e.srcElement;
    var pos = $(target).position();
    $("#editor.dialog").trigger("show:dialog").css("top", (pos.top - 70) + 'px');

    // Definir los hidden nota_id, alumno_id
    var datos = $(this).attr("href").match(/.*\/(\d+)\/(\d+)$/);
    var nota_id = datos[1], alumno_id = datos[2];
    $('#nota_id').val(nota_id);
    $('#alumno_id').val(alumno_id);
    // notas
    tr = $(this).parents("tr:first");
    tr.find("td").each(function(i, el) {
      var pos = i - 1;
      if(i > 0) {
        $('#editor input:text:eq('+pos+')').val($(el).text());
      }
    });
    var materia = $(this).text();
    // materia
    $('#editor h2 span.materia').html(materia);
    e.stopPropagation();
    return false;
  });
  
  $('body').bind("hide:dialog", function() {
    $('#editor input, #editor button').attr("disabled", false);
  });

  /* Actualizacion de notas */
  var columns = <?php echo json_encode($this->Nota_model->columnas) ?>;

  $('#editor button').click(function() {
    $(this).attr("disabled", true);
    $('#editor input').attr("disabled", true);

    $('#editor .loader').show();

    var data = {};
    $('#editor input').each(function(i, el) {
      data[$( el ).attr( "name" )] = $( el ).val();
    });

    $.ajax({
      'url': '<?php echo site_url() ?>/notas/update',
      'type': 'post',
      'data': data,
      'dataType': 'json',
      'success': function(response) {
        tr.find("td").each(function(i, el) {
          if(i > 0) {
            var val = $('#editor input:text:eq(' + (i - 1) + ')').val();
            $(el).html(val);
          }
        });
        $('.dialog .close').trigger("click");
        $('#editor .loader').hide();
        // Marcar
        mark(tr, 35);
      },
      'failure': function() {
          $('#editor .loader').hide();
      }
    });
  });
});
</script>
