<h1>Alumnos</h1>

<a href="javascript:" id="a_importar">Importar archivo excel</a>
<div id="importar" style="display:none">
  <?php echo form_open_multipart('alumnos/import') ?>
    <label>Archivo de excel de alumnos</label>
    <?php echo form_upload(array('name' => 'alumnos_excel', 'size' => 50) ) ?>
    <div style="clear:both"></div>
    <?php echo form_submit('submit', 'Importar') ?>
  </form>


</div>


<div id="buscar" style="border: 1px solid #D0D2CF; padding: 0px 20px;">
  <form action="" id="form_buscar">
  <?php echo select('alumno_id', 'Buscar por nombre', '', $alumnos_list) ?>
  <input type="submit" value="Buscar" />
  </form>
</div>

<br /><br />
<div style="clear:both"></div>

<?php echo link_to("Nuevo alumno", '/alumnos/create', array('class' => 'new') ) ?>

<div class="pagination">
<?php echo $this->pagination->create_links() ?>
</div>

<table class="decorated">
  <tr>
    <th>Nombre completo</th>
    <th>Código</th>
    <th>Tipo</th>
    <th>Sexo</th>
    <th>Codrude</th>
    <th>Activo</th>
    <th></th>
  </tr>
  <?php foreach($alumnos->result() as $alumno): ?>
  <tr>
    <td><?php echo Alumno_model::nombreCompleto($alumno); ?></td>
    <td><?php echo $alumno->codigo; ?></td>
    <td><?php echo $alumno->tipo; ?></td>
    <td><?php echo $alumno->sexo; ?></td>
    <td><?php echo $alumno->codrude; ?></td>
    <td><?php echo activo($alumno->activo); ?></td>

    <td>
      <?php echo link_to('editar', 'alumnos/edit/'.$alumno->id) ?>
      <?php echo link_to('borrar', 'alumnos/destroy/'.$alumno->id, array('delete' => $this->session->userdata('token') ) ) ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="pagination">
<?php echo $this->pagination->create_links() ?>
</div>

<script>
$(document).ready(function() {
  $('#a_importar').click(function() {
    $(this).hide(200);
    $('#importar').show(300);
  });

  $('#form_buscar').submit(function(e) {
    var alumno_id = $('select[name=alumno_id]').val();
    if(alumno_id) {
      var url = "<?php echo site_url() ?>" + '/alumnos/edit/' + alumno_id;
      e.stopPropagation();
      window.location = url;
    }
    return false;
  });
});
</script>
