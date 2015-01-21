<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Parameters Controller Class
 *
 * Le contrôleur Parameters n’est accessible que par les utilisateurs ayant les d’administrateur 
 * (de niveau 3). Cette vérification est effectuée au sein du constructeur de la classe et une 
 * erreur 404 est envoyée à l’utilisateur n’ayant pas ces droits.
 *
 * @author		Clément Tessier
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Parameters extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('parameters_model');

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
		$this->config->set_item('user-nav-selected-menu', 1); // on highlight le premier element du menu
		
		// On récupère l'ensemble des derniers paramètres sauvegardés
		$data = $this->parameters_model->Parameters_getLastParameters();
		
		// Affichage de la vue
		$this->layout->show('backend/parameters', $data[0]);
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
			$isLongTripFrom = $this->input->post('isLongTripFrom');
			$appointmentNbMaxCustomer = $this->input->post('appointmentNbMaxCustomer');
			$appointment1Pduration = $this->input->post('appointment1Pduration');
			$appointmentLongTripMinDuration = $this->input->post('appointmentLongTripMinDuration');
			$appointmentNPdurationPP = $this->input->post('appointmentNPdurationPP');
			$appointmentEmergencySlotDuration = $this->input->post('appointmentEmergencySlotDuration');
			$appointmentNbRoom = $this->input->post('appointmentNbRoom');
			$emailContact = $this->input->post('emailContact');
			
			// Sauvegarde
			if ($this->parameters_model->Parameters_save(1, $isLongTripFrom, $appointmentNbMaxCustomer, $appointment1Pduration, $appointmentLongTripMinDuration, 
									$appointmentNPdurationPP, $appointmentEmergencySlotDuration, $appointmentNbRoom, $emailContact))
			{
				$data['success'] = true;
				$data['message'] = 'Les nouveaux paramètres ont été sauvegardés.';
			}
		}
		
		// Affichage du tableau pour réception Ajax
		echo json_encode($data);
	}

}

/* End of file parameters.php */
/* Location: ./application/controllers/parameters.php */