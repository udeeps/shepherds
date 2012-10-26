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
		AND repairRequests.requestStatusId = requestStatuses.requestStatusId';
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

}

//SELECT repairrequests.* FROM repairrequests, orderer, customers WHERE customers.customerUserName = "udeeps" AND orderer.customerId = customers.customerId AND repairrequests.ordererId = orderer.ordererId

//SELECT yrityksen_toimihenkilot.henkilo_id, yritys.yritys_id, yritys.yritys_nimi FROM yrityksen_toimihenkilot INNER JOIN yritys on yrityksen_toimihenkilot.yritys_id = yritys.yritys_id WHERE yrityksen_toimihenkilot.kayttajatunnus = [TUNNUS] AND yrityksen_toimihenkilot.salasana = [SALASANA]

//SELECT yrityksen_toimihenkilot.henkilo_id, yritys.yritys_id, yritys.yritys_nimi FROM yrityksen_toimihenkilot, yritys WHERE yrityksen_toimihenkilot.yritys_id = yritys.yritys_id AND yrityksen_toimihenkilot.kayttajatunnus = [TUNNUS] AND yrityksen_toimihenkilot.salasana = [SALASANA]