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

		switch($_SESSION['userLevel'])
		{
			case 'admin':
				$data = array('title' => 'GPP Maintenance App', 'name' => $_SESSION['name'], 'email' => $_SESSION['email']);
				$data['main_content'] = 'account/admin_account_view';
				$this->load->view('templates/template', $data);
				break;
			case 'worker':
				$data = array('title' => 'GPP Maintenance App', 'name' => $_SESSION['name'], 'email' => $_SESSION['email']);
				$data['main_content'] = 'account/worker_account_view';
				$this->load->view('templates/template', $data);
				break;
			case 'customer':
				$this->listByDate();
				break;
		}
	}

	public function listByStatus()
	{
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
		{ redirect(''); }
		$this->load->model('customer_account');
		$data['requestlist'] = $this->customer_account->get_list_by_status($_SESSION['customerUserName']);
		$data['main_content'] = 'account/customer_account_view';
		if ($this->input->post('ajax')) {
			$data['main_content'] = 'account/listTasks';
			$this->load->view('templates/template', $data);
		}else
		{
			$data['title']='GPP Maintenance App';
			$data['customerName']=$_SESSION['customerName'];
			$data['listByDate']=0;
			$this->load->view('templates/template', $data);
		}
	}

	public function listByDate()
	{
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] != true)
		{ redirect(''); }
		$this->load->model('customer_account');
		$data['requestlist'] = $this->customer_account->get_acccount_data($_SESSION['customerUserName']);
		$data['main_content'] = 'account/customer_account_view';
		if ($this->input->post('ajax')) {
			$data['main_content'] = 'account/listTasks';
			$this->load->view('templates/template', $data);
		}
		else
		{
			$data['title']='GPP Maintenance App';
			$data['customerName']=$_SESSION['customerName'];
			$data['listByDate']=1;
			$this->load->view('templates/template', $data);
		}

	}



}

