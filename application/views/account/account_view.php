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
  
  <!-- Included CSS Files (Uncompressed) -->
  <!--
  <link rel="stylesheet" href="stylesheets/foundation.css">
  -->
  
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
<!-- Start Header -->
  <div class="row header"> 
    <div class="five columns">
      <a href="admin.html"><h2>GPP Maintenance App</h2></a>
    </div>
	<!-- Start search -->
    <div class="four columns"> 
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
      <p>Logged in as <?php echo $_SESSION['name']; ?></p>
      <p><?php echo anchor('login/log_out', 'Log out');?></p>
    </div>
  </div> <!-- End Header -->
<!-- Start App Content -->
  <div class="row content"> 
    <hr />
    <a href="adminaddreport.html"><div class="twelve columns panel adminpanel">
      <p>Add new report to system</p>
    </div></a>
    <a href="adminlisting.html"><div class="twelve columns panel adminpanel">
      <p>View existing reports</p>
    </div></a>
    <a href="adminaddcustomer.html"><div class="twelve columns panel adminpanel">
      <p>Add a new customer</p>
    </div></a>
    <a href="adminusermanagement.html"><div class="twelve columns panel adminpanel">
      <p>Manage user accounts</p>
    </div></a>
    <a href="adminannouncements.html"><div class="twelve columns panel adminpanel">
      <p>Manage system announcements</p>
    </div></a>
    <hr />
  </div> <!-- End App Content -->
	<!-- Start Footer -->
  <div class="row footer"> 
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
  <script src="/gpp/resources/javascripts/jquery.js"></script>
  <script src="/gpp/resources/javascripts/foundation.min.js"></script>
  
  <!-- Initialize JS Plugins -->
  <script src="/gpp/resources/javascripts/app.js"></script>
</body>
</html>