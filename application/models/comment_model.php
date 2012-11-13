<?php
class Comment_model extends CI_Model
{


	public function __construct()
	{


	}


	public function get_comments($taskId)
	{
		$q = $this->db->get_where('comments', array('repairRequestId' => $taskId));
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
								   'repairRequestId' => $taskId
				);
				if($this->db->insert('comments', $data))
				return 'SUCCESS';
				else
				return 'INSERT_FAILED';

			}
		}
	}

}

//SELECT yrityksen_toimihenkilot.henkilo_id, yritys.yritys_id, yritys.yritys_nimi FROM yrityksen_toimihenkilot INNER JOIN yritys on yrityksen_toimihenkilot.yritys_id = yritys.yritys_id WHERE yrityksen_toimihenkilot.kayttajatunnus = [TUNNUS] AND yrityksen_toimihenkilot.salasana = [SALASANA]

//SELECT yrityksen_toimihenkilot.henkilo_id, yritys.yritys_id, yritys.yritys_nimi FROM yrityksen_toimihenkilot, yritys WHERE yrityksen_toimihenkilot.yritys_id = yritys.yritys_id AND yrityksen_toimihenkilot.kayttajatunnus = [TUNNUS] AND yrityksen_toimihenkilot.salasana = [SALASANA]