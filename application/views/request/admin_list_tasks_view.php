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
			<dd><a class="stat_sort_opt" name="cancelled">Cancelled</a></dd>
			<dd><a class="stat_sort_opt" name="completed">Completed</a></dd>
		</dl>
      </dl> 

	  <?php if(count($taskList) > 0): ?>
		<?php foreach($taskList as $row): ?> 
      <a href="<?php echo site_url('request/single_task').'/'.$row->repairRequestId; ?>">
	  <ul class="listing"> <!-- Start single task listing -->
        <li class="panel inprogress listingpanel">
		
			<div class="row">
              <div class="twelve columns">
                <div id="statuscircle" class="status_<?php echo $row->requestStatus; ?>">
					<?php echo ucfirst(str_replace("_", " ", $row->requestStatus)); ?>
				</div>
				<span class="listingtitle">
					<?php if(!empty($row->title)){ echo $row->title; }else{ echo 'Repair request'; } echo ' - '.date('j/n/o', strtotime($row->dateRequested)); ?>
				</span>
              </div>
            </div>
			<div class="row">
              <div class="six columns">
                <span><strong>Customer: </strong><?php echo $row->customerName; ?></span>
              </div>
              <div class="six columns">
                <span><strong>Location: </strong><?php echo $row->repairLocation; ?></span>
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