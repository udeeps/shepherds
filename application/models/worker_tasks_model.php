<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');
class Worker_tasks_model extends CI_Model
{

	public function __construct()
	{

	}
	
	public function get_tasks_by_id($wid)
	{
		//get all tasks for worker id == $wid
		$q = $this->db->select('repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.estimatedDateFinish, rr.title,
								rr.description, requestStatuses.requestStatus, workTypes.workTypeName, workers.workerName, customers.customerName, orderer.ordererName')
					->from('repairRequests rr, requestStatuses, workTypes, workers, orderer, customers')
					->join('repairDetail', 'repairDetail.workerID = workers.workerId', 'left outer')
					->where('rr.Id = repairDetail.repairRequestID')
					->where('rr.requestStatusId = requestStatuses.requestStatusId')
					->where('rr.workTypeId = workTypes.workTypeId')
					->where('workers.workerId', $wid)
					->where('rr.ordererId = orderer.ordererId')
					->where('customers.customerId = orderer.customerId')
					->get();
		
		if($q->num_rows() > 0 ){
			return $q->result();
		}
	}
	
	
}