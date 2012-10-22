<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 

class Request extends CI_Controller
{
	
	//private $formType;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library( array('form_validation', 'session') );
		session_start();
	}
	
	public function index($task = '')
	{
		if( !isset($_SESSION['loggedIn']) || $_SESSION['userLevel'] != 'admin')
		{
			redirect('login');
		}
		
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		
		if($this->form_validation->run() !== FALSE)
		{
			
		}
		
		switch($task)
		{
			case 'add_task':
				$this->load->view('request/admin_add_task_view', $data);
			break;
			case 'list_tasks':
				$this->load->view('request/admin_list_tasks_view', $data);
			break;
			case 'manage_users':
				$this->load->view('request/admin_manage_users_view', $data);
			break;
			case 'system_anouncements':
				$this->load->view('request/admin_system_anouncements_view', $data);
			break;
			default:
				
			break;
		}	
	}
	
	public function get_single_task($taskId)
	{
		
	}

}
?>