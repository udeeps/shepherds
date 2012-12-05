
  <div class="row content"> <!-- Start App Content -->
    <hr />
    <div class="twelve columns "> <!-- Start breadcrumbs and title -->
      <p><?php echo anchor($back, 'Previous page');?></p>
      <h3><?php 
				if(!empty($taskData['info']->title)){ 
					echo $taskData['info']->title;
				}else{ 
					echo 'Repair request'; 
				} 
				echo ' - '.date('j/n/o', strtotime($taskData['info']->dateRequested)); 
			?></h3> <hr /><!-- End breadcrumbs and title" -->
    </div>

    
<div class="row"> <!-- Start form -->
  <div class="twelve columns">
<?php echo form_open('', array('id' => 'add-worker-form')); ?>
		<div class="row panel"> <!-- Workers assigned -->
          <h4>Assigned workers</h4>
		  <span class="add-worker-error"></span>
          <div class="row">
            <div class="twelve columns">
              <ul>
			<?php if(!isset($taskData['workers'])): ?>
				<li>No workers assigned for this task</li>
			<?php elseif(count($taskData['workers']) == 1): ?>
				<li><?php echo $taskData['workers'][0]->workerName; ?> <?php echo anchor('request/remove_from_task/'.$this->uri->segment(3).'/'.$taskData['workers'][0]->workerId, 'Remove from task', 'class="w_remove"'); ?></li>
			<?php else: ?>
				<?php foreach($taskData['workers'] as $row): ?>
					<li><?php echo $row->workerName; ?> <?php echo anchor('request/remove_from_task/'.$this->uri->segment(3).'/'.$row->workerId, 'Remove from task', 'class="w_remove"'); ?></li>
				<?php endforeach; ?>
			<?php endif; ?>
              </ul>
            </div>
          </div>
          <div class="eight columns">
            <label>Add workers</label>
            <input id="add_worker_text" name="worker_input" type="text" placeholder="Start writing to choose from list" />
          </div>
			<div class="four columns">
			  <label>Estimated date of completion</label>
			  <div class="row">
				<div class="four columns">
				  <input type="text" placeholder="<?php if(!empty($taskData['info']->estimatedDateFinish)){ echo date('j', strtotime($taskData['info']->estimatedDateFinish)); }else{echo 'pp';}; ?>" name="day" />
				</div>
				<div class="four columns">
				  <input type="text" placeholder="<?php if(!empty($taskData['info']->estimatedDateFinish)){ echo date('n', strtotime($taskData['info']->estimatedDateFinish)); }else{echo 'kk';}; ?>" name="month" />
				</div>
				<div class="four columns">
				  <input type="text" placeholder="<?php if(!empty($taskData['info']->estimatedDateFinish)){ echo date('o', strtotime($taskData['info']->estimatedDateFinish)); }else{echo 'vvvv';}; ?>" name="year" />
				</div>
			  </div>
			</div>
          <div class="six columns">
            <input id="add_worker_btn" type="submit" class="button gppbutton" value="Save worker info" />
          </div>
		  <div id="add_worker_msg" class="six columns"></div>
        </div>
<?php echo form_close(); ?>

        <hr />
		
<?php echo form_open('request/single_task/'.$this->uri->segment(3), array('id' => 'edit-request')); ?>
		<div class="row panel">
		  <div class="seven columns">
				<strong>Type of work:</strong>
				<?php foreach($workTypes as $type): ?>
					<?php if($type->workTypeName != $taskData['info']->workTypeName): ?>
						<input type="radio" name="type_maintenance" value="<?php echo $type->workTypeName ?>"> <?php echo ucfirst($type->workTypeName); ?> 
					<?php else: ?>
						<input type="radio" name="type_maintenance" value="<?php echo $type->workTypeName ?>" checked> <?php echo ucfirst($type->workTypeName); ?> 
					<?php endif; ?>
				<?php endforeach; ?>
			<span id="det-warranty"><input type="checkbox" name="warranty" <?php echo ($taskData['info']->warranty) ? 'checked' : '' ;?>/> Warranty</span>
		  </div>
		  <div class="five columns">
			<p id="status_bar" class="status <?php echo $taskData['info']->requestStatus; ?>"><?php echo ucfirst(str_replace("_", " ", $taskData['info']->requestStatus)); ?></p>
			<select name="change_status" class="statuspicker">
				<option>-- Change status --</option>
					<?php foreach($statusTypes as $type): ?>
						<?php if($type->requestStatus != $taskData['info']->requestStatus): ?>
							<option value="<?php echo $type->requestStatus; ?>"><?php echo ucfirst(str_replace("_", " ", $type->requestStatus));  ?></option>
						<?php endif;?>
					<?php endforeach; ?> 
			</select>
		  </div>
		</div>
		
		<hr/> 
		
        <div class="row panel">
          <h4>Customer information</h4>
          <div class="six columns"> <!-- Name -->
            <label>Customer name (company)</label>
            <input name="customername" type="text" placeholder="Already here from CRM" />
          </div>
          <div class="six columns">
            <label>Billing address</label>
            <input name="billingaddress" type="text" placeholder="Already here from CRM" />
          </div>
        </div>


        <div class="row panel"><!-- Orderer info -->
          <div class="four columns">
            <label>Orderer of work (individual)</label>
            <input type="text" name="orderer" placeholder="Already here from CRM" />
          </div>
          <div class="four columns">
            <label>Phone number</label>
            <input type="text" name="customerphone" placeholder="Already here from CRM" />
          </div>
          <div class="four columns">
            <label>Email address</label>
            <input type="text" name="customeremail" placeholder="Already here from CRM" />
          </div>
        </div>
  
      <hr />

      <div class="row panel"><!-- Task title and description -->
        <h4>Task description</h4>
        <div class="twelve columns">
          <label>Task title</label>
          <input type="text" name="tasktitle" placeholder="<?php if(!empty($taskData['info']->title)){ echo $taskData['info']->title;}else{ echo 'Repair request'; }?>" />
        </div>
      </div>

      <div class="row panel">
        <div class="twelve columns">
          <label>Description of assignment</label>
          <textarea name="taskdescription" class="descriptionform" placeholder="<?php echo $taskData['info']->description; ?>"></textarea>
        </div>
      </div>


      <hr />

      <div class="row panel">
        <h4>What has been done</h4>
        <div class="twelve columns">
          <label>Actions taken on site</label>
          <textarea name="taskactions" class="descriptionform" placeholder=""></textarea>
        </div>
      </div>

      <hr />

      <div class="row panel"><!-- Parts and prices -->
        <h4>Working time</h4>
        <div class="row>">
          <div class="three columns">
            <label>Working hours</label>
            <input name="workhours" type="text" placeholder="0,0" />
          </div>
          <div class="three columns">
            <label>Driving hours</label>
            <input name="drivehours" type="text" placeholder="0,0" />
          </div>
          <div class="three columns">
            <label>Kilometer compensation</label>
            <input name="kmcompensation" type="text" placeholder="11,5" />
          </div>
          <div class="three columns">
            <label>Total</label>
            <input name="totalworkcost" type="text" placeholder="Automatically counted" />
          </div>
          <hr />
        </div>

        <h4>Products and parts</h4>
        <div id="parts-list-parent" class="row"> <!-- Start line of product -->
			<div class="parts-row">
			  <div class="three columns">
				<label>Part product code - <a href="#">Show popular</a></label>
				<input name="prod_code[]" type="text" placeholder="" />
			  </div>	
			  <div class="four columns">
				<label>Description</label>
				<input name="prod_desc[]" type="text" placeholder="" />
			  </div>
			  <div class="one columns">
				<label>Quantity</label>
				<input name="prod_quantity[]" type="text" placeholder="" />
			  </div>
			  <div class="one columns">
				<label>Ordered</label> 
				<select name="prod_ordered[]" class="orderedornot">
				  <option value="notordered">No</option>
				  <option value="ordered">Yes</option>
				</select>
			  </div>
			  <div class="one columns">
				<label>á price</label>
				<input name="prod_price[]" type="text" placeholder="CRM" />
			  </div>
			  <div class="two columns">
				<label>Total</label>
				<input name="prod_total[]" type="text" placeholder="Automatic count" />
			  </div>
			</div>
        </div> <!-- End line of product -->

          <div class="row"> <!-- Start total sum -->
            <div class="nine columns">
				<input id="add-prod" type="button" class="button gppbutton" value="Add product"/>
            </div>
            <div class="three columns">
              <label><strong>Total sum</strong></label>
              <input name="total" type="text" placeholder="Automatic count" />
            </div>
          </div> <!-- End total sum -->

      </div>

<div class="row panel">
<input type="submit" class="button gppbutton fullwidth" value="Save form">
</div>

<?php echo form_close(); ?>
  </div>
</div> <!-- End form -->
<!-- Start comments -->
<div class="row">
	<div class="twelve columns">
		<?php echo form_open('', array('id' => 'add-comment-form')); ?>
			<div class="row panel">
				<h4>View comments</h4>
					<?php if(!empty($comments)):?>
						<?php foreach($comments as $comment):?>
							<div class="comment">
								<div id="c_from" class="twelve columns">
									<span><strong>Author: </strong></span>
									<span><?php echo $comment->author; ?> <?php echo date('j/n/o', strtotime($comment->date)); ?></span>
								</div>
								<div id="c_body" class="twelve columns">
									<span><strong>Message: </strong></span>
									<textarea><?php echo $comment->text; ?></textarea>
								</div>
							</div>
							<div id="reply">
								<div id="c_reply" class="twelve columns">
									<span><strong>Reply message: </strong></span>
									<textarea name="admin_reply"></textarea>
									<input type="hidden" name="commentId" value="<?php echo $comment->commentId; ?>" />
								</div>
							</div>
							<div class="six columns">
								<input type="submit" class="button gppbutton" name="replysubmit" value="Post reply" />
							</div>
							<div id="add_reply_msg" class="six columns"></div>
						<?php endforeach; ?>
					<?php else: ?>
						<div id="no_comments">
							<div class="twelve columns">
								<p>No comments on this issue</p>
							</div>
						</div>
					<?php endif; ?>
			</div>
		<?php echo form_close(); ?>
	</div>
</div>
<!-- End comments -->
<script type="text/javascript">
	$(document).ready(function(){
		
		$(':input[placeholder]').placeholder();
		
		$.validator.addMethod("checkBirthday", function(value, element) {
			return this.optional(element) || ( value > 0 && value <= 31);
		}, "Päivämäärä syötetty väärin");
		
		$.validator.addMethod("checkMonth", function(value, element) {
			return this.optional(element) || ( value > 0 && value <= 12);
		}, "Kuukausi syötetty väärin");
		
		$.validator.addMethod("checkYear", function(value, element) {
			return this.optional(element) || ( value.length == 4 && value > 1900 && value < 2100);
		}, "Anna vuosi");
		
		$('#add-worker-form').validate({
			rules: {
				day: 'required checkBirthday',
				month: {
					required: true,
					checkMonth: 'default'
				},
				year: {
					required: true,
					checkYear: 'default'
				},
			},
			messages: {
				day: {required: 'Syötä ainakin työn valmistumispäivä'},
				month: {required: 'Syötä ainakin työn valmistumispäivä'},
				year: {required: 'Syötä ainakin työn valmistumispäivä'},
			},
			errorPlacement: function(error, element){
				error.appendTo('.add-worker-error');
			},
			submitHandler: function(form){
				add_worker_ajax();
				return false;
			}
		});
	
		$("select[name='change_status']").change(function(){
			var values = {
				id: <?php echo $taskData['info']->repairRequestId; ?>,
				status: $(this).children('option:selected').val()
			};
			
			$.ajax({
				url: "<?php echo site_url('request/change_status'); ?>",
				data: values,
				type: 'POST',
				success: function(data){
					if(data){
						$('#status_bar').attr('class', 'status '+values.status);
						var newstatus = fluc(values.status);
						$('#status_bar').text(newstatus);
					
						var types = ['recorded', 'in_progress', 'cancelled', 'completed'];
						var select_html = '<option value="">-- Change status --</option>';
						for(var i=0; i<types.length; i++){
							if(types[i] != values.status){
								select_html += '<option value="'+types[i]+'">'+fluc(types[i]);+'</option>';
							}
						}
						$("select[name='change_status']").html(select_html);
					}
					
					function fluc(str){
						if(str.indexOf('_') != -1){
							str = str.replace('_', ' ');
						}
						var new_str = str.toLowerCase().replace(/^(.)/g, 
							function($1){ return $1.toUpperCase();
						});
						return new_str;
					}
				}
			});
		});		
		
		$('.w_remove').click(function(){
			var length = $('.w_remove').length;
			var link = $(this);
			var values = {
				task: <?php echo $this->uri->segment(3); ?>,
				worker: $(this).attr('href').substr($(this).attr('href').length - 1),
				ajax: 1
			};
			
			$.ajax({
				url: "<?php echo site_url('request/remove_from_task'); ?>",
				data: values,
				type: 'POST',
				success: function(data){
					if(data){
						if(length < 2){
							link.parent('li').html('No workers assigned for this task');
						}else{
							link.parent('li').remove();
						}
					}
				}
			});
			return false;
		});	
		
		function add_worker_ajax(){
			
			var values = {
				requestId: <?php echo $this->uri->segment(3); ?>,
				assignees: $('input[name="worker_input"]').val(),
				day: $('input[name="day"]').val(),
				month: $('input[name="month"]').val(),
				year: $('input[name="year"]').val(),
				detailId: <?php echo $taskData['info']->id; ?>
			};
			$.ajax({
				url: "<?php echo site_url('request/add_worker_to_task'); ?>",
				type: 'POST',
				data: values,
				success: function(data){
					if(data){
						$('<span />').text('Task updated succesfully').appendTo('#add_worker_msg');
						$('#add_worker_msg').fadeIn('800');
						$('#add_worker_text').val('');
					}
				}
			});
		}
		
		$('#add-prod').click(function(){
			$('#parts-list-parent > div').first().clone().appendTo('#parts-list-parent');;
		});
		
		$('#add-comment-form').submit(function(e){
			e.preventDefault();
			var values = {
				commentId: $('input[name="commentId"]').val(),
				text: $('textarea[name="admin_reply"]').val()
			};
			console.log(values.text.length);
			if(values.text.length > 1 && values.text != ''){
				$.ajax({
					url: "<?php echo site_url('request/admin_add_reply'); ?>",
					type: 'POST',
					data: values,
					success: function(data){
						if(data){
							$('<span />').text('Reply sent succesfully').appendTo('#add_reply_msg');
							$('#add_reply_msg').show();
								setTimeout(function(){
									$('#add_reply_msg').fadeOut('1000');
								}, 2000);
							$('textarea[name="admin_reply"]').val('');
						}
					}
				});
			}else{
				$('<span />').text('Reply must be at least 2 characters long').appendTo('#add_reply_msg');
				$('#add_reply_msg').show();
					setTimeout(function(){
						$('#add_reply_msg').fadeOut('1000');
					}, 2000);
				$('textarea[name="admin_reply"]').val('');
			}
		});
		
	});
</script>

    <hr />
  </div> <!-- End App Content -->
