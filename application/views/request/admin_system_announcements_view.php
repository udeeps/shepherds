
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
