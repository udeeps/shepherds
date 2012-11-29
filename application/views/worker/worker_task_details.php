
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
			<?php if($type->workTypeName != $taskData->workTypeName): ?>
				<input type="radio" name="type_maintenance" value="<?php echo $type->workTypeName ?>"> <?php echo ucfirst($type->workTypeName); ?> 
			<?php else: ?>
				<input type="radio" name="type_maintenance" value="<?php echo $type->workTypeName ?>" checked> <?php echo ucfirst($type->workTypeName); ?> 
			<?php endif; ?>
		<?php endforeach; ?>
		<span id="det-warranty"><input type="checkbox" name="warranty" <?php echo ($taskData->warranty) ? 'checked' : '' ;?>/> Warranty</span>
	</p>

  </div>
  <div class="five columns">
    <p id="status_bar" class="status <?php echo $taskData->requestStatus; ?>"><?php echo ucfirst(str_replace("_", " ", $taskData->requestStatus)); ?></p>
    
  </div>
</div>
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
          <input type="text" disabled="disabled" placeholder="" value="<?php echo $taskData->title;?>"/>
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
          <textarea name="description" disabled="disabled" class="descriptionform" placeholder=""><?php echo $taskData->description;?></textarea>
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

	});
</script>

    <hr />
  </div> <!-- End App Content -->
