<?php $this->load->view('template/header'); ?>

<?php if($theme){ $this->load->view($theme.'_head'); } ?>
<?php $this->load->view($main_content); ?>

<?php $this->load->view('template/footer'); ?>