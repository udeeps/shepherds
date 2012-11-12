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