<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 
class Request_model extends CI_Model
{
	
	public function __construct()
	{
	
	}
	
	public function verify_task_data($postArray)
	{
		$type = $postArray['type_maintenance'];
		$c_name = $postArray['customer_name'];
		$billing = $postArray['billing_address'];
		$orderer = $postArray['orderer_of_work']; //later query 
		$address = $postArray['customer_address'];
		$title = $postArray['task_title'];
		$day = ($postArray['day']) ? $postArray['day'] : ''; //later db->set('date', 'TIMESTAMP()', FALSE)
		$month = ($postArray['month']) ? $postArray['month'] : '';
		$year = ($postArray['year']) ? $postArray['year'] : '';
		$desc = $postArray['work_description'];
		$assigned = $postArray['assigned_employees'];
		//$troubleshooting;
		$requestStatusId;
		$ordererId;
		$dateAssigned;
		$workTypeId;
		
		$q = $this->db->select('ordererId')
				->where('ordererName', $orderer)
				->limit(1)
				->get('orderer');
		
		if($q->num_rows() > 0) $ordererId = $q->row()->ordererId;
		
		if(!empty($day) && !empty($month) && !empty($year)) $dateAssigned = $year.'-'.$month.'-'.$day;
		
		if(isset($dateAssigned)) $requestStatusId = '2';
		
		$q2 = $this->db->select('workTypeId')
						->where('workTypeName', $type)
						->limit(1)
						->get('worktypes');
		
		if($q2->num_rows() > 0) $workTypeId = $q2->row()->workTypeId;
		
		$this->db->insert('repairrequests', array('dateAssigned' => $dateAssigned, 'repairLocation' => $address, 'ordererId' => $ordererId, 'workTypeId' => $workTypeId));
		$requestId = mysql_insert_id();
		
		if(isset($requestStatusId))
			$this->db->where('id', $requestId)->update('repairrequests', array('requestStatusId' => $requestStatusId));
			
		
	}
	
}