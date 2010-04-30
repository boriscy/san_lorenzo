<h1>Usuarios</h1>

<?php echo link_to("Nuevo usuario", '/usuarios/create', array('class' => 'new') ) ?>
<table class="decorated">
  <tr>
    <th>Nombre completo</th>
    <th>Usuario</th>
    <th>Email</th>
    <th>Usuario</th>
  </tr>
  <?php foreach($usuarios->result() as $usuario): ?>
  <tr>
    <td><?php echo Usuario_model::nombreCompleto($usuario); ?></td>
    <td><?php echo $usuario->login; ?></td>
    <td><?php echo $usuario->email; ?></td>
    <td><?php echo link_to('editar', 'usuarios/edit/'.$usuario->id) ?></td>
  </tr>
  <?php endforeach; ?>
</table>
