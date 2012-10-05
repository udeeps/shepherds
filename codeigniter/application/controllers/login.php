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
		if( !isset($_SESSION['original_referer']) )
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
		
		$this->get_form($formType);
		
		session_destroy();
	}
	
	public function get_form($type)
	{
		echo $type;
	}
	
	public function form_validate()
	{
	
	}
	
	public function get_account()
	{
	
	}
}
?>