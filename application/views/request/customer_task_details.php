<?php $row=$result[0];?>
<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
<meta charset="utf-8" />

<!-- Set the viewport width to device width for mobile -->
<meta name="viewport" content="width=device-width" />

<title><?php echo $title; ?></title>

<!-- Included CSS Files (Uncompressed) -->
<!--
  <link rel="stylesheet" href="<?php echo base_url(); ?>resources/stylesheets/foundation.css">
  -->

<!-- Included CSS Files (Compressed) -->
<link rel="stylesheet"
	href="<?php echo base_url(); ?>resources/stylesheets/foundation.min.css">
<link rel="stylesheet"
	href="<?php echo base_url(); ?>resources/stylesheets/app.css">

<script
	src="<?php echo base_url(); ?>resources/javascripts/modernizr.foundation.js"></script>

<!-- IE Fix for HTML5 Tags -->
<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

<div class="row header"><!-- Start Header -->
<div class="five columns"><?php 
echo anchor('account', $customerName.' Maintenance');
?></div>

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

<div class="row content"><!-- Start App Content -->
<hr />
<div class="twelve columns "><!-- Start "breadcrumbs" -->
<p><a href="<?php echo(site_url("account"));?>">&lArr; Back to task
listing</a></p>
<h4><?php echo($row->subject)?></h4>
<!-- End "breadcrumbs" -->

<ul class="details">
	<!-- Start detailed task info -->
	<li class="panel">
	<div class="row">
	<div class="two columns"><?php echo('<p class="status '.$row->requestStatus.'">Status:<br>'.$row->requestStatus.'</p>');?>
	</div>
	<div class="six columns">
	<p><b>What information can we give to customers?</b></p>
	<p><?php 
	echo("Request received on ".$row->dateRequested."<br/>");
	echo("Location - ".$row->repairLocation."<br/>");
	//echo("Work Type - ".$row->workTypeName."<br/>");
	?></p>
	<p><strong>Reported By: </strong><br />
	Name: <?php echo($row->ordererName);?> <br />
	Email: <?php echo($row->ordererEmail);?> <br />
	Phone No: <?php echo($row->ordererPhone);?></p>

	<!-- <p><strong>Admined By: </strong><br />
	Name: <?php echo($row->adminName);?> <br />
	Email: <?php echo($row->adminEmail);?> <br />
	Phone No: <?php echo($row->adminPhone);?></p>

	<p><strong>Task Performed By: </strong><br />
	<?php
	foreach($result as  $row)
	{
		echo(
	'Name: '.$row->workerName.'<br />
	Email: '.$row->workerEmail.'<br />
	Phone No: '.$row->workerPhone.'<br />
	Hours Worked: '.$row->workingHours.'<br/><br/>');
	}
	echo('</p>');

	foreach($result as  $row)
	{
		if($row->levelOfWorker == 1)
		echo('<p><strong>Actions performed: </strong>'. $row->actionsDone.'</p>');
	}
	?> -->
	
	
	<p><strong>Description: </strong><?php echo($row->troubleshooting);?>.</p>

	<div class="row"><!-- Start feedback box -->
	<hr />
	<div class="twelve columns"><label><strong>Comments</strong></label> <textarea
		name="feedbackbox" class="feedbackbox"
		placeholder="Comments and feedback regarding this task"></textarea> <a
		href="#" class="medium button gppbutton">Send us your feedback</a></div>
	</div>
	<!-- End feedback box --></div>
	<div class="two columns"><strong>Starting time:</strong>
	<p><?php if($row->dateAssigned!= NULL)
	echo($row->dateAssigned);
	else
	echo('Not assigned yet');?></p>
	</div>
	<div class="two columns"><strong>Estimated finish time:</strong>
	<p><?php if($row->dateFinished!= NULL)
	echo($row->dateFinished);
	else
	echo('Not predictable yet');?></p>
	</div>
	</div>
	</li>
</ul>
<!-- End detailed task info --></div>
<hr />
</div>
<!-- End App Content -->

<div class="row footer"><!-- Start Footer -->
<div class="six columns">
<h4>GPP Perimeter Protection Oy</h4>
<p>Brief footer text. Phone numer and other contact info.</p>
</div>
<div class="six columns">
<h4>Links</h4>
<ul class="link-list">
	<li><a href="#">GPP home page</a></li>
	<li><a href="#">Products</a></li>
	<li><a href="#">Services</a></li>
	<li><a href="#">Support</a></li>
</ul>
</div>
</div>
<!-- End Footer -->

<!-- Included JS Files (Uncompressed) -->
<!--
  
  <script src="javascripts/jquery.js"></script>
  
  <script src="javascripts/jquery.foundation.mediaQueryToggle.js"></script>
  
  <script src="javascripts/jquery.foundation.forms.js"></script>
  
  <script src="javascripts/jquery.foundation.reveal.js"></script>
  
  <script src="javascripts/jquery.foundation.orbit.js"></script>
  
  <script src="javascripts/jquery.foundation.navigation.js"></script>
  
  <script src="javascripts/jquery.foundation.buttons.js"></script>
  
  <script src="javascripts/jquery.foundation.tabs.js"></script>
  
  <script src="javascripts/jquery.foundation.tooltips.js"></script>
  
  <script src="javascripts/jquery.foundation.accordion.js"></script>
  
  <script src="javascripts/jquery.placeholder.js"></script>
  
  <script src="javascripts/jquery.foundation.alerts.js"></script>
  
  <script src="javascripts/jquery.foundation.topbar.js"></script>
  
  -->

<!-- Included JS Files (Compressed) -->
<script src="<?php echo base_url(); ?>resources/javascripts/jquery.js"></script>
<script
	src="<?php echo base_url(); ?>resources/javascripts/foundation.min.js"></script>

<!-- Initialize JS Plugins -->
<script src="<?php echo base_url(); ?>resources/javascripts/app.js"></script>
</body>
</html>
