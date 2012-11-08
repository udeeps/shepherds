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
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId ORDER BY repairRequests.dateRequested DESC';
		/*$this->db
		->select('repairrequests.*')
		->from('repairrequests, orderer, customers')
		->where('customers.customerUserName', $customerUserName)
		->where('customers.customerId=orderer.customerId' )
		->where('orderer.ordererId=repairrequests.ordererId');*/
		$q=$this->db->query($sql);
		return $q;
		/*if( $q->num_rows() > 0 )
		{
			//$requestarray = array( 'query' => $q->result());
			return $q;
		}
		else
		return FALSE;*/
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
		/*$this->db
		->select('repairrequests.*')
		->from('repairrequests, orderer, customers')
		->where('customers.customerUserName', $customerUserName)
		->where('customers.customerId=orderer.customerId' )
		->where('orderer.ordererId=repairrequests.ordererId');*/
		$q=$this->db->query($sql);
		return $q;
	}
	
}