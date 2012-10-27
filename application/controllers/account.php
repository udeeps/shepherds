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
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
		{ redirect(''); }
		//if($_SESSION['loggedIn'] != true){ redirect(''); }
		
		switch($_SESSION['userLevel'])
		{
			case 'admin':
				$data = array('title' => 'GPP Maintenance App', 'name' => $_SESSION['name'], 'email' => $_SESSION['email']);
				$this->load->view('account/admin_account_view', $data);
				break;
			case 'worker':
				$data = array('title' => 'GPP Maintenance App', 'name' => $_SESSION['name'], 'email' => $_SESSION['email']);
				$this->load->view('account/worker_account_view', $data);
				break;
			case 'customer':
				
				//$data = array('title' => 'GPP Maintenance App', 'name' => $_SESSION['name'], 'customerName' => $_SESSION['customerName']);
				$data['title']='GPP Maintenance App';
				$data['customerName']=$_SESSION['customerName'];
				//$data = array('title' => 'GPP Maintenance App', 'customerName' => $_SESSION['customerName']);
				$this->load->model('customer_account');
				$data['requestlist'] = $this->customer_account->get_acccount_data($_SESSION['customerUserName']);
				
				$this->load->view('account/customer_account_view', $data);
				break;
		}
	}


	
}

