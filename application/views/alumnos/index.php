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
});
</script>
