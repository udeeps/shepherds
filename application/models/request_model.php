<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');
class Request_model extends CI_Model
{

	public function __construct()
	{

	}

	public function create_repair_request($postArray)
	{

		if($_SESSION['userLevel']=='customer')
		{
			$customerq=$this->db->select('customerId')
							->where('customerName', $_SESSION['customerName'])
							->get('customers');
			$customerId	=$customerq->row()->customerId;
			if(isset($postArray)){
				$billing = $postArray['billing_address'];
				$orderer = $postArray['orderer_of_work'];
				$address = $postArray['address'];
				$title = $postArray['task_title'];
				$description = $postArray['work_description'];
				$ordererId;

				//first get the ordererId by given name
				$q = $this->db->select('ordererId')
				->where('ordererName', $orderer)
				->limit(1)
				->get('orderer');
				//if not found, stop the insert and display error message to user
				if($q->num_rows() < 1)
				{
					$returnmsg = FAlSE;
				}
				else
				{
					$ordererId = $q->row()->ordererId;
					
					$q1 = $this->db->select('id')
							->where('billingAddress', $billing)
							->limit(1)
							->get('billingAddresses');
					if($q1->num_rows() == 1)
						$billingId = $q1->row()->id;
					else
					{
						$this->db->insert('billingAddresses',array('billingAddress' => $billing,
									'customerId' => $customerId));
						$billingId = mysql_insert_id();
					}
					
							
					
					$data=  array('title' => $title,
									'billingAddressID'=>$billingId,
									'repairLocation' => $address, 
									'description' => $description, 
									'ordererId' => $ordererId);
					//insert to db
					if($this->db->insert('repairRequests',$data))
					{
						//get the AUTO_INCREMENTed ID of the repair request so we can use it to reference repair detail
						$requestId = mysql_insert_id();
						//create a new entry in repairDetail table based on the requestId
						$this->db->insert('repairDetail', array('repairRequestID' => $requestId));
						$returnmsg = TRUE;

					}
					else 
					$returnmsg = FALSE;

						
				}

			}
			return $returnmsg;
		}
		elseif($_SESSION['userLevel']=='admin')
		{
			if(isset($postArray)){
				$type = $postArray['type_maintenance'];
				$warranty = isset($postArray['warranty']) ? 1 : 0;
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
	}

	public function create_request_detail($requestId, $assigned, $details = '')
	{
		$success = 0;
		$assignees = array();
		//if give, explode the string of workers to an array
		if(!empty($assigned)){
			$assigned = str_replace(", ", ",", $assigned);
			$assignees = explode(",", $assigned);
		}

		//on each iteration of the loop, check if array value is a worker name in db.
		if( count($assignees) > 0 ){
			foreach($assignees as $name){
				$q = $this->db->select('workerId')
				->where('workerName', $name)
				->limit(1)
				->get('workers');
					
				if($q->num_rows() > 0){
					//if worker found, get the id
					$workerId = $q->row()->workerId;
					//check if worker id is NULL. If NULL, update the requestdetail to have the worker id. Otherwise create a new detail
					$detail_exists = $this->db->select('workerID')->where('id', $details['id'])->get('repairDetail');

					if( $detail_exists->num_rows() > 0){
						$success = $this->db->insert('repairDetail', array('repairRequestID' => $requestId, 'workerId' => $workerId));
					}else{
						$success = $this->db->where('id', $details['id'])->update('repairDetail', array('workerID' => $workerId));
					}
					//change status to "in_progress" if forst worker assigned and status is "recorded"
					$status = $this->db->select('requestStatusId')->where('Id', $requestId)->get('repairRequests')->row()->requestStatusId;
					if($status == '1'){
						$this->db->where('Id', $requestId)->update('repairRequests', array('requestStatusId' => '2'));
						$this->update_finish_date($requestId, $details);
					}
				}else{
					return $success;
				}
			}
			return $success;
		}else{
			if(!empty($details)){
				$success = $this->update_finish_date($requestId, $details);
				return $success;
			}
			$this->db->insert('repairDetail', array('repairRequestId' => $requestId));
		}
	}
	
	public function update_finish_date($requestId, $details)
	{
		$the_date = $details['year'].'-'.$details['month'].'-'.$details['day'];
		return $this->db->where('Id', $requestId)->update('repairRequests', array('estimatedDateFinish' => $the_date));
	}
	
	public function get_requests($sort_by = 'requestStatus')
	{
		//get all request id's
		$q = $this->db->select('repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.title, rr.description, rr.repairLocation, 
								requestStatuses.requestStatus, workTypes.workTypeName, workers.workerName, customers.customerName, orderer.ordererName')
					->from('repairRequests rr')
					->join('repairDetail', 'rr.Id = repairDetail.repairRequestID')
					->join('workers', 'repairDetail.workerID = workers.workerId', 'left outer')
					->join('requestStatuses', 'rr.requestStatusId = requestStatuses.requestStatusId')
					->join('workTypes', 'rr.workTypeId = workTypes.workTypeId')
					->join('orderer', 'rr.ordererId = orderer.ordererId')
					->join('customers', 'customers.customerId = orderer.customerId')
					->group_by('repairDetail.repairRequestId')
					->order_by($sort_by, 'desc')
					->get();
		
		if($q->num_rows() > 0 ){
			return $q->result();
		}
	}

	public function get_requests_by_status($status)
	{
		$q = $this->db->select('repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.title, rr.description, rr.repairLocation, 
								requestStatuses.requestStatus, workTypes.workTypeName, workers.workerName, customers.customerName, orderer.ordererName')
		->from('repairRequests rr')
		->join('repairDetail', 'rr.Id = repairDetail.repairRequestID')
		->join('workers', 'repairDetail.workerID = workers.workerId', 'left outer')
		->join('requestStatuses', 'rr.requestStatusId = requestStatuses.requestStatusId')
		->join('workTypes', 'rr.workTypeId = workTypes.workTypeId')
		->join('orderer', 'rr.ordererId = orderer.ordererId')
		->join('customers', 'customers.customerId = orderer.customerId')
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
		$q = $this->db->select('rr.warranty, repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.title, rr.description, rr.estimatedDateFinish, 
								requestStatuses.requestStatus, workTypes.workTypeName, orderer.ordererName, customers.customerName')
		->from('repairRequests rr')
		->join('repairDetail', 'rr.Id = repairDetail.repairRequestID')
		->join('requestStatuses', 'rr.requestStatusId = requestStatuses.requestStatusId')
		->join('workTypes', 'rr.workTypeId = workTypes.workTypeId')
		->join('orderer', 'rr.ordererId = orderer.ordererId')
		->join('customers', 'customers.customerId = orderer.customerId')
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

	public function update_request($post_array)
	{
		if(isset($post_array)){
			$type_maintenance = $post_array['type_maintenance'];
			$warranty = isset($post_array['warranty']) ? 1 : 0;
			$c_name = $post_array['customername'];
			$b_address = $post_array['billingaddress'];
			$orderer = isset($post_array['orderer']) ? $post_array['orderer'] : '';
			$phone = $post_array['customerphone'];
			$email = $post_array['customeremail'];
			$title = $post_array['tasktitle'];
			$desc = $post_array['taskdescription'];
			$actions = $post_array['taskactions'];
			$w_hours = $post_array['workhours'];
			$d_hours = $post_array['drivehours'];
			$km_comp = $post_array['kmcompensation'];
			$totalwork = $post_array['totalworkcost'];
			$prod_codes = $post_array['prod_code'];
			$prod_descriptions = $post_array['prod_desc'];
			$prod_quantity = $post_array['prod_quantity'];
			$prod_ordered = $post_array['prod_ordered'];
			$prod_price = $post_array['prod_price'];
			$prod_total = $post_array['prod_total'];
			$total = $post_array['total'];
			
			$typeId = $this->db->select('workTypeId')
				->where('workTypeName', $type_maintenance)
				->limit(1)
				->get('workTypes')->row()->workTypeId;
			
			if(!empty($orderer)){
				$ordererId = $this->db->select('ordererId')
					->where('ordererName', $orderer)
					->limit(1)
					->get('orderer')->row()->ordererId;
			}		
			return true;
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