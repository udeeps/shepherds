
  <div class="row content"> <!-- Start App Content -->
    <hr />
    <div class="twelve columns "> <!-- Start "breadcrumbs" -->
      <p><?php echo anchor($back, 'Back to user management');?></p>
      <h3>User management</h3> <hr /><!-- End "breadcrumbs" -->
		<div id="add_task_errors" class="twelve columns"><?php echo validation_errors(); ?></div>
    <div class="twelve columns panel">
      <h4>Add a new user</h4> 
	  
	  <?php if(isset($msg)): ?>
		 <!-- Shows success message -->
			<div id="add_task_msg" class="twelve columns panel">
				<h6><?php echo $msg; ?></h6>
			</div>
		<?php endif; ?>
	  
      <div class="row">
        <?php echo form_open('request/add_user', array('onsubmit' => 'return check_form()')); ?>
          <div class="four columns"> <!-- Name -->
            <label>First name</label>
            <input name="firstname" type="text" placeholder="" />
          </div>
          <div class="four columns">
            <label>Last name</label>
            <input name="lastname" type="text" placeholder="" />
          </div>

          <div class="four columns">
            <label>Email address</label>
            <input name="email" type="text" placeholder="" />
          </div>
      </div>

	  <div class="row">
        <div class="six columns">
          <label>Password</label>
          <input name="password" type="text" placeholder="" />
        </div>
        <div class="six columns">
          <label>Confirm password</label>
          <input name="pass_conf" type="text" placeholder="" />
        </div>
      </div>
	  
      <div class="row">
        <div class="six columns">
          <label>Postal address</label>
          <input name="address" type="text" placeholder="" />
        </div>
        <div class="two columns">
          <label>Postal number</label>
          <input name="zip" type="text" placeholder="" />
        </div>
        <div class="four columns">
          <label>City</label>
          <input name="city" type="text" placeholder="" />
        </div>
      </div>

      <div class="row">
        <div class="twelve columns">
          <p><strong>User level:</strong> <input type="radio" name="userlevel" value="worker" checked> Worker <input type="radio" name="userlevel" value="admin"> Admin</p>
          <input type="submit" class="button gppbutton fullwidth" value="Add new user" />
        </div>
      </div>
	  <?php echo form_close(); ?>
    </div>

    <a href="adminuserlisting.html"><div class="twelve columns panel adminpanel">
      <p>View current users</p>
    </div></a>
    <hr />
  </div> <!-- End App Content -->
