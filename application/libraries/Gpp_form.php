<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Gpp_form {
	
    public function __construct()
    {
		
    }
	
	public function get_login_form($type)
	{
		
		switch($type)
		{
			
			case 'gpp_login_form':
				$data['title'] = 'GPP Maintenance App';
				$data['validate'] = '1';
				$data['userFields'] = array('id' => 'email_address', 
										'name' => 'email_address',
										'placeholder' => 'Email address');
				$data['passwordFields'] = array('id' => 'password',
												'type' => 'password',
												'name' => 'password',
												'placeholder' => 'Password'
												);
				$data['submit'] = array('name' => 'submit',
										'type' => 'submit',
										'value' => 'Log in',
										'class' => 'medium button gppbutton');
				
				return $data;
			case 'client_login_form':
				$data['title'] = 'GPP Maintenance App';
				$data['validate'] = '2';
				$data['userFields'] = array('id' => 'email_address', 
										'name' => 'email_address',
										'placeholder' => 'User Name');
				$data['passwordFields'] = array('id' => 'password',
												'type' => 'password',
												'name' => 'password',
												'placeholder' => 'Password'
												);
				$data['submit'] = array('name' => 'submit',
										'type' => 'submit',
										'value' => 'Log in',
										'class' => 'medium button gppbutton');
				return $data;
		}
	}
	
	
}

/* End of file GPP_Form.php */