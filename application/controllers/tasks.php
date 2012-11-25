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

	public function single_task($r_id, $data = '')
	{
		$data = array('title' => 'GPP Maintenance App', 'back' => 'request/list_tasks', 'name' => $_SESSION['name']);
		$data['main_content'] = 'request/admin_task_details';
		$data['taskData'] = $this->request_model->get_single_request($r_id);
		$data['workTypes'] = $this->request_model->get_work_types();
		$data['statusTypes'] = $this->request_model->get_status_types();
		//print_r($data['taskData']);
		$this->load->view('templates/template', $data);
	}
	
}
