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
      <p><?php echo anchor($back, 'Previous page');?></p>
      <h3>Announcement management</h3> <hr /><!-- End "breadcrumbs" -->
    <div class="twelve columns panel">
      <h4>Add a new announcement</h4>
      <form name="newannouncement">
      <input type="text" placeholder="Title of the announcement" />
      <textarea name="newannouncement" class="newannouncement" placeholder="Write your new announcement here"></textarea>
      <input type="submit" class="button gppbutton fullwidth" value="Post the announcement" />
    </div>
    <div class="twelve columns panel">
      <h4>Edit existing announcements</h4>
      <a href="#"><p>Title of a previous announcement</p></a>
      <a href="#"><p>Title of a previous announcement</p></a>
      <a href="#"><p>Title of a previous announcement</p></a>
    </div>
    <hr />
  </div> <!-- End App Content -->
