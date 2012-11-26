<?php
session_start();
		 // set timeout period in seconds
		 $inactive = 600;
		 // check to see if $_SESSION['timeout'] is set
		 if(isset($_SESSION['timeout']) )
		 {
			$session_life = time() - $_SESSION['timeout'];
			if($session_life > $inactive)
			{
			if($_SESSION['userLevel'] == 'customer')
			session_destroy();
			else
			{
			session_destroy();
			redirect('login');
			}
			}
			}

			$_SESSION['timeout'] = time();