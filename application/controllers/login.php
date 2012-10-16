<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 

class Login extends CI_Controller
{
	
	private $formType;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library( array('form_validation', 'session') );
		session_start();
	}
	
	public function index($loginType = '')
	{
		//session_destroy();
		if( isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
			redirect('account');
		}else{
			$_SESSION['loggedIn'] = false;
		}
		if(!isset($_SESSION['uri'])){
			if( uri_string() == 'login' ){
				$_SESSION['uri'] = 'gpp_login_form';
				//show GPP login
				//$formType = 'gpp_login_form';
			}else{
				$_SESSION['uri'] = 'client_login_form';
				//show client login
				//$formType = 'client_login_form';
			}
		}
		
		$this->form_validation->set_rules('email_address', 'Email address', 'required|valid_email'); //set_rules('field name', 'human readable name for error messages', rules)
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
		
		if( $this->form_validation->run() !== FALSE )
		{
			$this->load->model('auth_model');
			$result = $this->auth_model->verify_user($this->input->post('email_address'), $this->input->post('password'), $loginType);
			
			if($result != false)
			{
				//user exists
				$_SESSION['loggedIn'] = true;
				$_SESSION['userLevel'] = $result['userLevel'];
				if($_SESSION['userLevel'] == 'admin'){
					$_SESSION['name'] = $result['query']->adminName;
					$_SESSION['email'] = $result['query']->adminEmail;
					redirect('account');
				}else if($_SESSION['userLevel'] == 'worker'){
					$_SESSION['name'] = $result['query']->workerName;
					$_SESSION['email'] = $result['query']->workerEmail;
					redirect('account');
				}else{
					$_SESSION['customerName'] = $result['query']->customerName;
					$_SESSION['name'] = $result['query']->ordererName;
					$_SESSION['email'] = $result['query']->ordererEmail;
					redirect('account');
				}
			}
		}
		
		$data = $this->get_form($_SESSION['uri']);
		$this->load->view('login/login_view', $data);
	}
	
	public function get_form($type)
	{
		$this->load->library('gpp_form');
		
		return $this->gpp_form->get_login_form($type);
	}
	
	public function log_out()
	{
		$redirect = '';
		
		switch( $_SESSION['userLevel'] )
		{
			case 'admin':
				$redirect = 'login';
				break;
			case 'worker':
				$redirect = 'login';
				break;
			case 'customer':
				$redirect = 'customer/login';
				break;
		}
		session_destroy();
		redirect($redirect);
	}
}
?>