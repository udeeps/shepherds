  <div class="row content"> <!-- Start App Content -->
    <hr />
    <div class="twelve columns ">
      <p><?php echo anchor($back, 'Previous page');?></p>
      <h4>Tasks in the system</h4> 

      <dl class="sub-nav">
		<dt>Sort by:</dt>
		<dl id="status_nav">
			<dd class="active"><a class="stat_sort_opt" name="all">All</a></dd>
			<dd><a class="stat_sort_opt" name="recorded">Recorded</a></dd>
			<dd><a class="stat_sort_opt" name="in_progress">In progress</a></dd>
			<dd><a class="stat_sort_opt" name="stopped">Stopped</a></dd>
			<dd><a class="stat_sort_opt" name="completed">Completed</a></dd>
		</dl>
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
				<strong>Assigned workers:</strong>
				<?php if(isset($row->workerName)): ?>
					<p class="task_details_w_assigned">Task assigned</p>
					
				<?php else: ?>
					<p class="task_details_wn_assigned">No workers assigned</p>
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
		
			/* NO LONGER IN USE. USED WHEN SORTING WITH DATE AND WORKER ALSO
			
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
			});*/
			
			$('.stat_sort_opt').click(function(){
				var dd = $(this);
				var name = $(this).attr('name');
				var ajax_data = {
					statusName: (name == 'all') ? 'requestStatus' : name,
					ajax: '1'
				};
				
				$.ajax({
					url: "<?php echo site_url('request/list_tasks'); ?>/",
					data: ajax_data,
					type: 'POST',
					success: function(data){
						$('#wrapper').html(data);
						$('#status_nav dd').removeClass('active');
						$('a[name="'+name+'"]').parent().addClass('active');
					}
				});
				return false;
			});
		});
	</script>  
    </div>
    <hr />
  </div> <!-- End App Content -->