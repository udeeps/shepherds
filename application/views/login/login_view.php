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

  <title>GPP Maintenance App</title>

  <!-- Included CSS Files (Compressed) -->
  <link rel="stylesheet" href="/gpp/resources/stylesheets/foundation.min.css">
  <link rel="stylesheet" href="/gpp/resources/stylesheets/app.css">

  <script src="/gpp/resources/javascripts/modernizr.foundation.js"></script>

  <!-- IE Fix for HTML5 Tags -->
  <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

</head>
<body>

  <div class="row header"> <!-- Start Header -->
    <div class="twelve columns">
      <a href="index.html"><h2>GPP Maintenance App</h2></a>
    </div>
  </div> <!-- End Header -->

  <div class="row"> <!-- Start App Content -->
    <hr />
    <div class="six columns">
      <?php echo form_open('login/form_validate'); ?>
        <label>Address</label>
        <div class="row">
          <div class="twelve columns">
            <?php echo form_input($userFields); ?>
          </div>
        </div>  
        <div class="row">
          <div class="twelve columns">
            <?php echo form_input($passwordFields); ?>
          </div>
        </div> 
          <?php echo form_submit($submit); ?>
      </form>   
    </div>
	<div id="errors">
		<?php echo validation_errors(); ?>
	</div>
    <div class="six columns">
      <h4>Welcome to the GPP Maintenance App!</h4>
      <p>This piece of text is here to both welcome the customers to the system as well as give them a brief introduction about it. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</a>
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
  
  <!-- Included JS Files (Compressed) -->
  <script src="/gpp/resources/javascripts/jquery.js"></script>
  <script src="/gpp/resources/javascripts/foundation.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="/gpp/resources/javascripts/app.js"></script>
</body>
</html>
