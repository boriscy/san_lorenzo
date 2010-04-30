<h1>Cursos</h1>

<?php echo link_to("Nuevo curso", '/cursos/create', array('class' => 'new') ) ?>
<table class="decorated">
  <tr>
    <th>Profesor</th>
    <th>Materia</th>
    <th>Paralelo</th>
    <th>Año</th>
    <th>Activo</th>
    <th></th>
  </tr>
  <?php foreach($cursos->result() as $curso): ?>
  <tr>
    <td><?php echo $curso->nombre_completo; ?></td>
    <td><?php echo $curso->materia; ?></td>
    <td><?php echo $curso->paralelo; ?></td>
    <td><?php echo $curso->anio; ?></td>
    <td><?php echo activo($curso->activo); ?></td>
    <td>
      <?php echo link_to('Asignar alumnos', 'asignar/curso/'.$curso->id, array('class' => 'curso')) ?><br/>
      <?php echo link_to('editar', 'cursos/edit/'.$curso->id) ?>
      <?php echo link_to('borrar', 'cursos/destroy/'.$curso->id, array('delete' => $this->session->userdata('token') ) ) ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

