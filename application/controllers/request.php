<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');

class Request extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library( array('form_validation', 'session') );
		$this->load->model('request_model');
		$this->load->model('comment_model');
		session_start();
	}

	public function index($task = '')
	{
		if( !isset($_SESSION['loggedIn']) || $_SESSION['userLevel'] != 'admin')
		{
			redirect('login');
		}

		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);

		$config = array(
		array('field' => 'type_maintenance','label' => 'Maintenance type','rules' => 'required'),
		array('field' => 'customer_name','label' => 'Customer name','rules' => 'required'),
		array('field' => 'billing_address','label' => 'Billing address','rules' => 'required'),
		array('field' => 'orderer_of_work','label' => 'Orderer','rules' => 'required'),
		array('field' => 'task_title','label' => 'Task title','rules' => 'required'),
		array('field' => 'day','label' => 'Start day','rules' => 'numeric'),
		array('field' => 'month','label' => 'Start month','rules' => 'numeric'),
		array('field' => 'year','label' => 'Start year','rules' => 'numeric'),
		array('field' => 'work_description','label' => 'Description','rules' => 'required'),
		array('field' => 'assigned_employees','label' => 'Assignees','rules' => 'callback_check_worker')
		);

		$this->form_validation->set_rules($config);

		if($this->form_validation->run() !== FALSE)
		{
			//verifying "add task" post array
			$result = $this->request_model->create_repair_request( $this->input->post() );

			if($result){
				$data['msg'] = 'Incorrect orderer name';
				$this->load->view('request/admin_add_task_view', $data);
			}else{
				$data['msg'] = 'Request saved succesfully';
				$this->load->view('request/admin_add_task_view', $data);
			}
		}

		switch($task)
		{
			case 'add_task':
				$this->load->view('request/admin_add_task_view', $data);
				break;
			case 'list_tasks':
				$data['taskList'] = $this->request_model->get_requests();
				//print_r($data['taskList']);
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

	public function check_worker($str)
	{
		$str = trim($str);
		if(preg_match('/^[a-zA-ZåäöÅÄÖ,\s]+$/', $str)){
			return TRUE;
		}else if($str == ''){
			return TRUE;
		}else{
			return FALSE;
		}
	}

	//public function get_single_task($taskId='',$errmsg='',$successmsg='')
	public function get_single_task($taskId='')
	{
		if($taskId=='')
		redirect('404_override');
		$this->checkSession();
		$this->form_validation->set_rules('feedbackbox', 'Comment', 'required|min_length[2]|max_length[200]|xss_clean');
		$this->form_validation->set_rules('author', 'Name', 'required|min_length[2]|max_length[40]|xss_clean');
		//this information is only for customer
		if($_SESSION['userLevel'] == 'customer')
		{
			
				if ($this->form_validation->run() != FALSE)
				{
					
					$status = $this->comment($taskId,$this->input->post('feedbackbox'),$this->input->post('author'));
					$data['status']=$status;
				}




			$data['result'] = $this->request_model->get_request_detail($taskId);
			//if user tries different taskId other than we have in database, 404 overide
			if($data['result'] == FALSE)
			redirect('404_override');
			else
			{
				$data['customerName']=$_SESSION['customerName'];
				$data['title']='GPP Maintenance App';
				$data['comments'] = $this->comment_model->get_comments($taskId);
			
				$this->load->view('request/customer_task_details',$data);
			}


		}

	}

	public function checkSession()
	{
		// if user is not logged in, redirect to homepage
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
		{ redirect(''); }

	}


	public function comment($taskId,$comment,$author)
	{

		$result = $this->comment_model->addComment($taskId,$comment,$author);
		$status['errormsg']='';
		$status['successmsg']='';
		if($result == 'NO_RECORDS')
		redirect('404_override');
		
		elseif($result == 'MULTIPLE_RECORDS')
		{
			$status['errormsg']='Multiple records found in database, contact web admnistrator';
			return($status);
		}
		elseif($result=='INSERT_FAILED')
		{
			$status['errormsg']='Comments Not Saved. Try again later';
			return($status);
		}
		elseif($result=='SUCCESS')
		{
			$status['successmsg']="Comment Saved";
			return($status);
		}
		else
		{
			$status['errormsg']='Unknown error. Notify web administrator';
			return($status);
		}

	}



}
