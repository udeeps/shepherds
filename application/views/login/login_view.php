  <div class="row header"> <!-- Start Header -->
    <div class="twelve columns">
      <a href=""><h2>GPP Maintenance App</h2></a>
    </div>
  </div> <!-- End Header -->

  <div class="row"> <!-- Start App Content -->
    <hr />
	<?php if($validate == '1'):?>
		<div class="twelve columns">
	<?php else: ?>
		<div class="six columns">
	<?php endif;?>
	<font color="red">
	<?php echo validation_errors(); ?>
	</font>
	
	<?php if($msg!=''){?>
        <div class="row">
          <div class="twelve columns">
            <?php echo ('<p><font color="red">'.$msg.'</font></p>'); ?>
          </div>
        </div> 
        <?php 
        }
        ?>

      <?php
      if($validate == '1')
      echo form_open('login');
      else 
	  echo form_open(''); 
	  
	  ?>
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
	<?php if($validate == '2'): ?>
		<div class="six columns">
		  <h4>Welcome to the GPP Maintenance App!</h4>
		  <p>This piece of text is here to both welcome the customers to the system as well as give them a brief introduction about it. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</a>
		</div>
	<?php endif; ?>
    <hr />
  </div> <!-- End App Content -->