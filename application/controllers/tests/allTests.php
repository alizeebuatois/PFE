<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class AllTests extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->library('unit_test');	
	}


	public function index(){


	}



	public function firstTest(){

		$test = 1 + 3;
		$expected_result = 2;
		$test_name = 'Adds one plus one';
		$this->unit->run($test, $expected_result, $test_name);
		echo $this->unit->report();
	}

}
