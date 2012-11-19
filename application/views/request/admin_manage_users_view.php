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
    <p><?php echo anchor($back, 'Previous page');?></p>
    <h3>User management</h3>
    <a href="admin_add_user.html"><div class="twelve columns panel adminpanel">
      <p>Add a new user</p>
    </div></a>
    <a href="adminuserlisting.html"><div class="twelve columns panel adminpanel">
      <p>View current users</p>
    </div></a>
    <hr />
  </div> <!-- End App Content -->
