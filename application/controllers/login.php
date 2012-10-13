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
		session_destroy();
		if( isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
			$this->get_account($_SESSION['userLevel']);
		}else{
			$_SESSION['loggedIn'] = false;
		}
		
		if( !isset($_SESSION['original_referer']) ){
			$_SESSION['original_referer'] = uri_string();
			
			if( $_SESSION['original_referer'] == 'login' )
			{
				//show GPP login
				$formType = 'gpp_login_form';
			}
			else
			{
				//show client login
				$formType = 'client_login_form';
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
				//var_dump($result);
				$_SESSION['loggedIn'] = true;
				$_SESSION['userLevel'] = $result['userLevel'];
				if($result['userLevel'] == 'admin'){
					$_SESSION['name'] = $result['query']->adminName;
					$_SESSION['email'] = $result['query']->adminEmail;
					redirect('account');
				}else if($result['userLevel'] == 'worker'){
					$_SESSION['name'] = $result['query']->workerName;
					$_SESSION['email'] = $result['query']->workerEmail;
					redirect('account');
				}else{
					$_SESSION['name'] = $result['query']->customerName;
					$_SESSION['email'] = $result['query']->customerEmail;
					redirect('account');
				}
			}
		}
		
		//echo $formType;
		$data = $this->get_form($formType);
		$this->load->view('login/login_view', $data);
	}
	
	public function get_form($type)
	{
		$this->load->library('gpp_form');
		
		return $this->gpp_form->gpp_get_form($type);
	}
	
	public function get_account($accountType, $info)
	{
		if($accountType == 'admin'){
			$data = array('name' => $info->adminName,
							'email' => $info->adminEmail);
			$this->load->view('account/account_view', $data);
		}
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