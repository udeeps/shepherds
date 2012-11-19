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
    </div> <!-- End search -->

    <div class="three columns">
      <p>Logged in as <?php echo $name; ?></p>
      <p><?php echo anchor('login/log_out', 'Log out'); ?></p>
    </div>
  </div> <!-- End Header -->

  <div class="row">
    <hr />
    <div class="twelve columns callout panel announcement">
      <h5>Announcement from Head of Maintenance</h5>
      <p>In case the head of maintenance has something to announce to all the workers, this text could appear here to draw attention to the issue. HoM could add/remove this from his administrative tools.</p>
    </div>
  </div>

  <div class="row content"> <!-- Start App Content -->
    <hr />
    <div class="twelve columns ">
      <h4>Tasks assigned to you</h4> 

      <dl class="sub-nav">
        <dt>Sort by:</dt>
        <dd class="active gppbg"><a href="#">Date</a></dd>
        <dd><a href="#">Status</a></dd>
      </dl> 

      <a href="workerdetails.html"><ul class="listing"> <!-- Start single task listing -->
        <li class="panel">
          <h5>Title of the job - added at 25/12/2001</h5>
        <div class="row">
          <div class="two columns">
            <p class="status underway">Status:<br>Work underway</p>
          </div>
          <div class="six columns">
            <strong>Description:</strong>
            <p>Malfunctioning product blocks a door and two cats. Malfunctioning product blocks a door and two cats. Malfunctioning product blocks a door and two cats. Malfunctioning product blocks a door and two cats.</p>
          </div>
          <div class="four columns">
            <strong>Starting time:</strong>
            <p>10/12/2012</p>
          </div>
        </div>
        </li>
      </ul></a> <!-- End single task listing -->

    </div>
    <hr />
  </div> <!-- End App Content -->
