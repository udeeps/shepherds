<?php 
class Auth_model extends CI_Model
{
	
	public $authLevel;
	
	public function __construct()
	{
	
	}
	
	public function verify_user($credential, $password, $loginType)
	{	
		if($loginType == '1'){
			$q1 = $this->db
					->where('workercredential', $credential)
					->where('workerPwd', sha1($password) )
					->limit(1)
					->get('workers');
					
			$q2 = $this->db
					->where('admincredential', $credential)
					->where('adminPwd', sha1($password) )
					->limit(1)
					->get('admins');
									
			if( $q1->num_rows() > 0 )
			{
				$authLevel = array('userLevel' => 'worker', 'query' => $q1->row());
				return $authLevel;
			}else if( $q2->num_rows() > 0 )
			{
				$authLevel = array('userLevel' => 'admin', 'query' => $q2->row());
				return $authLevel;
			}
			return false;
		}else{
			$this->db->select('orderer.ordererName, customers.customerId, customers.customerName')
				->from('orderer')
				->join('customers', 'orderer.customerId = customers.customerId')
				->where('ordererEmail', $credential)
				->where('ordererPwd', sha1($password) )
				->limit(1);
					
			$q = $this->db->get();
			
			if( $q->num_rows() > 0 )
			{
				$authLevel = array('userLevel' => 'customer', 'query' => $q->row());
				return $authLevel;
			}
			return false;
		}
	}
	
}

//SELECT yrityksen_toimihenkilot.henkilo_id, yritys.yritys_id, yritys.yritys_nimi FROM yrityksen_toimihenkilot INNER JOIN yritys on yrityksen_toimihenkilot.yritys_id = yritys.yritys_id WHERE yrityksen_toimihenkilot.kayttajatunnus = [TUNNUS] AND yrityksen_toimihenkilot.salasana = [SALASANA]

//SELECT yrityksen_toimihenkilot.henkilo_id, yritys.yritys_id, yritys.yritys_nimi FROM yrityksen_toimihenkilot, yritys WHERE yrityksen_toimihenkilot.yritys_id = yritys.yritys_id AND yrityksen_toimihenkilot.kayttajatunnus = [TUNNUS] AND yrityksen_toimihenkilot.salasana = [SALASANA]