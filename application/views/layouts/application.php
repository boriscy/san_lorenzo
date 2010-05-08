<?php $this->load->view("layouts/header") ?>

<!--NOTICES-->
<?php if( $this->session->flashdata('notice')  ): ?>
  <div id="notice">
    <?php echo $this->session->flashdata('notice') ?>
  </div>
<?php endif; ?>

<?php if( $this->session->flashdata('warning')  ): ?>
<div id="warning">
  <?php echo $this->session->flashdata('warning') ?>
</div>
<?php endif; ?>

<?php if( $this->session->flashdata('error')  ): ?>
<div id="error">
  <?php echo $this->session->flashdata('error') ?>
</div>
<?php endif; ?>
<!--END-->


<?php $this->load->view($template); ?>

<?php $this->load->view("layouts/footer") ?>
<div id="mask"></div>
