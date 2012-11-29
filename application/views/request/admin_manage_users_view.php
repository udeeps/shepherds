
  <div class="row content"> <!-- Start App Content -->
    <hr />
    <p><?php echo anchor($back, 'Previous page');?></p>
    <h3>User management</h3>
    <a href="<?php echo site_url('request/add_user'); ?>"><div class="twelve columns panel adminpanel">
      <p>Add a new user</p>
    </div></a>
    <a href="<?php echo site_url('request/add_user'); ?>"><div class="twelve columns panel adminpanel">
      <p>View current users</p>
    </div></a>
    <hr />
  </div> <!-- End App Content -->
