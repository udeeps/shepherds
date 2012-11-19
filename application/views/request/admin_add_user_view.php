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
