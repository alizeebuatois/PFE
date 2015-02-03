<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Vaccins extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('vaccin_model');

		// Il est dans tous les cas nécessaire d'être connecté et d'avoir les accès pour accéder à cette classe
		if (!$this->session->userdata('connected') || $this->session->userdata('user_right') < 3)
		{
			show_404();
		}		
	}

	/**
	 * Index : page des vaccins
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 1); // on highlight le premier element du menu
		
		$view_vaccins = $this->vaccin_model->Vaccin_getAllWithGeneralVaccin();
		//$data = $this->vaccin_model->Vaccin_getVaccins();
		
		// Affichage de la vue
		$this->layout->show('backend/vaccins');
	}


	/**
	 * Renvoi la liste des vaccins et generalvaccin
	 * AJAX CALL
	 */
	public function getVaccins()
	{
		// Chargement des modèles
		$this->load->model('vaccin_model');
		$this->load->model('generalvaccins_model');
		
		// Envoi des données
		$data['vaccins'] = $this->vaccin_model->Vaccin_getAll();

		$data['general_vaccin'] = $this->generalvaccins_model->GeneralVaccins_getAll();	

		echo json_encode($data);
	}

	public function IdsFromNames($vaccinsComments){

		$vaccinsID = array();

		for ($i =0; $i < count($vaccinsComments); $i++){
			$vaccinsID[$i] = $this->vaccin_model->Vaccin_getIdByLabel($vaccinsComments[$i]);
		}
	return $vaccinsID;

	}



	public function update()
	{

		// Modèles nécessaires
		$this->load->model('vaccin_model');
		$this->load->model('generalvaccins_model');

		$data['success'] = false;
		if ($this->form_validation->run() == false)
		{
			$data['message'] = validation_errors(); // récupération des erreurs
		}

		else
		{
				//Vaccins
				$vaccinsJSON = null;

				// On récupère les champs de la vue
				$vaccinsGeneral = $this->input->post('vaccinsGeneral');
				$vaccinsNames = $this->input->post('vaccinsNames');

				$id = $this->input->post('vaccinsId');

				//$vaccinsID = $this->IdsFromNames($vaccinsNames);

				$vaccinsPrices = $this->input->post('vaccinsPrices');

				$vaccinsJSON = array();
				for($i = 0; $i < count($id); $i++){
					//echo $id[$i]." ".$vaccinsGeneral[$i]." ".$vaccinsNames[$i]." ".$vaccinsPrices[$i]."<br/>";
					array_push($vaccinsJSON, 
									array('id' => $vaccinsGeneral[$i], 
										  'nom' => $vaccinsNames[$i], 
										  'vaccin_id' => $id[$i],
										  'price' => $vaccinsPrices[$i]));
				}

				$vaccinsJSON = json_encode($vaccinsJSON);
				//var_dump($vaccinsJSON);

				if($this->vaccin_model->Vaccin_updateAll($vaccinsJSON))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les nouveaux vaccins ont bien été mis à jour.';
				}

				else
				{
					// Message d'erreur
					$data['message'] = 'Une erreur s\'est produite lors de la mise à jour des vaccins.';
					$data['message'] .= '<br />Merci de réessayer.';
				}
		}

	echo json_encode($data);

	}

	public function delete(){
		$id = $this->input->post('vid');

		// Modèles nécessaires
		$this->load->model('vaccin_model');
		$this->load->model('generalvaccins_model');

		$data['success'] = false;

		if($this->vaccin_model->Vaccin_delete($id))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les nouveaux vaccins ont bien été mis à jour.';
				}

		echo 1;
	}

}

/* End of file vaccins.php */
/* Location: ./application/controllers/vaccins.php */