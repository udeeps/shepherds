<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 
class Request_model extends CI_Model
{
	
	public function __construct()
	{
	
	}
	
	public function create_repair_request($postArray)
	{
		if(isset($postArray)){
			$type = $postArray['type_maintenance'];
			$c_name = $postArray['customer_name'];
			$billing = $postArray['billing_address'];
			$orderer = $postArray['orderer_of_work'];
			$address = $postArray['customer_address'];
			$title = $postArray['task_title'];
			$day = ($postArray['day']) ? $postArray['day'] : ''; 
			$month = ($postArray['month']) ? $postArray['month'] : '';
			$year = ($postArray['year']) ? $postArray['year'] : '';
			$desc = $postArray['work_description'];
			$assigned = $postArray['assigned_employees'];
			$requestStatusId;
			$ordererId;
			$dateAssigned = null;
			$workTypeId;
			
			//first get the ordererId by given name
			$q = $this->db->select('ordererId')
					->where('ordererName', $orderer)
					->limit(1)
					->get('orderer');
			//if not found, stop the insert and display error message to user
			if($q->num_rows() > 0){
				$ordererId = $q->row()->ordererId;
			}else{
				return FALSE;
			}
			
			if(!empty($day) && !empty($month) && !empty($year)) $dateAssigned = $year.'-'.$month.'-'.$day;
			
			//db sets requestStatusId to 1 by default. If start date is given, change request status to 2 -> "in_progress"
			/*
			
			IMPORTANT!!!! 
			MAKE COMPARISON THAT IF DATE ASSIGNED IS IN THE FUTURE, STATUS WILL STAY 1
			
			*/ 
			if(isset($dateAssigned)) $requestStatusId = '2';
			
			//get the work type
			$q2 = $this->db->select('workTypeId')
							->where('workTypeName', $type)
							->limit(1)
							->get('worktypes');
			
			if($q2->num_rows() > 0) $workTypeId = $q2->row()->workTypeId;
			
			//insert to db
			$this->db->insert('repairrequests', array('dateAssigned' => $dateAssigned, 'repairLocation' => $address, 'ordererId' => $ordererId, 'workTypeId' => $workTypeId));
			//get the AUTO_INCREMENTed ID of the repair request so we can use it to reference repair detail
			$requestId = mysql_insert_id();
			
			//update request status if needed
			if(isset($requestStatusId))
				$this->db->where('id', $requestId)->update('repairrequests', array('requestStatusId' => $requestStatusId));
			
			//create a new entry in repairdetail table based on the requestId
			$this->create_request_detail($requestId, $assigned);
		}
	}
	
	public function create_request_detail($requestId, $assigned)
	{
		$reqId = $requestId;
		$assignees = array();
		//if give, explode the string of workers to an array
		if(!empty($assigned)){
			$assigned = str_replace(", ", ",", $assigned);
			$assignees = explode(",", $assigned);
		}
		
		//on each iteration of the loop, check if array value is a worker name in db. if found, insert a new row to db
		if( count($assignees) > 0 ){
			foreach($assignees as $detail){
				$q = $this->db->select('workerId')
							->where('workerName', $detail)
							->limit(1)
							->get('workers');
							
				if($q->num_rows() > 0){
					$workerId = $q->row()->workerId;
					
					$this->db->insert('repairdetail', array('repairRequestId' => $reqId, 'workerId' => $workerId));
				}
			}
			return true;
		}else{
			$this->db->insert('repairdetail', array('repairRequestId' => $reqId));
			return true;
		}
	}
	
	public function get_requests()
	{
		$q1 = $this->db->select('repairrequests.id')->get('repairrequests');
	
		$rowdata;
		
		if($q1->num_rows() > 0 ){
			//get requests which have a worker assigned
			foreach($q1->result() as $row){
				$q2 = $this->db->select('rq.id, rq.dateRequested, rq.dateAssigned, w.workerName, rs.requestStatus, wt.workTypeName')
					->from('repairrequests rq, workers w, requeststatuses rs, worktypes wt')
					->join('repairdetail', 'repairdetail.repairRequestId = rq.id')
					->where('repairdetail.repairRequestId', $row->id)
					->where('w.workerId = repairdetail.workerId')
					->where('rs.requestStatusId = rq.requestStatusId')
					->where('wt.workTypeId = rq.workTypeId')
					->get();
				
				if($q2->num_rows() > 0){
					$rowdata[] = $q2->row();
				}
			}
			
			$q3 = $this->db->select('repairrequests.id,, repairrequests.dateRequested, repairrequests.dateAssigned, rs.requestStatus, wt.workTypeName')
						->from('repairdetail rd, requeststatuses rs, worktypes wt')
						->join('repairrequests', 'repairrequests.id = rd.repairRequestId')
						->where('rd.workerId IS NULL', '', FALSE)
						->where('rs.requestStatusId = repairrequests.requestStatusId')
						->where('wt.workTypeId = repairrequests.workTypeId')
						->get();
						
			if($q3->num_rows() > 0){
				foreach($q3->result() as $row){
					$rowdata[] = $row;
				}
			}
			
			return $rowdata;
		}
	}
	
}