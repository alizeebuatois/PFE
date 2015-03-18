<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Treatment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('treatment_model');

		// Il est dans tous les cas nécessaire d'être connecté et d'avoir les accès pour accéder à cette classe
		if (!$this->session->userdata('connected') || $this->session->userdata('user_right') < 3)
		{
			show_404();
		}		
	}

	/**
	 * Index : page des traitements
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 1); // on highlight le premier element du menu
		
		$view_treatment = $this->treatment_model->Treatment_getAll();
		
		// Affichage de la vue
		$this->layout->show('backend/treatment');
	}


	/**
	 * Renvoit la liste des traitements
	 * AJAX CALL
	 */
	public function getTreatment()
	{
		// Chargement des modèles
		$this->load->model('treatment_model');
		
		// Envoi des données
		$data['treatment'] = $this->treatment_model->Treatment_getAll();

		echo json_encode($data);
	}

	public function update()
	{

		// Modèles nécessaires
		$this->load->model('treatment_model');

		$data['success'] = false;

		if ($this->form_validation->run() == false)
		{
			$data['message'] = validation_errors();
		}
		// validation_errors(); // récupération des erreurs
		else
		{
				//Treatment

				$treatmentJSON = null;

				// On récupère les champs de la vue
				$treatmentNames = $this->input->post('treatmentNames');
				$treatmentDescriptions = $this->input->post('treatmentDescriptions');
				$treatmentIds = $this->input->post('treatmentIds');
				$treatmentTitles = $this->input->post('treatmentTitles');


				//echo json_encode($treatmentIds);
				//echo json_encode($treatmentDescriptions);
				//echo json_encode($treatmentNames);

				$treatmentJSON = array();

				for($i = 0; $i < count($treatmentIds); $i++){

					//var_dump($treatmentNames[$i]);
					//var_dump($treatmentDescriptions[$i]);

					array_push($treatmentJSON, 
									array('treatment_id' => $treatmentIds[$i], 
										  'name' => $treatmentNames[$i], 
										  'description' => $treatmentDescriptions[$i],
										  'title' => $treatmentTitles[$i]));
				
				}

				$treatmentJSON = json_encode($treatmentJSON);

				if($this->treatment_model->Treatment_updateAll($treatmentJSON))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les nouveaux traitements ont bien été mis à jour.';
				}

				else
				{
					// Message d'erreur
					$data['message'] = 'Une erreur s\'est produite lors de la mise à jour des traitements.';
					$data['message'] .= '<br />Merci de réessayer.';
				}
		}

		echo json_encode($data);

	}

	public function delete(){

		$id = $this->input->post('id');

		// Modèles nécessaires
		$this->load->model('treatment_model');

		$data['success'] = false;

		if($this->treatment_model->Treatment_delete($id))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les nouveaux traitements ont bien été mis à jour.';
				}

		echo 1;
	}

}

/* End of file treatment.php */
/* Location: ./application/controllers/treatment.php */