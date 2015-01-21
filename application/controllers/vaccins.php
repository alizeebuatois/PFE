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
		
		// On récupère l'ensemble des derniers paramètres sauvegardés
		//$data = $this->parameters_model->Parameters_getLastParameters();
		
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

		$vaccins = $data["vaccins"];

		$data['general_vaccin'] = $this->generalvaccins_model->GeneralVaccins_getAll();	

		echo json_encode($data);
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
				$vaccins = $this->input->post('vaccinsGeneral');
				$vaccinsComments = $this->input->post('vaccinsNames');

				$vaccinsID = IdsFromNames($vaccinsComments);

				$vaccinsPrices = $this->input->post('vaccinsPrices');

				if (is_array($vaccins) && is_array($vaccinsComments) && is_array($vaccinsPrice))
				{
					// Création du tableau JSON
					$vaccinsJSON = array();

					foreach(array_combine($vaccins, $vaccinsComments) as $general_vaccin_id => $nom_vaccin)
					{
						foreach(array_combine($vaccins, $vaccinsID) as $general_vaccin_id2 => $vaccin_id) {

							foreach(array_combine($vaccins,$vaccinsPrices) as $general_vaccin_id3 => $vaccin_prix) {

								if($general_vaccin_id  != $general_vaccin_id2) break;
								if($general_vaccin_id  != $general_vaccin_id3) break;
								if($general_vaccin_id2 != $general_vaccin_id3) break;

								if(is_numeric($id) && $id > 0)
								array_push($vaccinsJSON, 
									array('id' => $general_vaccin_id, 
										  'nom' => $nom_vaccin, 
										  'vaccin_id' => $vaccin_id,
										  'price' => $vaccin_prix));
							}

						}
					}
					$vaccinsJSON = json_encode($vaccinsJSON);
				}

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

	public function IdsFromNames($vaccinsComments){

		



	}

}

/* End of file parameters.php */
/* Location: ./application/controllers/parameters.php */