<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
  <title>Colegio</title>
  <link rel="stylesheet" href="<?php echo base_url();?>system/css/style.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php echo base_url();?>system/css/ufd/plain.css" type="text/css" media="screen" />
  <script type="text/javascript" src="<?php echo base_url() ?>system/javascript/jquery-1.4.2.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>system/javascript/app.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>system/javascript/ui.core.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>system/javascript/jquery.bgiframe.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>system/javascript/jquery.ui.ufd.js"></script>
</head>
  <body>
    <div id="wrapper">
      <div id="header">
      </div>
      <?php if($this->session->userdata('usuario_id')): ?>
        <?php $this->load->view('/layouts/menu') ?>
      <?php endif; ?>
      <div id="cont">

