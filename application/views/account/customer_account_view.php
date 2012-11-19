
<div class="row header"><!-- Start Header -->
<div class="five columns">
<?php 
echo anchor('account', $customerName.' Maintenance');
?>
</div>

<div class="four columns"><!-- Start search -->
<div class="row collapse">
<div class="eight mobile-three columns"><input type="text"
	placeholder="Search" /></div>
<div class="four mobile-one columns"><a href="#"
	class="postfix button expand gppbutton">Search</a></div>
</div>
</div>
<!-- End search -->

<div class="three columns">
<p>Logged in as <?php echo $customerName; ?></p>
<p><?php echo anchor('login/log_out', 'Log out'); ?></p>
</div>
</div>
<!-- End Header -->

<div class="row">
<hr />
<div class="twelve columns">
<h5>Brief message to users</h5>
<p>A message to welcome the user to the system, possibly explaining the
basic functionality of the application so that there's less need for
support. Just a couple of lines to not burden the user with text. Just a
bit more, just to see how the layout responds to the amount of content.</p>
</div>
</div>

<div class="row content"><!-- Start App Content -->
<hr />




<div class="twelve columns ">
<h4>Your reports to our service</h4>

<dl class="sub-nav">
	<dt>Sort by:</dt>
	<?php 
	if($listByDate)
	{
	echo('<dd id="linkDate" class="active gppbg"><a href="">Date</a></dd>
	<dd id="linkStatus" class=""><a href="'.site_url("account/listByStatus").'">Status</a></dd>');
	}
	else
	{
	echo('<dd id="linkDate" class=""><a href="'.site_url("account/listByDate").'">Date</a></dd>
	<dd id="linkStatus" class="active gppbg"><a href="">Status</a></dd>');
	}
	?>
	
</dl>

<div id="task_list">
<?php
$this->load->view('account/listTasks',$requestlist);
?> <!-- End task listing --></div>


<hr />
</div>
<!-- End App Content -->
<script type="text/javascript">
$('#linkStatus').click(function() {
	var form_data = {
			ajax: '1'		
		};
	$.ajax({
		url: "<?php echo site_url('account/listByStatus'); ?>",
		type: 'POST',
		data: form_data,
		success: function(msg) {
			$('#task_list').html(msg);
			document.getElementById("linkStatus").setAttribute("class", "active gppbg");
			document.getElementById("linkDate").setAttribute("class", "");
			
		}
	});
	
	return false;
});

$('#linkDate').click(function() {
	var form_data = {
			ajax: '1'		
		};
	$.ajax({
		url: "<?php echo site_url('account/listByDate'); ?>",
		type: 'POST',
		data: form_data,
		success: function(msg) {
			$('#task_list').html(msg);
			document.getElementById("linkStatus").setAttribute("class", "");
			document.getElementById("linkDate").setAttribute("class", "active gppbg");
			
		}
	});
	
	return false;
});

	
</script>