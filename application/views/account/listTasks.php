<?php
if($requestlist->num_rows() > 0 )
{

	foreach ($requestlist->result() as $row)
	{
		echo
		('
			<a href="'.site_url("request/get_single_task/".$row->Id).'">
			<ul class="listing">
			<!-- Start single task listing -->
			<li class="panel">
			<h5>'.$row->title.' - added at '. $row->dateRequested.'</h5>
			<div class="row">
			<div class="two columns">'
			);

			echo('<p class="status '.$row->requestStatus.'">Status:<br>'.$row->requestStatus.'</p>');
			echo('
			</div>
			<div class="six columns"><strong>Description:</strong>
			<p>'.$row->description.'</p>
			<strong>Reported By: </strong>'.$row->ordererName.'
			</div>
			<div class="four columns"><strong>Starting time:</strong>
			<p>
			');

			if($row->dateAssigned!= NULL)
			echo($row->dateAssigned);
			else
			echo('Not assigned yet');


			echo('</p>
			</div>
			</div>
			</li>
			</ul>
			</a>
		');

	}

}
else
echo("You haven't registered any task yet");

?>