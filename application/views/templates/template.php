<?php 
if($main_content =='request/customer_add_task_view')
$this->load->view('templates/customer_add_task_header');
else
$this->load->view('templates/header');
?>

<div id="wrapper">
	<?php $this->load->view($main_content); ?>
</div>

<?php $this->load->view('templates/footer'); ?>