<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
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
  <link rel="stylesheet" href="<?php echo base_url(); ?>resources/stylesheets/foundation.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>resources/stylesheets/app.css">

  <script src="<?php echo base_url(); ?>resources/javascripts/modernizr.foundation.js"></script>

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

  <div class="row header"> <!-- Start Header -->
    <div class="five columns">
      <?php echo anchor('account', 'GPP Maintenance App');?>
    </div>

    <div class="four columns"> <!-- Start search -->
      <div class="row collapse">
        <div class="eight mobile-three columns">
          <input type="text" placeholder="Search" />
        </div>
        <div class="four mobile-one columns">
          <a href="#" class="postfix button expand gppbutton">Search</a>
        </div>
      </div>
      Search for: <input type="radio" name="group2" value="Wine" checked> Tasks
      <input type="radio" name="group2" value="Beer"> Users
    </div> <!-- End search -->

    <div class="three columns">
      <p>Logged in as <?php echo $name; ?></p>
      <p><?php echo anchor('login/log_out', 'Log out');?></p>
    </div>
  </div> <!-- End Header -->

  <div class="row content"> <!-- Start App Content -->
    <hr />
    <div class="twelve columns ">
      <p><?php echo anchor($back, 'Previous page');?></p>
      <h4>Tasks in the system</h4> 

      <dl class="sub-nav">
        <dt>Sort by:</dt>
        <dd class="active gppbg"><a href="#">Status</a></dd>
        <dd><a href="#">Date</a></dd>
        <dd><a href="#">Worker</a></dd>
      </dl> 

	  <?php if(count($taskList) > 0): ?>
		<?php foreach($taskList as $row): ?> 
      <a href="admin_task_details.html">
	  <ul class="listing"> <!-- Start single task listing -->
        <li class="panel">
          <h5>Title of the job - added <?php echo date('j.n.o', strtotime($row->dateRequested)); ?></h5>
			<div class="row">
			  <div class="two columns">
				<p class="status <?php echo $row->requestStatus; ?>">Status:<br><?php echo ucfirst(str_replace("_", " ", $row->requestStatus)); ?></p>
			  </div>
			  <div class="six columns">
				<strong>Description:</strong>
				<p>Malfunctioning product blocks a door and two cats. Malfunctioning product blocks a door and two cats. Malfunctioning product blocks a door and two cats. Malfunctioning product blocks a door and two cats.</p>
				<?php if(isset($row->workerName)): ?>
				
				<!-- TODO: IF MANY REQUESTDETAILS WITH SAME REQUEST ID, LOOP THROUGH TO GET ALL WORKERS -->
				
				<strong>Workers:</strong>
				<p><?php echo $row->workerName; ?></p>
				<?php endif; ?>
			  </div>
			  <div class="two columns">
				<strong>Starting time:</strong>
				<p>10/12/2012</p>
			  </div>
			  <div class="two columns">
				<strong>Finishing time:</strong>
				<p>10/12/2012</p>
			  </div>
			</div>
        </li>
      </ul></a> <!-- End single task listing -->
		<?php endforeach; ?> 
	  <?php endif; ?>
	  
      


    </div>
    <hr />
  </div> <!-- End App Content -->

  <div class="row footer"> <!-- Start Footer -->
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
  </div> <!-- End Footer -->
  
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
  <script src="<?php echo base_url(); ?>resources/javascripts/foundation.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="<?php echo base_url(); ?>resources/javascripts/app.js"></script>
</body>
</html>
