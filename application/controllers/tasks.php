<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.');

class Tasks extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library( array('form_validation', 'session') );
		session_start();
	}

	public function single_task($wid, $rid)
	{
		if(empty($_SESSION['loggedIn']) || $_SESSION['userLevel'] != 'worker'){
			redirect('');
		}
		$this->load->model('worker_tasks_model');
		
		$data = array('title' => 'GPP Maintenance App', 'back' => 'account', 'name' => $_SESSION['name']);
		$data['main_content'] = 'worker/worker_task_details';
		$data['taskData'] = $this->worker_tasks_model->worker_get_single_task($wid, $rid);
		$data['workTypes'] = $this->worker_tasks_model->get_work_types();
		print_r($data['taskData']);
		$this->load->view('templates/template', $data);
	}
	
}
