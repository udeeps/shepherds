<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 

class Account extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library( array('form_validation', 'session') );
		session_start();
	}
	
	public function index()
	{
		if($_SESSION['loggedIn'] != true){ redirect('login'); }
		
		switch($_SESSION['userLevel'])
		{
			case 'admin':
				$this->load->view('account/account_view');
				break;
			case 'worker':
				echo 'worker';
				break;
			case 'customer':
				print_r($_SESSION);
				break;
		}
	}
}

?>