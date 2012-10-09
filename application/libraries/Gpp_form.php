<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Gpp_form {
	
    public function __construct()
    {
		
    }
	
	public function gpp_get_form($type)
	{
		switch($type)
		{
			case 'gpp_login_form':
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
				$data['validate'] = '2';
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
		}
	}
	
	public function get_gpp_login()
	{
		
	}
}

/* End of file GPP_Form.php */