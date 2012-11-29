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

	public function index()
	{


		if( !isset($_SESSION['loggedIn'])||($_SESSION['userLevel'] != 'admin'&&$_SESSION['userLevel'] != 'customer'))
		{
			redirect('login');
		}

		else if($_SESSION['userLevel'] == 'admin')
		{
			$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);

			$data['main_content'] = 'request/admin_add_task_view';
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
				}else{
					$data['msg'] = 'Request saved succesfully';
				}
			}
			$this->load->view('templates/template', $data);
		}

		else if($_SESSION['userLevel'] == 'customer')
		{
			$data = array( 'title' => 'GPP Maintenance App','back' => 'account', 'customerName' => $_SESSION['customerName']);
			$data['main_content'] = 'request/customer_add_task_view';
			$config = array(
			array('field' => 'billing_address','label' => 'Billing address','rules' => 'required'),
			array('field' => 'orderer_of_work','label' => 'Orderer','rules' => 'required'),
			array('field' => 'task_title','label' => 'Task title','rules' => 'required'),
			array('field' => 'work_description','label' => 'Description','rules' => 'required'),
			);

			$this->form_validation->set_rules($config);

			if($this->form_validation->run() !== FALSE)
			{
				//verifying "add task" post array
				$result = $this->request_model->create_repair_request( $this->input->post() );

				if($result){
					$data['msg'] = 'Request saved succesfully';
					$to      = 'shakydeep@gmail.com';
					$subject = 'New Task added in GPP maintanence app';
					$message = 'A new Task has been added by '.$_SESSION['customerName'].' in GPP maintanence app';
					$headers = 'From: GPP maintanence App' . "\r\n" .'X-Mailer: PHP/' . phpversion();
					ini_set ( "SMTP", "smtp-server.example.com" );
					ini_set ( "smtp_port", "25" );  
					date_default_timezone_set('Europe/Helsinki');
					mail($to, $subject, $message, $headers);
					//$this->load->view('templates/template', $data);
				}else{
					$data['msg'] = 'Incorrect orderer name. Report not Saved';
				}
			}
			$this->load->view('templates/template', $data);
		}
		else
		{
			redirect('');
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

	public function list_tasks($sort_by = '')
	{
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		$data['main_content'] = 'request/admin_list_tasks_view';

		if($this->input->post('ajax')){
				$status = $this->input->post('statusName');
				if($status == 'requestStatus'){
					$data['taskList'] = $this->request_model->get_requests($status);
				}else{
					$data['taskList'] = $this->request_model->get_requests_by_status($status);
				}
				$this->load->view($data['main_content'], $data);
		}else{
			$data['taskList'] = $this->request_model->get_requests();
			$this->load->view('templates/template', $data);
		}
	}

	public function single_task($r_id, $data = '')
	{
		$data = array('title' => 'GPP Maintenance App', 'back' => 'request/list_tasks', 'name' => $_SESSION['name']);
		$data['main_content'] = 'request/admin_task_details';
		$data['taskData'] = $this->request_model->get_single_request($r_id);
		$data['workTypes'] = $this->request_model->get_work_types();
		$data['statusTypes'] = $this->request_model->get_status_types();

		$this->load->view('templates/template', $data);
	}

	public function change_status()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		if($this->request_model->change_status($id, $status)){
			echo true;
		}else{
			echo false;
		}
	}

	public function remove_from_task($r_id = '', $w_id = '')
	{
		$data = array();

		if($this->input->post('ajax')){
			$r_id = $this->input->post('task');
			$w_id = $this->input->post('worker');
			if( $this->request_model->remove_worker_from_task($r_id, $w_id) ){
				echo true;
			}else{
				echo false;
			}
		}else{
			if( $this->request_model->remove_worker_from_task($r_id, $w_id) ){
				$data['msg'] = 'Worker removed succesfully';
			}else{
				$data['msg'] = 'Remove failed for some reason';
			}
			$this->single_task($r_id, $data);
		}
	}

	public function add_worker_to_task()
	{
		$requestId = $this->input->post('requestId');
		$assignees = $this->input->post('assignees');
		$detailId = $this->input->post('detailId');

		$result = $this->request_model->create_request_detail($requestId, $assignees, $detailId);
		echo $result;
	}

	public function manage_users()
	{
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		$data['main_content'] = 'request/admin_manage_users_view';
		$this->load->view('templates/template', $data);
	}

	public function add_user()
	{	
		// AUTH!!!!!!!!!!!
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		$data['main_content'] = 'request/admin_add_user_view';
		
		$config = array(
			array('field' => 'firstname','label' => 'First name','rules' => 'required'),
			array('field' => 'lastname','label' => 'Last name','rules' => 'required'),
			array('field' => 'email','label' => 'Email','rules' => 'required|valid_email|is_unique[workers.workerEmail]'),
			array('field' => 'password','label' => 'Password','rules' => 'required|min_length[8]|matches[pass_conf]'),
			array('field' => 'pass_conf','label' => 'Password conf','rules' => 'required'),
			array('field' => 'userlevel','label' => 'User level','rules' => 'required'),
		);
		
		$this->form_validation->set_rules($config);
		
		if( $this->form_validation->run() !== FALSE ){
			$this->load->model('user_model');
			$userlevel = $this->user_model->add_new_user($this->input->post());
			if($userlevel){
				$data['msg'] = "A new user of level \"$userlevel\" added succesfully";
			}else{
				$data['msg'] = "Something went wrong. Data not saved";
			}
			$this->load->view('templates/template', $data);
		}
		
		$this->load->view('templates/template', $data);
	}
	
	public function system_announcements()
	{
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		$data['main_content'] = 'request/admin_system_announcements_view';
		$this->load->view('templates/template', $data);
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
				$data['main_content'] = 'request/customer_task_details_view';
				$this->load->view('templates/template', $data);
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
		elseif($result=='DUPLICATE')
		{
			return($status);
		}
		else
		{
			$status['errormsg']='Unknown error. Notify web administrator';
			return($status);
		}

	}



}
