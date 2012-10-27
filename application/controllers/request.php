<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 

class Request extends CI_Controller
{
	
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

		$config = array(
				array('field' => 'type_maintenance','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'customer_name','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'billing_address','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'orderer_of_work','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'task_title','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'day','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'month','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'year','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'work_description','label' => 'Maintenance type','rules' => 'required'),
				array('field' => 'assigned_employees','label' => 'Maintenance type','rules' => 'required')
		);
		
		$this->form_validation->set_rules($config);
	
		if($this->form_validation->run() !== FALSE)
		{
			$this->load->model('request_model');
			$result = $this->request_model->verify_task_data( $this->input->post() );
			
			if($result)
				print_r($result);
		}
		
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		
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