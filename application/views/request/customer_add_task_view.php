
<div class="row header"><!-- Start Header -->
<div class="five columns"><?php echo anchor('account', $customerName.' Maintenance');?>
</div>

<div class="four columns"><!-- Start search -->
<div class="row collapse">
<div class="eight mobile-three columns"><input type="text"
	placeholder="Search" /></div>
<div class="four mobile-one columns"><a href="#"
	class="postfix button expand gppbutton">Search</a></div>
</div>
Search for: <input type="radio" name="group2" value="Wine" checked>
Tasks <input type="radio" name="group2" value="Beer"> Users</div>
<!-- End search -->

<div class="three columns">
<p>Logged in as <?php echo $customerName; ?></p>
<p><?php echo anchor('login/log_out', 'Log out');?></p>
</div>
</div>
<!-- End Header -->

<div class="row content"><!-- Start App Content -->
<hr />
<div class="twelve columns "><!-- Start "breadcrumbs" -->
<p><?php echo anchor($back, 'Previous page');?></p>
<h3>Report/task management</h3>
<hr />
<!-- End "breadcrumbs" --> <?php if(isset($msg)): ?> <!-- Shows message if orderer name not found from DB -->
<div id="add_task_msg" class="twelve columns panel">
<h6><?php 
if ($msg == 'Request saved succesfully')
echo ('<font color ="green">');
else
echo ('<font color ="red">');
?> <?php echo $msg.'</font>'; ?></h6>
</div>
<?php endif; ?>

<div class="twelve columns panel">
<h4>Add a new report/task</h4>

<div id="add_task_errors" class="twelve columns panel"><font color="red"><?php echo validation_errors(); ?></font></div>

<?php echo form_open('request'); ?>


<div class="row">

<div class="six columns"><label>Billing address</label> <input
	type="text" placeholder="Start typing to choose from the list"
	name="billing_address" /></div>
</div>

<div class="row"><!-- Orderer info -->
<div class="six columns"><label>Address</label> <input type="text"
	placeholder="" name="address" /></div>
<div class="six columns"><label>Orderer of work (name)</label> <input
	type="text" placeholder="" id="orderer_of_work" name="orderer_of_work" />



</div>
</div>
<br />
<div class="row"><!-- Task title and description -->
<div class="eight columns"><label>Task title</label> <input type="text"
	placeholder="" name="task_title" /></div>

<div class="row">
<div class="twelve columns"><label>Description of the work</label> <textarea
	name="work_description" class="newannouncement" placeholder=""></textarea>
</div>
</div>



<div class="row"><!-- Submit button -->
<div class="twelve columns">
<hr />
<input type="submit" class="button gppbutton fullwidth"
	value="Add new report/task" name="submit" /></div>
</div>

<?php echo form_close(); ?></div>

<hr />
</div>
<!-- End App Content --> 
<script type="text/javascript">
$(function() {
        $( "#orderer_of_work" ).autocomplete({
        	source : function(request, response) {
            $.ajax({
                url : "<?php echo site_url('request/orderernames'); ?>",
                dataType : "json",
                data : {
                    term : request.term
                },
                success : function(data) {
                    return response(data);
                }
            });
        }
        });
});

    </script>