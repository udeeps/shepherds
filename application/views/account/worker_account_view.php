
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

<?php if(!empty($tasks)): ?>
	<?php foreach($tasks as $row): ?> 
      <a href="<?php echo site_url('tasks/single_task').'/'.$wid.'/'.$row->repairRequestId; ?>">
	  <ul class="listing"> <!-- Start single task listing -->
        <li class="panel">
          <h5><?php if(!empty($row->title)){ echo $row->title; }else{ echo 'Repair request'; } echo ' - '.date('j/n/o', strtotime($row->dateRequested)); ?></h5>
			<div class="row">
			  <div class="two columns">
				<p class="status <?php echo $row->requestStatus; ?>"><?php echo ucfirst(str_replace("_", " ", $row->requestStatus)); ?></p>
			  </div>
			  <div class="six columns">
				<strong>Description:</strong>
				<p>
					<?php echo $row->description; ?>
				</p>
				<strong>Starting time:</strong>
					<?php if(isset($row->estimatedDateFinish)):?>
						<p><?php echo $row->estimatedDateFinish; ?></p>
					<?php else: ?>
						<p> - </p>
					<?php endif; ?>
			  </div>
			  <div class="four columns">
				<strong>Customer name:</strong>
				<p><?php echo $row->customerName; ?></p>
				<strong>Orderer name:</strong>
				<p><?php echo $row->ordererName; ?></p>
			  </div>
			</div>
        </li>
      </ul></a> <!-- End single task listing -->
	<?php endforeach; ?>
<?php else: ?>
	 <ul class="listing"> <!-- Start single task listing -->
		<li class="panel">
			<h5>No tasks assigned</h5>
		</li>
	 </ul>
<?php endif; ?> <!-- End single task listing -->

    </div>
    <hr />
  </div> <!-- End App Content -->
