<!DOCTYPE html>

<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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
    

    <!-- Included JS Files (Compressed) -->
  <script src="<?php echo base_url(); ?>resources/javascripts/jquery.js"></script>
  <script src="<?php echo base_url(); ?>resources/javascripts/foundation.min.js"></script>
  <script src="<?php echo base_url(); ?>resources/javascripts/html5placeholder.jquery.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="<?php echo base_url(); ?>resources/javascripts/app.js"></script>
  <script src="<?php echo base_url(); ?>resources/javascripts/modernizr.foundation.js"></script>
  <script src="<?php echo base_url(); ?>resources/javascripts/jQuery.validation.js"></script>
  
  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

<?php if( !isset($customerName) && isset($name)): ?>
  <div class="row header"> <!-- Start Header -->
    <div class="nine columns">
      <?php echo anchor('account', 'GPP Maintenance App');?>
    </div>

    <div class="three columns">
      <p>Logged in as <?php echo $name; ?></p>
      <p><?php echo anchor('login/log_out', 'Log out');?></p>
    </div>
  </div> <!-- End Header -->
<?php endif; ?>