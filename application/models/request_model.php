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
							->get('workTypes');
			
			if($q2->num_rows() > 0) $workTypeId = $q2->row()->workTypeId;
			
			//insert to db
			$this->db->insert('repairRequests', array('dateAssigned' => $dateAssigned, 'repairLocation' => $address, 'ordererId' => $ordererId, 'workTypeId' => $workTypeId));
			//get the AUTO_INCREMENTed ID of the repair request so we can use it to reference repair detail
			$requestId = mysql_insert_id();
			
			//update request status if needed
			if(isset($requestStatusId))
				$this->db->where('id', $requestId)->update('repairRequests', array('requestStatusId' => $requestStatusId));
			
			//create a new entry in repairDetail table based on the requestId
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
					
					$this->db->insert('repairDetail', array('repairRequestId' => $reqId, 'workerId' => $workerId));
				}
			}
			return true;
		}else{
			$this->db->insert('repairDetail', array('repairRequestId' => $reqId));
			return true;
		}
	}
	
	public function get_requests()
	{
		$q1 = $this->db->select('repairRequests.id')->get('repairRequests');
		
	
		$rowdata;
		
		if($q1->num_rows() > 0 ){
			//get requests which have a worker assigned
			foreach($q1->result() as $row){
				$q2 = $this->db->select('rq.id, rq.dateRequested, rq.dateAssigned, w.workerName, rs.requestStatus, wt.workTypeName')
					->from('repairRequests rq, workers w, requestStatuses rs, workTypes wt')
					->join('repairDetail', 'repairDetail.repairRequestId = rq.id')
					->where('repairDetail.repairRequestId', $row->id)
					->where('w.workerId = repairDetail.workerId')
					->where('rs.requestStatusId = rq.requestStatusId')
					->where('wt.workTypeId = rq.workTypeId')
					->get();
				
				if($q2->num_rows() > 0){
					$rowdata[] = $q2->row();
				}
			}
			
			$q3 = $this->db->select('repairRequests.id,, repairRequests.dateRequested, repairRequests.dateAssigned, rs.requestStatus, wt.workTypeName')
						->from('repairDetail rd, requestStatuses rs, workTypes wt')
						->join('repairRequests', 'repairRequests.id = rd.repairRequestId')
						->where('rd.workerId IS NULL', '', FALSE)
						->where('rs.requestStatusId = repairRequests.requestStatusId')
						->where('wt.workTypeId = repairRequests.workTypeId')
						->get();
						
			if($q3->num_rows() > 0){
				foreach($q3->result() as $row){
					$rowdata[] = $row;
				}
			}
			
			return $rowdata;
		}
	}
	
	public function get_request_detail($taskId)
	{
		
		$sql = 'SELECT 
		repairRequests.*, 
		requestStatuses.requestStatus, 
		orderer.*,
		customers.customerName
		
		FROM repairRequests, orderer, customers, requestStatuses
		
		WHERE repairRequests.Id = '.$taskId.'
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId
		AND repairRequests.ordererId = orderer.ordererId
		AND orderer.customerId = customers.customerId';
		/*$sql = 'SELECT 
		repairRequests.*, 
		requestStatuses.requestStatus, 
		orderer.*,
		customers.customerName,
		admins.adminName,admins.adminEmail,admins.adminPhone, 
		workers.workerName,workers.workerEmail,workers.workerPhone,
		workTypes.workTypeName,
		repairDetail.workingHours,repairDetail.actionsDone, repairDetail.levelOfWorker,
		items.itemName, itemsUsed.quantity
		
		FROM repairRequests, orderer, customers, requestStatuses,
		admins, workTypes,workers,repairDetail, itemsUsed,items
		
		WHERE repairRequests.Id = '.$taskId.'
		AND repairDetail.repairRequestID = '.$taskId.'
		AND repairDetail.workerID = workers.workerId
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId
		AND repairRequests.ordererId = orderer.ordererId
		AND repairRequests.adminedBy = admins.adminId
		AND repairRequests.workTypeId = workTypes.workTypeId
		AND orderer.customerId = customers.customerId';
		//AND itemsUsed.repairDetailId = repairDetail.Id
		//AND items.itemID = itemsUsed.itemId';
		 * 
		 */
		
		/* as itemsUsed has reference to only one of the repairDetail
		 * when it is combined in above sql,
		 * it gives only one result though there are more than one worker
		 * itesm Used should be fetched in a different sql statement
		 * repairDetail which belongs to the incharge worker 
		 * should be selected first to collect the items used
		 */
		//echo($sql."\n\n");
		$q=$this->db->query($sql);
		if($q->num_rows<1)
		return FALSE;
		else
		foreach($q->result() as $row){
					$result[] = $row;
				}
		//var_dump($result);
		return $result;
	}
	
}