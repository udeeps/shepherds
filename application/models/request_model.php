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
			$warranty = ($postArray['warranty']) ? 1 : 0;
			$c_name = $postArray['customer_name'];
			$billing = $postArray['billing_address'];
			$orderer = $postArray['orderer_of_work'];
			$address = $postArray['customer_address'];
			$title = $postArray['task_title'];
			$description = $postArray['work_description'];
			$day = ($postArray['day']) ? $postArray['day'] : '';
			$month = ($postArray['month']) ? $postArray['month'] : '';
			$year = ($postArray['year']) ? $postArray['year'] : '';
			$desc = $postArray['work_description'];
			$assigned = $postArray['assigned_employees'];
			$requestStatusId;
			$ordererId;
			$dateToFinish = null;
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

			if(!empty($day) && !empty($month) && !empty($year)) $dateToFinish = $year.'-'.$month.'-'.$day;

			//db sets requestStatusId to 1 by default. If start date is given, change request status to 2 -> "in_progress"
			if(isset($dateToFinish)) $requestStatusId = '2';

			//get the work type
			$q2 = $this->db->select('workTypeId')
			->where('workTypeName', $type)
			->limit(1)
			->get('workTypes');

			if($q2->num_rows() > 0) $workTypeId = $q2->row()->workTypeId;

			//insert to db
			$this->db->insert('repairRequests', array('estimatedDateFinish' => $dateToFinish, 
													'title' => $title, 
													'repairLocation' => $address, 
													'description' => $description, 
													'ordererId' => $ordererId, 
													'workTypeId' => $workTypeId,
													'warranty' => $warranty
													));
			//get the AUTO_INCREMENTed ID of the repair request so we can use it to reference repair detail
			$requestId = mysql_insert_id();

			//update request status if needed
			if(isset($requestStatusId))
			$this->db->where('Id', $requestId)->update('repairRequests', array('requestStatusId' => $requestStatusId));

			//create a new entry in repairDetail table based on the requestId
			$this->create_request_detail($requestId, $assigned);
		}
	}

	public function create_request_detail($requestId, $assigned, $detailId = '')
	{
		$assignees = array();
		//if give, explode the string of workers to an array
		if(!empty($assigned)){
			$assigned = str_replace(", ", ",", $assigned);
			$assignees = explode(",", $assigned);
		}

		//on each iteration of the loop, check if array value is a worker name in db.
		if( count($assignees) > 0 ){
			$success;
			foreach($assignees as $name){
				$q = $this->db->select('workerId')
				->where('workerName', $name)
				->limit(1)
				->get('workers');
					
				if($q->num_rows() > 0){
					//if worker found, get the id
					$workerId = $q->row()->workerId;
					//check if worker id is NULL. If NULL, update the requestdetail to have the worker id. Otherwise create a new detail
					$q_if_null = $this->db->select('workerID')->where('id', $detailId)->get('repairDetail')->row()->workerID;
					$status = $this->db->select('requestStatusId')->where('Id', $requestId)->get('repairRequests')->row()->requestStatusId;
					if( $q_if_null == null ){
						$success = $this->db->where('id', $detailId)->update('repairDetail', array('workerID' => $workerId));
					}else{
						$success = $this->db->insert('repairDetail', array('repairRequestID' => $requestId, 'workerId' => $workerId));
					}
					//change status to "in_progress" if forst worker assigned and status is "received"
					if($status == '1'){
						$this->db->where('Id', $requestId)->update('repairRequests', array('requestStatusId' => '2'));
					}
				}
			}
			return $success;
		}else{
			$this->db->insert('repairDetail', array('repairRequestId' => $requestId));
		}
	}
	
	public function get_requests($sort_by = 'dateRequested')
	{
		//get all request id's
		$q = $this->db->select('repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.title, rr.description, 
								requestStatuses.requestStatus, workTypes.workTypeName, workers.workerName, customers.customerName, orderer.ordererName')
					->from('repairRequests rr')
					->join('repairDetail', 'rr.Id = repairDetail.repairRequestID')
					->join('workers', 'repairDetail.workerID = workers.workerId', 'left outer')
					->join('requestStatuses', 'rr.requestStatusId = requestStatuses.requestStatusId')
					->join('workTypes', 'rr.workTypeId = workTypes.workTypeId')
					->join('orderer', 'rr.ordererId = orderer.ordererId')
					->join('customers', 'customers.customerId = orderer.customerId')
					->order_by($sort_by, 'desc')
					->get();
		
		if($q->num_rows() > 0 ){
			return $q->result();
		}
	}
	
	public function get_requests_by_status($status)
	{
		$q = $this->db->select('repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.title, rr.description, 
								requestStatuses.requestStatus, workTypes.workTypeName, workers.workerName, ')
					->from('repairrequests rr')
					->join('repairDetail', 'rr.Id = repairDetail.repairRequestID')
					->join('workers', 'repairDetail.workerID = workers.workerId', 'left outer')
					->join('requestStatuses', 'rr.requestStatusId = requestStatuses.requestStatusId')
					->join('workTypes', 'rr.workTypeId = workTypes.workTypeId')
					->where('requestStatuses.requestStatus', $status)
					->order_by('dateRequested', 'desc')
					->get();
		
		if($q->num_rows() > 0 ){
			return $q->result();
		}
	}
	
	public function get_single_request($r_id)
	{	
		$rows = array();
		
		//get single request data
		$q = $this->db->select('rr.warranty, repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.title, rr.description, 
								requestStatuses.requestStatus, workTypes.workTypeName')
					->from('repairRequests rr')
					->join('repairDetail', 'rr.Id = repairDetail.repairRequestID')
					->join('requestStatuses', 'rr.requestStatusId = requestStatuses.requestStatusId')
					->join('workTypes', 'rr.workTypeId = workTypes.workTypeId')
					->where('rr.Id', $r_id)
					->get();
		
		$q2 = $this->db->select('workers.workerId, workerName')
					->from('repairDetail')
					->join('workers', 'workers.workerId = repairDetail.workerID')
					->where('repairDetail.repairRequestId', $r_id)
					->get();
					
		$rows['info'] = $q->row();
		
		if($q2->num_rows() > 0)
			$rows['workers'] = $q2->result();
		
		return $rows;
	}
	
	public function get_status_types()
	{
		$q = $this->db->select('requestStatus')->get('requestStatuses');
		return $q->result();
	}
	
	public function get_work_types()
	{
		$q = $this->db->select('workTypeName')->get('workTypes');
		return $q->result();
	}
	
	public function change_status($r_id, $status)
	{
		$q = $this->db->select('requestStatusId')
					->where('requestStatus', $status)
					->get('requestStatuses');
		
		$statusId = $q->row();
		
		$date = new DateTime('', new DateTimeZone('Europe/Helsinki'));

		if($status == 'completed'){
			$this->db->where('Id', $r_id)->update('repairRequests', array('dateFinished' => $date->format('Y-m-d H:i:s')));
			return $this->db->where('Id', $r_id)->update('repairRequests', array('requestStatusId' => $statusId->requestStatusId));
		}else{
			if( !empty( $this->db->select('dateFinished')->where('Id', $r_id)->get('repairRequests')->row()->dateFinished) ){
				$this->db->where('Id', $r_id)->update('repairRequests', array('dateFinished' => null));
			}
			
			return $this->db->where('Id', $r_id)->update('repairRequests', array('requestStatusId' => $statusId->requestStatusId));
		}
	}
	
	public function remove_worker_from_task($r_id, $w_id)
	{
		$length = count( $this->db->select('id')->where('repairRequestID', $r_id)->get('repairDetail')->result() );
		if($length > 1){
			return $this->db->where('repairRequestID', $r_id)
						->where('workerID', $w_id)
						->delete('repairDetail');
		}else{
			$data = array( 'workerID' => null );
			$this->db->where('Id', $r_id)->update('repairRequests', array('requestStatusId' => '1'));
			return	$this->db->where('repairRequestID', $r_id)
						->where('workerID', $w_id)
						->update('repairDetail', $data);
		}
	}
	
	public function get_request_detail($taskId)
	{

		// select basic infos which are obviously there for selected task
		$sql1 = 'SELECT
		repairRequests.*, 
		requestStatuses.requestStatus, 
		orderer.*,
		customers.customerName
		FROM repairRequests, orderer, customers, requestStatuses
		WHERE repairRequests.Id = '.$taskId.'
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId
		AND repairRequests.ordererId = orderer.ordererId
		AND orderer.customerId = customers.customerId';
		$q1=$this->db->query($sql1);
		if($q1->num_rows!=1)
		return FALSE;
		else
		$result['basicInfo'] = $q1->row();
		if($result['basicInfo']->customerName !=$_SESSION['customerName'])
				{
					redirect('account');
				}

		//select administrator info, I have assumed that there will on only
		//one adminstrator(maintainance head)
		$sql2 = 'SELECT
		 admins.adminName,admins.adminEmail,admins.adminPhone
		 FROM repairRequests, admins
		 WHERE repairRequests.Id = '.$taskId.'
		 AND repairRequests.adminedBy = admins.adminId';
		$q2=$this->db->query($sql2);
		if($q2->num_rows!=1)
		$result['adminInfo']= FALSE;
		else
		$result['adminInfo'] = $q2->row();


		//select worktype if it has been filled
		$sql3 = 'SELECT
		 workTypes.workTypeName
		 FROM repairRequests,workTypes
		 WHERE repairRequests.Id = '.$taskId.'
		 AND repairRequests.workTypeId = workTypes.workTypeId';
		$q3=$this->db->query($sql3);
		if($q3->num_rows!=1)
		$result['workTypeInfo'] = FALSE;
		else
		$result['workTypeInfo'] = $q3->row();


		// select workers info which may or might not be there for a task.
		$sql3 = 'SELECT
			 workers.workerName,workers.workerEmail,workers.workerPhone,
			 repairDetail.workingHours,repairDetail.actionsDone, repairDetail.levelOfWorker
			 FROM repairRequests,workers,repairDetail
			 WHERE repairRequests.Id = '.$taskId.'
			 AND repairDetail.repairRequestID = repairRequests.Id
			 AND repairDetail.workerID = workers.workerId';
		$q3=$this->db->query($sql3);
		if($q3->num_rows<1)
		$result['workersInfo']= FALSE;
		else
		{
			foreach($q3->result() as $row)
			{
				$result['workersInfo'][] = $row;
			}
		}

		//select information of items used
		$sql4 = 'SELECT
		items.itemName, itemsUsed.quantity
		FROM repairRequests,itemsUsed,items
		WHERE repairRequests.Id = '.$taskId.'
		AND itemsUsed.repairRequestId = repairRequests.Id
		AND items.itemID = itemsUsed.itemId';
		$q4=$this->db->query($sql4);
		if($q4->num_rows<1)
		$result['itemsInfo']= FALSE;
		else
		{
			foreach($q4->result() as $row)
			{
				$result['itemsInfo'][] = $row;
			}
		}

		return $result;

	}

}