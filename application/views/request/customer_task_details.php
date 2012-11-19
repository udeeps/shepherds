<div class="row header"><!-- Start Header -->
<div class="five columns"><?php 
echo anchor('account', $customerName.' Maintenance');
?></div>

<div class="four columns"><!-- Start search -->
<div class="row collapse">
<div class="eight mobile-three columns"><input type="text"
	placeholder="Search" /></div>
<div class="four mobile-one columns"><a href="#"
	class="postfix button expand gppbutton">Search</a></div>
</div>
</div>
<!-- End search -->

<div class="three columns">
<p>Logged in as <?php echo $customerName; ?></p>
<p><?php echo anchor('login/log_out', 'Log out'); ?></p>
</div>
</div>
<!-- End Header -->

<div class="row content"><!-- Start App Content -->
<hr />
<div class="twelve columns "><!-- Start "breadcrumbs" -->
<p><a href="<?php echo(site_url("account"));?>">&lArr; Back to task
listing</a></p>
<h4><?php echo($result['basicInfo']->title)?></h4>
<!-- End "breadcrumbs" -->

<ul class="details">
	<!-- Start detailed task info -->
	<li class="panel">
	<div class="row">
	<div class="two columns"><?php echo('<p class="status '.$result['basicInfo']->requestStatus.'">Status:<br>'.$result['basicInfo']->requestStatus.'</p>');?>
	</div>
	<div class="six columns">
	<p><b>What information can we give to customers?</b></p>
	<p><?php 
	echo("Request received on ".$result['basicInfo']->dateRequested."<br/>");
	echo("Location - ".$result['basicInfo']->repairLocation."<br/>");
	echo('<p><strong>Description: </strong>'.$result['basicInfo']->description.'</p>');
	if($result['workTypeInfo'] != FALSE)
	echo("Work Type - ".$result['workTypeInfo']->workTypeName."<br/>");
	?></p>
	<p><strong>Reported By: </strong><br />
	Name: <?php echo($result['basicInfo']->ordererName);?> <br />
	Email: <?php echo($result['basicInfo']->ordererEmail);?> <br />
	Phone No: <?php echo($result['basicInfo']->ordererPhone);?></p>

	<?php if($result['adminInfo']== FALSE)
	echo('<p><strong>No Administrator found for this request </strong></p>');
	else
	echo('<p><strong>Admined By: </strong><br />
	Name: '.$result['adminInfo']->adminName.' <br />
	Email:'.$result['adminInfo']->adminEmail.'<br />
	Phone No: '.$result['adminInfo']->adminPhone.'</p>');
	?> <?php if($result['workersInfo'] == FALSE)
	echo('<p><strong>No Workers assigned for this request yet </strong></p>');
	else
	{
		echo('<div><strong>Task Performed By: </strong>');
		foreach($result['workersInfo'] as  $row)
		{
			echo(
	'<p>Name: '.$row->workerName.'<br />
	Email: '.$row->workerEmail.'<br />
	Phone No: '.$row->workerPhone.'<br />
	Hours Worked: '.$row->workingHours.'<br/></p>');
		}
		echo('</div>');

		foreach($result['workersInfo'] as  $row)
		{
			if($row->levelOfWorker == 1)
			echo('<p><strong>Actions performed: </strong>'. $row->actionsDone.'</p>');
		}
	}

	?> <?php
	// information about items used
	if($result['itemsInfo'] != FALSE)
	{
		echo('<div><strong>Items used: </strong>');
		echo('
		<table>
		<tbody>
		<tr>
		<th>Name</th>
		<th>Quantity</th>
		</tr>
		');
		foreach($result['itemsInfo'] as  $row)
		echo('
			<tr>
			<td>'.$row->itemName.'</td>
			<td>'.$row->quantity.'</td>
			</tr>
			');
			
		echo('</tbody></table></div>');

	}

	?> <?php
	// Comments appear here
	if($comments != 'EMPTY')
	{
		echo('<div><strong>Comments: </strong>');
		echo('
		<table>
		<tbody>
		');
		foreach($comments as  $comment)
		echo('
			<tr>
			<td>'.$comment->text.'<br/>
			By '.$comment->author.' on '.$comment->date.'</td>
			</tr>
			');
			
		echo('</tbody></table>');
		if (isset($status))
		{
			if($status['errormsg']!='')
			echo ('<font color="red">'.$status['errormsg'].'</font>');
			if($status['successmsg']!='')
			echo ('<font color="green">'.$status['successmsg'].'</font>');
		}
		echo('</div>');

	}

	?>





	<div class="row"><!-- Start feedback box -->
	<hr />
	<div class="twelve columns"><font color="red"> <?php echo validation_errors(); ?>
	</font> <?php echo form_open();
	$commentField = array('id' => 'feedbackbox',
							'name' => 'feedbackbox',
							'class'=>"feedbackbox",
							'placeholder' => 'Comments and feedback regarding this task',
	'rows'=>2);
	$authorField = array('id' => 'author',
										'name' => 'author',
										'placeholder' => 'Your Name');
	$submit = array('name' => 'commentButton',
										'type' => 'submit',
										'value' => 'Send us your feedback',
										'class' => 'medium button gppbutton');
	echo('
	<label><strong>Comments</strong></label>
	'.form_textarea($commentField).form_input($authorField).form_submit($submit));
	echo form_close();
	?></div>
	</div>
	<!-- End feedback box --></div>
	<div class="two columns"><strong>Starting time:</strong>
	<p><?php if($result['basicInfo']->dateAssigned!= NULL)
	echo($result['basicInfo']->dateAssigned);
	else
	echo('Not assigned yet');?></p>
	</div>
	<div class="two columns"><strong>Estimated finish time:</strong>
	<p><?php if($result['basicInfo']->dateFinished!= NULL)
	echo($result['basicInfo']->dateFinished);
	else
	echo('Not predictable yet');?></p>
	</div>
	</div>
	</li>
</ul>
<!-- End detailed task info --></div>
<hr />
</div>
<!-- End App Content -->