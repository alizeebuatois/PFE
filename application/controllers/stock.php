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


		$vaccin = $this->input->post('vaccinREG');
		$qty = $this->input->post('newquantity');
		$comment = $this->input->post('comment');

		//$th_qty = 15;
		//$lot = 20;

		//$this->stockregulation_model->StockRegulation_new($vaccin, $lot, $th_qty, $qty, $comment);

		// Il faut aussi appeler stockcurrent_model !

		redirect('stock');
		

	}


	public function newlot(){
		

		$vaccin = $this->input->post('vaccinLOT');
		$lot = $this->input->post('newlot');
		$quantity = $this->input->post('quantity');


		$this->stocklot_model->StockLot_new($vaccin, $lot, $quantity);

		// On teste d'abord si le current existe déjà, si c'est le cas on le modifie, sinon on l'ajoute
		$this->stockcurrent_model->StockCurrent_new($vaccin, $lot, $quantity, $quantity);

		redirect('stock');
		
	}

	public function getLots(){

		$id = $this->input->post('id');

		$data['lot'] = $this->stockcurrent_model->StockCurrent_getAll('stock_vaccin_id', ['stock_vaccin_id'=>$id]);

		echo json_encode($data);

	}

	public function getQuantityFromLot(){

		$idvaccin = $this->input->post('idvaccin');
		$idlot = $this->input->post('idlot');

		$data['quantity'] = $this->stockcurrent_model->StockCurrent_getFromLot($idvaccin, $idlot);

		echo json_encode($data);

	}

}

/* End of file stock.php */
/* Location: ./application/controllers/stock.php */