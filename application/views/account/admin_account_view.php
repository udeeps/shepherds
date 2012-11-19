<!-- Start Header -->
  <div class="row header"> 
    <div class="five columns">
      <?php echo anchor('account', 'GPP Maintenance App');?>
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
      <p>Logged in as <?php echo $name; ?></p>
      <p><?php echo anchor('login/log_out', 'Log out');?></p>
    </div>
  </div> <!-- End Header -->
<!-- Start App Content -->
  <div class="row content"> 
    <hr />
    <a href="request/index"><div class="twelve columns panel adminpanel">
      <p>Add new task</p>
    </div></a>
    <a href="request/list_tasks"><div class="twelve columns panel adminpanel">
      <p>View existing tasks</p>
    </div></a>
    <a href="request/manage_users"><div class="twelve columns panel adminpanel">
      <p>Manage user accounts</p>
    </div></a>
    <a href="request/system_announcements"><div class="twelve columns panel adminpanel">
      <p>Manage system announcements</p>
    </div></a>
    <hr />
  </div> <!-- End App Content -->