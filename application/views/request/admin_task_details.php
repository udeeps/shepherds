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
    <div class="twelve columns "> <!-- Start breadcrumbs and title -->
      <p><?php echo anchor($back, 'Previous page');?></p>
      <h3>Title with name and date of task and customer</h3> <hr /><!-- End breadcrumbs and title" -->
    </div>

    
<div class="row"> <!-- Start form -->
  <div class="twelve columns">
<form action="admin_task_listing.html">


<div class="row">
  <div class="seven columns">

    <p>
		<strong>Type of work:</strong>
		<?php foreach($workTypes as $type): ?>
			<?php if($type->workTypeName != $taskData['info']->workTypeName): ?>
				<input type="radio" name="type_maintenance" value="<?php echo $type->workTypeName ?>"> <?php echo ucfirst($type->workTypeName); ?> 
			<?php else: ?>
				<input type="radio" name="type_maintenance" value="<?php echo $type->workTypeName ?>" checked> <?php echo ucfirst($type->workTypeName); ?> 
			<?php endif; ?>
		<?php endforeach; ?>
	</p>

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
		<div class="row panel"> <!-- Workers assigned -->
          <h4>Assigned workers</h4>
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
          <div class="twelve columns">
            <label>Add workers</label>
            <input type="text" placeholder="Start writing to choose from list" />
          </div>
          <div class="twelve columns">
            <input type="button" class="button gppbutton fullwidth" value="Save worker info" />
          </div>
        </div>

        <hr />

        <div class="row panel">
          <h4>Customer information</h4>
          <div class="six columns"> <!-- Name -->
            <label>Customer name (company)</label>
            <input type="text" disabled="disabled" placeholder="Already here from CRM" />
          </div>
          <div class="six columns">
            <label>Billing address</label>
            <input type="text" disabled="disabled" placeholder="Already here from CRM" />
          </div>
        </div>


        <div class="row panel"><!-- Orderer info -->
          <div class="four columns">
            <label>Orderer of work (individual)</label>
            <input type="text" disabled="disabled" placeholder="Already here from HoM" />
          </div>
          <div class="four columns">
            <label>Phone number</label>
            <input type="text" disabled="disabled" placeholder="Already here from HoM" />
          </div>
          <div class="four columns">
            <label>Email address</label>
            <input type="text" disabled="disabled" placeholder="Already here from HoM" />
          </div>
        </div>
  
      <hr />

      <div class="row panel"><!-- Task title and description -->
        <h4>Task description</h4>
        <div class="eight columns">
          <label>Task title</label>
          <input type="text" disabled="disabled" placeholder="Already here from HoM" />
        </div>
        <div class="four columns">
          <label>Estimated start date</label>
          <div class="row">
            <div class="four columns">
              <input type="text" placeholder="Day" />
            </div>
            <div class="four columns">
              <input type="text" placeholder="Month" />
            </div>
            <div class="four columns">
              <input type="text" placeholder="Year" />
            </div>
          </div>
        </div>
      </div>

      <div class="row panel">
        <div class="twelve columns">
          <label>Description of assignment</label>
          <textarea name="description" disabled="disabled" class="descriptionform" placeholder="Already here from HoM"></textarea>
        </div>
      </div>


      <hr />

      <div class="row panel">
        <h4>What has been done</h4>
        <div class="twelve columns">
          <label>Actions taken on site</label>
          <textarea name="description" class="descriptionform" placeholder=""></textarea>
        </div>
      </div>

      <hr />

      <div class="row panel"><!-- Parts and prices -->
        <h4>Working time</h4>
        <div class="row>">
          <div class="three columns">
            <label>Working hours</label>
            <input type="text" placeholder="" />
          </div>
          <div class="three columns">
            <label>Driving hours</label>
            <input type="text" placeholder="" />
          </div>
          <div class="three columns">
            <label>Kilometer compensation</label>
            <input type="text" placeholder="" />
          </div>
          <div class="three columns">
            <label>Total</label>
            <input type="text" disabled="disabled" placeholder="Automatically counted" />
          </div>
          <hr />
        </div>

        <h4>Products and parts</h4>
        <div class="row"> <!-- Start line of product -->
          <div class="three columns">
            <label>Part product code - <a href="#">Show popular</a></label>
            <input type="text" placeholder="" />
          </div>
          <div class="four columns">
            <label>Description</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Quantity</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Ordered</label> 
            <select class="orderedornot">
              <option value="notordered">No</option>
              <option value="ordered">Yes</option>
            </select>
          </div>
          <div class="one columns">
            <label>á price</label>
            <input type="text" disabled="disabled" placeholder="CRM" />
          </div>
          <div class="two columns">
            <label>Total</label>
            <input type="text" disabled="disabled" placeholder="Automatic count" />
          </div> 
        </div> <!-- End line of product -->

        <div class="row"> <!-- Start line of product -->
          <div class="three columns">
            <label>Part product code - <a href="#">Show popular</a></label>
            <input type="text" placeholder="" />
          </div>
          <div class="four columns">
            <label>Description</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Quantity</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Ordered</label> 
            <select class="orderedornot">
              <option value="notordered">No</option>
              <option value="ordered">Yes</option>
            </select>
          </div>
          <div class="one columns">
            <label>á price</label>
            <input type="text" disabled="disabled" placeholder="CRM" />
          </div>
          <div class="two columns">
            <label>Total</label>
            <input type="text" disabled="disabled" placeholder="Automatic count" />
          </div> 
        </div> <!-- End line of product -->

        <div class="row"> <!-- Start line of product -->
          <div class="three columns">
            <label>Part product code - <a href="#">Show popular</a></label>
            <input type="text" placeholder="" />
          </div>
          <div class="four columns">
            <label>Description</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Quantity</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Ordered</label> 
            <select class="orderedornot">
              <option value="notordered">No</option>
              <option value="ordered">Yes</option>
            </select>
          </div>
          <div class="one columns">
            <label>á price</label>
            <input type="text" disabled="disabled" placeholder="CRM" />
          </div>
          <div class="two columns">
            <label>Total</label>
            <input type="text" disabled="disabled" placeholder="Automatic count" />
          </div> 
        </div> <!-- End line of product -->

        <div class="row"> <!-- Start line of product -->
          <div class="three columns">
            <label>Part product code - <a href="#">Show popular</a></label>
            <input type="text" placeholder="" />
          </div>
          <div class="four columns">
            <label>Description</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Quantity</label>
            <input type="text" placeholder="" />
          </div>
          <div class="one columns">
            <label>Ordered</label> 
            <select class="orderedornot">
              <option value="notordered">No</option>
              <option value="ordered">Yes</option>
            </select>
          </div>
          <div class="one columns">
            <label>á price</label>
            <input type="text" disabled="disabled" placeholder="CRM" />
          </div>
          <div class="two columns">
            <label>Total</label>
            <input type="text" disabled="disabled" placeholder="Automatic count" />
          </div> 
        </div> <!-- End line of product -->



          <div class="row"> <!-- Start total sum -->
            <div class="nine columns">
              <hr />
            </div>
            <div class="three columns">
              <label><strong>Total sum</strong></label>
              <input type="text" disabled="disabled" placeholder="Automatic count" />
            </div>
          </div> <!-- End total sum -->

      </div>

<div class="row panel">
<input type="submit" class="button gppbutton fullwidth" value="Save form">
</div>

</form>
  </div>
</div> <!-- End form -->
<script type="text/javascript">
	$(document).ready(function(){
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
						var stat = values.status;
						$('#status_bar').attr('class', 'status '+stat);
						if(stat.indexOf('_') != -1){
							stat = stat.replace('_', ' ');
						}
						var newstatus = stat.toLowerCase().replace(/^(.)/g, 
							function($1){ return $1.toUpperCase();
						});	
						$('#status_bar').text(newstatus);
					}
				}
			});
		});
		
		$('.w_remove').click(function(){
			var values = {
				task: <?php echo $this->uri->segment(3); ?>,
				worker: $(this).attr('href').substr($(this).attr('href').length - 1)
			};
			
			$.ajax({
				url: "<?php echo site_url('request/remove_from_task'); ?>",
				type: 'POST',
				success: function(data){
					if(data){
						alert('jee');
					}
				}
			});
			return false;
		});		
	});
</script>

    <hr />
  </div> <!-- End App Content -->
