<h1>Alumnos</h1>

<?php echo link_to("Nuevo alumno", '/alumnos/create', array('class' => 'new') ) ?>
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
