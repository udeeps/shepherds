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
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->

<!-- Included CSS Files (Compressed) -->
<link rel="stylesheet"
	href="/shepherds/resources/stylesheets/foundation.min.css">
<link rel="stylesheet" href="/shepherds/resources/stylesheets/app.css">

<script src="/shepherds/resources/javascripts/modernizr.foundation.js"></script>

<!-- IE Fix for HTML5 Tags -->
<!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>


<div class="row header"><!-- Start Header -->
<div class="five columns"><?php 



echo anchor('account', $customerName.' Maintenance');?></div>

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

<?php
if($requestlist->num_rows() > 0 )

{
	echo('
<div class="twelve columns ">
<h4>Your reports to our service</h4>

<dl class="sub-nav">
	<dt>Sort by:</dt>
	<dd class="active gppbg"><a href="#">Date</a></dd>
	<dd><a href="#">Status</a></dd>
</dl>
');
	foreach ($requestlist->result() as $row)
	{

		echo('
	<a href="details.html">
	<ul class="listing">
	<!-- Start single task listing -->
	<li class="panel">
	<h5>'.$row->subject.' - added at '. $row->dateRequested.'</h5>
	<div class="row">
	<div class="two columns">');
		if($row->requestStatus == 'finished')
		{
			echo('<p class="status finished">Status:<br>
	Finished</p>');
		}
		elseif($row->requestStatus == 'assigned')
		{
			echo('<p class="status underway">Status:<br>
	Work underway</p>');
		}
		echo('
	</div>
	<div class="six columns"><strong>Description:</strong>
	<p>'.$row->troubleshooting.'</p>
	</div>
	<div class="four columns"><strong>Starting time:</strong>
	<p>
	');
		
	if($row->dateAssigned!= NULL)
	echo($row->dateAssigned);
	else
	echo('Not assigned yet');
	
	
	echo('</p>
	</div>
	</div>
	</li>
</ul>
</a>
	');

	}



}
?> <!-- End single task listing --> 


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
<script src="/shepherds/resources/javascripts/jquery.js"></script>
<script src="/shepherds/resources/javascripts/foundation.min.js"></script>

<!-- Initialize JS Plugins -->
<script src="/shepherds/resources/javascripts/app.js"></script>
</body>
</html>
