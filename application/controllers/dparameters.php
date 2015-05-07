<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Dparameters Controller Class
 *
 * Le contrôleur Dparameters n’est accessible que par les utilisateurs ayant les d’administrateur 
 * (de niveau 3). Cette vérification est effectuée au sein du constructeur de la classe et une 
 * erreur 404 est envoyée à l’utilisateur n’ayant pas ces droits.
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Dparameters extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('dparameters_model');

		// Il est dans tous les cas nécessaire d'être connecté et d'avoir les accès pour accéder à cette classe
		if (!$this->session->userdata('connected') || $this->session->userdata('user_right') < 3)
		{
			show_404();
		}		
	}

	/**
	 * Index : page des paramètres
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 7); // on highlight le premier element du menu
		
		// On récupère l'ensemble des derniers paramètres sauvegardés
		$data = $this->dparameters_model->Dparameters_getLastDparameters();
		
		// Affichage de la vue
		$this->layout->show('backend/dparameters', $data[0]); // , 
	}
	
	/**
	 * Save : Sauvegarde les données qui sont transmises via le formulaire
	 */
	public function save()
	{
		$data['success'] = false;
		$data['reload'] = false;
		$data['message'] = '';
		
		if ($this->form_validation->run() == false)
		{
			$data['message'] = validation_errors(); // envoi des erreurs
		}
		else
		{
			// On récupère les valeurs
			$hospital_phone_number = $this->input->post('hospital_phone_number');
			$hospital_finess = $this->input->post('hospital_finess');
			$center_phone_number = $this->input->post('center_phone_number');
			$center_fax = $this->input->post('center_fax');
			$head_service = $this->input->post('head_service');
			$adeli_head_service = $this->input->post('adeli_head_service');
			$doctors = $this->input->post('doctors');

			
			// Sauvegarde
			if ($this->dparameters_model->Dparameters_save(1, $hospital_phone_number, $hospital_finess, $center_phone_number, $center_fax, $head_service, $adeli_head_service, $doctors))
			{
				$data['success'] = true;
				$data['message'] = 'Les nouveaux paramètres ont été sauvegardés.';
			}
		}
		
		// Affichage du tableau pour réception Ajax
		echo json_encode($data);
	}

}

/* End of file dparameters.php */
/* Location: ./application/controllers/dparameters.php */