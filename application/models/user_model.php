<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');
class User_model extends CI_Model
{

	public function __construct()
	{

	}

	public function add_new_user($postArray)
	{
		if(isset($postArray)){
			$fname = $postArray['firstname'];
			$lname = $postArray['lastname'];
			$email = $postArray['email'];
			$password = $postArray['password'];
			$address = ($postArray['address']) ? $postArray['address'] : '';
			$zip = ($postArray['zip']) ? $postArray['zip'] : '';
			$city = ($postArray['city']) ? $postArray['city'] : '';
			$userlevel = $postArray['userlevel'];
			
			$q;
			
			switch($userlevel){
				case 'admin':
					$q = $this->db->insert('admins', array('adminEmail' => $email, 
														'adminPwd' => sha1($password), 
														'adminName' => $fname.' '.$lname, 
														'adminAddress' => $address.' '.$zip.' '.$city
														));
				break;
				case 'worker':
					$q = $this->db->insert('workers', array('workerEmail' => $email, 
														'workerPwd' => sha1($password), 
														'workerName' => $fname.' '.$lname, 
														'workerAddress' => $address.' '.$zip.' '.$city
														));
				break;
			}
			if($q){
				return $userlevel;
			}else{
				return false;
			}
		}
	}
}







