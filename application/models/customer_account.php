<?php
class Customer_account extends CI_Model
{


	public function __construct()
	{

	}

	public function get_acccount_data($customerUserName)
	{
	
		//select all the maintenance request of the particular company 
		$sql = 'SELECT 
		repairRequests.*, requestStatuses.requestStatus, orderer.ordererName 
		FROM repairRequests, orderer, customers, requestStatuses 
		WHERE customers.customerUserName = "'.$customerUserName.'" 
		AND orderer.customerId = customers.customerId 
		AND repairRequests.ordererId = orderer.ordererId
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId ORDER BY repairRequests.dateRequested DESC,
		CAST(repairRequests.dateRequested AS DATE)';
		$q=$this->db->query($sql);
		return $q;
		
	}

	public function get_list_by_status($customerUserName)
	{
		$sql = 'SELECT 
		repairRequests.*, requestStatuses.requestStatus, orderer.ordererName 
		FROM repairRequests, orderer, customers, requestStatuses 
		WHERE customers.customerUserName = "'.$customerUserName.'" 
		AND orderer.customerId = customers.customerId 
		AND repairRequests.ordererId = orderer.ordererId
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId ORDER BY repairRequests.requestStatusId ASC';
		$q=$this->db->query($sql);
		return $q;
	}
	
}