<?php
class Comment_model extends CI_Model
{


	public function __construct()
	{


	}


	public function get_comments($taskId)
	{
		$q = $this->db->get_where('comments', array('repairRequestId' => $taskId,'private'=>0));
		if($q->num_rows<1)
		$comments = 'EMPTY';
		else
		foreach($q->result() as $row)
		$comments[] = $row;
		return $comments;
	}

	public function addComment($taskId,$comment,$author)
	{
		$sql = 'SELECT
		customers.customerName
		FROM repairRequests, orderer, customers
		WHERE repairRequests.Id = '.$taskId.'
		AND repairRequests.ordererId = orderer.ordererId
		AND orderer.customerId = customers.customerId';

		$q=$this->db->query($sql);
		if($q->num_rows<1)
		return 'NO_RECORDS';
		elseif($q->num_rows>1)
		return 'MULTIPLE_RECORDS';
		else
		{
			if($q->row()->customerName !=$_SESSION['customerName'])
			{
				redirect('account');
			}
			else
			{
				
				$data = array(
								   'author' => $author ,
								   'text' => $comment ,
								   'repairRequestId' => $taskId,
									'private'=>0
				);
				$q1= $this->db->get_where('comments',$data);
				if($q1->num_rows<1)
				{
					if($this->db->insert('comments', $data))
						return 'SUCCESS';
					else
						return 'INSERT_FAILED';
					
				}
				if($q1->num_rows==1)
					return('DUPLICATE');

			}
		}
	}

}
