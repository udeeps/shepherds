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
	
	public function index()
	{
		session_destroy();
		if( isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] == true ){
			//redirect('account');
		}else{
			$_SESSION['loggedIn'] = false;
		}
		
		if( !isset($_SESSION['original_referer']) ){
			$_SESSION['original_referer'] = uri_string();
		}
		
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
		 echo $formType;
		$data = $this->get_form($formType);
		$this->load->view('login/login_view', $data);
	}
	
	public function get_form($type)
	{
		$this->load->library('gpp_form');
		
		return $this->gpp_form->gpp_get_form($type);
	}
	
	public function form_validate($loginType)
	{
		$this->form_validation->set_rules('email_address', 'Email address', 'required|valid_email'); //set_rules('field name', 'human readable name for error messages', rules)
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[4]');
		
		if( $this->form_validation->run() !== FALSE )
		{
			$this->load->model('auth_model');
			$result = $this->auth_model->verify_user($this->input->post('email_address'), $this->input->post('password'), $loginType);
			
			if($result !== false)
			{
				//user exists
				var_dump($result);
				$_SESSION['loggedIn'] = true;
				$_SESSION['userLevel'] = $result['userLevel'];
				//$_SESSION['realName'] = ( property_exists($result['query'], 'workerName') ) ? $result['query']->workerName : $result['query']->adminName;
				//echo $_SESSION['realName'];
				$this->get_account($_SESSION['userLevel']);
			}
		}
	}
	
	public function get_account($accountType)
	{
		if($accountType == 'customer'){
			$this->load->view('account/account_view');
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