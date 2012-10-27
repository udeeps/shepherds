<?php if (! defined('BASEPATH')) exit('Users have no access to view this page.'); 
class Request_model extends CI_Model
{
	
	public function __construct()
	{
	
	}
	
	public function verify_task_data($postArray)
	{
		print_r($postArray);
		$type = $postArray['type_maintenance'];
		$c_name = $postArray['customer_name'];
		$billing = $postArray['billing_address'];
		$orderer = $postArray['orderer_of_work']; //later query 
		$address = $postArray['customer_address'];
		$title = $postArray['task_title'];
		$day = $postArray['day']; //later db->set('date', 'TIMESTAMP()', FALSE)
		$month = $postArray['month'];
		$year = $postArray['year'];
		$desc = $postArray['work_description'];
		$assigned = $postArray['assigned_employees'];

		//hae ordererId nimen perusteella orderer-taulusta where ordererName = $orderer
		//requestStatusId pitää olla oletuksena esim 1 (vastaanotettu). JOS työntekijä ja suoritusaika on annettu, oletus on 2 -> käynnissä
		//mysql_insert_id()
		//workTypeId haetaan työtyypin nimen perusteella
		//
		
		
	}
	
}