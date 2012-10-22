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
				$data = array('name' => $_SESSION['name'], 'email' => $_SESSION['email']);
				$this->load->view('account/admin_account_view', $data);
				break;
			case 'worker':
				$data = array('name' => $_SESSION['name'], 'email' => $_SESSION['email']);
				$this->load->view('account/worker_account_view', $data);
				break;
			case 'customer':
				$data = array('name' => $_SESSION['name'], 'customerName' => $_SESSION['customerName']);
				$this->load->view('account/customer_account_view', $data);
				break;
		}
	}
	
	public function admin_add_task()
	{
		if( isset($_SESSION['loggedIn']) && $_SESSION['userLevel'] == 'admin')
		{
			redirect('request');
		}
	}
	
	public function admin_list_tasks()
	{
			
	}
	
	public function admin_add_customer()
	{
			
	}
	
	public function admin_manage_users()
	{
			
	}
	
	public function admin_system_anouncements()
	{
			
	}

	
}

?>