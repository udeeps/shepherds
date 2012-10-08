<?php 
class Auth_model extends CI_Model
{
	
	public $authLevel;
	
	public function __construct()
	{
	
	}
	
	public function verify_user($email, $password)
	{	
		$q1 = $this->db
				->where('workerEmail', $email)
				->where('workerPwd', sha1($password) )
				->limit(1)
				->get('workers');
				
		$q2 = $this->db
				->where('adminEmail', $email)
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
	}
	
}
?>