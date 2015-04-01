<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * @author		Alizée Buatois
 */

// -----------------------------------------------------------------------------------------------

class Stock extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('vaccin_model');
		$this->load->model('stockcurrent_model');
		$this->load->model('stocklot_model');
		$this->load->model('stockregulation_model');

		// Il est dans tous les cas nécessaire d'être connecté et d'avoir les accès pour accéder à cette classe
		if (!$this->session->userdata('connected') || $this->session->userdata('user_right') < 3)
		{
			show_404();
		}		
	}

	/**
	 * Index
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 7); // on highlight le premier element du menu

		// Affichage de la vue
		$this->layout->show('backend/stock');
	}

	public function newregulation(){


		//$this->input->post('vaccinREG');
		//$this->input->post('newquantity');
		//$this->input->post('comment');

	}


	public function newlot(){
		

		//$this->input->post('vaccinLOT');
		//$this->input->post('newlot');
		//$this->input->post('quantity');
		
	}

}

/* End of file stock.php */
/* Location: ./application/controllers/stock.php */