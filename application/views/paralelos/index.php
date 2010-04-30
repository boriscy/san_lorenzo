<h1>Paralelos</h1>

<?php echo link_to("Nuevo paralelo", '/paralelos/create', array('class' => 'new') ) ?>
<table class="decorated">
  <tr>
    <th>Nivel</th>
    <th>Curso</th>
    <th>Paralelo</th>
    <th></th>
  </tr>
  <?php foreach($paralelos->result() as $paralelo): ?>
  <tr>
    <td><?php echo $paralelo->nivel; ?></td>
    <td><?php echo $paralelo->curso; ?></td>
    <td><?php echo $paralelo->paralelo; ?></td>
    <td>
      <?php echo link_to('editar', 'paralelos/edit/'.$paralelo->id) ?>
      <?php echo link_to('borrar', 'paralelos/destroy/'.$paralelo->id, array('delete' => $this->session->userdata('token') ) ) ?>
    </td>
  </tr>
  <?php endforeach; ?>
</table>

