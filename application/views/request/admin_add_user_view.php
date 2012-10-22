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
  <link rel="stylesheet" href="/shepherds/resources/stylesheets/foundation.min.css">
  <link rel="stylesheet" href="/shepherds/resources/stylesheets/app.css">

  <script src="/shepherds/resources/javascripts/modernizr.foundation.js"></script>

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
    <div class="twelve columns "> <!-- Start "breadcrumbs" -->
      <p><?php echo anchor($back, 'Back to user management');?></p>
      <h3>User management</h3> <hr /><!-- End "breadcrumbs" -->

    <div class="twelve columns panel">
      <h4>Add a new user</h4> 
      <div class="row">
        <form name="newuser">
          <div class="four columns"> <!-- Name -->
            <label>First name</label>
            <input type="text" placeholder="" />
          </div>
          <div class="four columns">
            <label>Last name</label>
            <input type="text" placeholder="" />
          </div>

          <div class="four columns">
            <label>Email address</label>
            <input type="text" placeholder="" />
          </div>
      </div>

      <div class="row"> <!-- Street etc. -->
        <div class="six columns">
          <label>Postal address</label>
          <input type="text" placeholder="" />
        </div>
        <div class="two columns">
          <label>Postal number</label>
          <input type="text" placeholder="" />
        </div>
        <div class="four columns">
          <label>City</label>
          <input type="text" placeholder="" />
        </div>
      </div>

      <div class="row">
        <div class="twelve columns">
          <p><strong>User level:</strong> <input type="radio" name="group2" value="Wine" checked> Worker <input type="radio" name="group2" value="Beer"> Admin</p>
          <input type="submit" class="button gppbutton fullwidth" value="Add new user" />
        </div>
      </div>
    </div>

    <a href="adminuserlisting.html"><div class="twelve columns panel adminpanel">
      <p>View current users</p>
    </div></a>
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
  <script src="/shepherds/resources/javascripts/jquery.js"></script>
  <script src="/shepherds/resources/javascripts/foundation.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="/shepherds/resources/javascripts/app.js"></script>
</body>
</html>
