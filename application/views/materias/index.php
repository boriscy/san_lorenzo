<h1>Materias</h1>

<?php echo link_to("Nueva materia", '/materias/create', array('class' => 'new') ) ?>
<table class="decorated">
  <tr>
    <th>Nombre</th>
    <th>Código</th>
    <th></th>
  </tr>
  <?php foreach($materias->result() as $materia): ?>
  <tr>
    <td><?php echo $materia->nombre; ?></td>
    <td><?php echo $materia->codigo; ?></td>
    <td>
      <?php echo link_to('editar', 'materias/edit/'.$materia->id) ?>
      <?php echo link_to('borrar', 'materias/destroy/'.$materia->id, array('delete' => $this->session->userdata('token') ) ) ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>
