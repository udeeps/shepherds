<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');
class Worker_tasks_model extends CI_Model
{

	public function __construct()
	{

	}
	
	public function get_tasks_by_wid($wid)
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
	
	public function worker_get_single_task($wid, $rid)
	{
		try{
			if($_SESSION['wid'] == $wid){
				$q = $this->db->select('rr.warranty, repairDetail.id, repairDetail.repairRequestId, rr.dateRequested, rr.estimatedDateFinish, rr.title,
								rr.description, requestStatuses.requestStatus, workTypes.workTypeName, workers.workerName, customers.customerName, orderer.ordererName')
					->from('repairRequests rr, requestStatuses, workTypes, workers, orderer, customers')
					->join('repairDetail', 'repairDetail.workerID = workers.workerId', 'left outer')
					->where('rr.Id', $rid)
					->where('repairDetail.repairRequestID', $rid)
					->where('rr.requestStatusId = requestStatuses.requestStatusId')
					->where('rr.workTypeId = workTypes.workTypeId')
					->where('workers.workerId', $wid)
					->where('rr.ordererId = orderer.ordererId')
					->where('customers.customerId = orderer.customerId')
					->limit(1)
					->get();
	
				if($q->num_rows() > 0 ){
					return $q->row();
				}
			}else{
				throw new Exception('Task details not available');
			}
		}catch(Exception $e){
			return $e->getMessage();
		}
	}
	
	public function get_work_types()
	{
		$q = $this->db->select('workTypeName')->get('workTypes');
		return $q->result();
	}
}