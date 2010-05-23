<h1>Padres de familia</h1>

<div id="buscar" style="border: 1px solid #D0D2CF; padding: 0px 20px;">
  <form action="" id="form_buscar">
  <?php echo select('padre_id', 'Buscar por nombre', '', $padres_list) ?>
  <input type="submit" value="Buscar" />
  </form>
</div>

<br /><br />
<div style="clear:both"></div>

<?php echo link_to("Nuevo padre de familia", '/padres/create', array('class' => 'new') ) ?>

<table class="decorated">
	<th>Nombre completo</th>
	<th>Login</th>
	<th>Contrasea</th>

  <?php foreach($padres->result() as $padre): ?>
  <td><?php echo Padre_model::nombreCompleto($padre) ?></td>
  <td><?php echo $padre->login ?></td>
  <td><?php echo $padre->password ?></td>
  <?php endforeach; ?>
</table>
