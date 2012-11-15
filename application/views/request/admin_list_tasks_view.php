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
    <div class="twelve columns ">
      <p><?php echo anchor($back, 'Previous page');?></p>
      <h4>Tasks in the system</h4> 

      <dl class="sub-nav">
        <dt>Sort by:</dt>
        <dd class="active gppbg"><a class="req_list_sort" name="requestStatus" href="#">Status</a></dd>
        <dd><a class="req_list_sort" name="dateRequested" href="#">Date</a></dd>
        <dd><a class="req_list_sort" name="workerName" href="#">Worker</a></dd>
		<ul id="status_nav">
			<li><a class="stat_sort_opt" name="received">Received</a></li>
			<li><a class="stat_sort_opt" name="in_progress">In progress</a></li>
			<li><a class="stat_sort_opt" name="stopped">Stopped</a></li>
			<li><a class="stat_sort_opt" name="completed">Completed</a></li>
		</ul>
      </dl> 

	  <?php if(count($taskList) > 0): ?>
		<?php foreach($taskList as $row): ?> 
      <a href="<?php echo site_url('request/single_task').'/'.$row->repairRequestId; ?>">
	  <ul class="listing"> <!-- Start single task listing -->
        <li class="panel">
          <h5><?php if(!empty($row->title)){ echo $row->title; }else{ echo 'Repair request'; } echo ' - '.date('j/n/o', strtotime($row->dateRequested)); ?></h5>
			<div class="row">
			  <div class="two columns">
				<p class="status <?php echo $row->requestStatus; ?>"><?php echo ucfirst(str_replace("_", " ", $row->requestStatus)); ?></p>
			  </div>
			  <div class="six columns">
				<strong>Description:</strong>
				<p><?php echo $row->description; ?></p>
				<?php if(isset($row->workerName)): ?>
				
				<!-- TODO: IF MANY REQUESTDETAILS WITH SAME REQUEST ID, LOOP THROUGH TO GET ALL WORKERS -->
				
				<strong>Workers:</strong>
				<p><?php echo $row->workerName; ?></p>
				<?php endif; ?>
			  </div>
			  <div class="two columns">
				<strong>Starting time:</strong>
				<p>10/12/2012</p>
			  </div>
			  <div class="two columns">
				<strong>Finishing time:</strong>
				<p>10/12/2012</p>
			  </div>
			</div>
        </li>
      </ul></a> <!-- End single task listing -->
		<?php endforeach; ?> 
	  <?php endif; ?>
	<script type="text/javascript">
		$(document).ready(function(){
			$('.req_list_sort').click(function(){
				if( $(this).attr('name') == 'requestStatus' && $('#status_nav').css('display') == 'none'){
					$('#status_nav').fadeIn('fast');
				}else{
					if( $(this).attr('name') != 'requestStatus' || $(this).attr('class') != 'stat_sort_opt'){
						if( $('#status_nav').css('display') != 'none' ){
							$('#status_nav').fadeOut('fast');
						}
						
						var sort = $(this).attr('name');
						var ajax_data = {
							status: 0,
							ajax: '1'
						};
						
						$.ajax({
							url: "<?php echo site_url('request/list_tasks'); ?>/"+sort,
							data: ajax_data,
							type: 'POST',
							success: function(data){
								$('#wrapper').html(data);
							}
						});
					}
				}
				return false;
			});
			
			$('.stat_sort_opt').click(function(){
				var ajax_data = {
					status: 1,
					statusName: $(this).attr('name'),
					ajax: '1'
				};
				
				$.ajax({
					url: "<?php echo site_url('request/list_tasks'); ?>/",
					data: ajax_data,
					type: 'POST',
					success: function(data){
						$('#wrapper').html(data);
					}
				});
			
			});
		});
	</script>  
      


    </div>
    <hr />
  </div> <!-- End App Content -->