<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');
class Auth_model extends CI_Model
{
	
	public $authLevel;
	
	public function __construct()
	{
	
	}
	
	public function verify_user($credential, $password, $loginType)
	{
		if( $loginType == '1' ){
			$q1 = $this->db
					->where('workerEmail', $credential)
					->where('workerPwd', sha1($password) )
					->limit(1)
					->get('workers');
					
			$q2 = $this->db
					->where('adminEmail', $credential)
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
			$this->db->select('customerId, customerName, companyEmail')
				->from('customers')
				->where('customerUserName', $credential)
				->where('customerPwd', sha1($password) )
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
