<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * medicalInfo Controller Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class medicalInfo extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Il est dans tous les cas nécessaire d'être connecté pour accéder à cette classe
		if (!$this->session->userdata('connected'))
		{
			echo 'Permission denied';
			exit();
		}
	}

	/**
	 * Renvoi la liste des allergies, maladies chroniques et traitements immunosuppressifs
	 * AJAX CALL
	 */
	public function getAllergiesChronicDiseasesImmunosuppressives()
	{
		// Chargement des modèles
		$this->load->model('allergy_model');
		$this->load->model('chronicDisease_model');
		$this->load->model('immunosuppressive_model');
		
		// Envoi des données
		$data['allergies'] = $this->allergy_model->Allergy_getAll();
		$data['chronicDiseases'] = $this->chronicDisease_model->ChronicDisease_getAll();
		$data['immunosuppressives'] = $this->immunosuppressive_model->Immunosuppressive_getAll();
		echo json_encode($data);
	}

	/**
	 * Fonction de mise à jour des informations médicales
	 * AJAX CALL
	 */
	public function update()
	{
		// Modèles nécessaires
		$this->load->model('customer_model');
		$this->load->model('medicalInfo_model');

		$data['success'] = false;
		if ($this->form_validation->run() == false)
		{
			$data['message'] = validation_errors(); // récupération des erreurs
		}
		else
		{
			// Récupération des données du client à modifier
			$key = $this->input->post('customer_key');			
			$customer = $this->customer_model->Customer_getFromKey($key);

			// Vérifications des droits
			if ($customer != null && ($customer[0]['customer_user_key'] == $this->session->userdata('user_key') || $this->session->userdata('user_right') > 0))
			{
				// On est autorisé à faire la modification

				$pregnancy = null;
				// POUR LES FEMMES ----------------------------------------------------------------------------------//
				if($customer[0]['customer_sex'] == 'F')
				{
					$pregnancy = array(
							'medicalInfoPregnancy_state' => 'N',
							'medicalInfoPregnancy_contraception' => 'N',
							'medicalInfoPregnancy_breastFeeding' => 0
						);
					// GROSSESSE EN COURS
					$pregnancy_state = $this->input->post('pregnancy');
					$pregnancy_state_options = array('Y','N','P','M');
					if(in_array($pregnancy_state, $pregnancy_state_options))
						$pregnancy['medicalInfoPregnancy_state'] = $pregnancy_state;
					// CONTRACEPTION
					if ($this->input->post('contraception_other') !== '')
						$pregnancy['medicalInfoPregnancy_contraception'] = $this->input->post('contraception_other');
					else	
						$pregnancy['medicalInfoPregnancy_contraception'] = $this->input->post('contraception');
					// ALLAITEMENT
					$pregnancy_breastfeeding = $this->input->post('breastfeeding');
					if($pregnancy_breastfeeding == 1)
						$pregnancy['medicalInfoPregnancy_breastFeeding'] = 1;
				}
				//-----------------------------------------------------------------------------------------------------

				// Assurance rapatriation
				$repatriation_options = array('Y','N');
				$repatriation = $this->input->post('repatriation');
				if(!in_array($repatriation, $repatriation_options))
					$repatriation = null;

				// Intervention récente
				$recentInterventionComment = $this->input->post('recentInterventionComment');
				if(!$this->input->post('recentIntervention') || $recentInterventionComment == '')
					$recentInterventionComment = null;


				// Antécédent de réaction vaccinale
				$previousVaccinReactionComment = $this->input->post('previousVaccinReactionComment');
				if(!$this->input->post('previousVaccinReaction') || $previousVaccinReactionComment == '')
					$previousVaccinReactionComment = null;

				// Maladie aiguë ou fièvre récente
				$diseaseOrRecentFeverComment = $this->input->post('diseaseOrRecentFeverComment');
				if(!$this->input->post('diseaseOrRecentFever') || $diseaseOrRecentFeverComment == '')
					$diseaseOrRecentFeverComment = null;

				// Allergies				
				$allergiesJSON = null;
				$allergies = $this->input->post('allergies');
				$allergiesComments = $this->input->post('allergiesComments');
				if (is_array($allergies) && is_array($allergiesComments))
				{
					// Création du tableau JSON
					$allergiesJSON = array();
					foreach(array_combine($allergies, $allergiesComments) as $id => $comment)
					{
						if(is_numeric($id) && $id > 0)
							array_push($allergiesJSON, array('id' => $id, 'comment' => $comment));
					}
					$allergiesJSON = json_encode($allergiesJSON);
				}

				// Maladies chroniques
				$chronicDiseasesJSON = null;
				$chronicDiseases = $this->input->post('chronicDiseases');
				$chronicDiseasesComments = $this->input->post('chronicDiseasesComments');
				if (is_array($chronicDiseases) && is_array($chronicDiseasesComments))
				{
					// Création du tableau JSON
					$chronicDiseasesJSON = array();
					foreach(array_combine($chronicDiseases, $chronicDiseasesComments) as $id => $comment)
					{
						if(is_numeric($id) && $id > 0)
							array_push($chronicDiseasesJSON, array('id' => $id, 'comment' => $comment));
					}
					$chronicDiseasesJSON = json_encode($chronicDiseasesJSON);
				}

				// Traitements immunosuppressives
				$immunosuppressivesJSON = null;
				$immunosuppressives = $this->input->post('immunosuppressives');
				$immunosuppressivesComments = $this->input->post('immunosuppressivesComments');
				if (is_array($immunosuppressives) && is_array($immunosuppressivesComments))
				{
					// Création du tableau JSON
					$immunosuppressivesJSON = array();
					foreach(array_combine($immunosuppressives, $immunosuppressivesComments) as $id => $comment)
					{
						if(is_numeric($id) && $id > 0)
							array_push($immunosuppressivesJSON, array('id' => $id, 'comment' => $comment));
					}
					$immunosuppressivesJSON = json_encode($immunosuppressivesJSON);
				}

				// Traitements actuels
				$currentTreatments = $this->input->post('currentTreatments');

				// Mise à jour des infos médicales
				if($this->medicalInfo_model->MedicalInfo_update($customer[0]['customer_key'],
					$customer[0]['customer_medicalInfo_id'], $pregnancy,
					$repatriation, $recentInterventionComment, $previousVaccinReactionComment, $diseaseOrRecentFeverComment, 
					$allergiesJSON, $chronicDiseasesJSON, $immunosuppressivesJSON, $currentTreatments))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les nouvelles informations ont bien été mises à jour.';
				}
				else
				{
					// Message d'erreur
					$data['message'] = 'Une erreur s\'est produite lors de la mise à jour des informations médicales.';
					$data['message'] .= '<br />Merci de réessayer.';
				}
			}
			else
			{
				// L'utilisateur n'est pas autorisé à la modification
				$data['message'] = 'Vous n\'êtes pas autorisé à modifier ces informations.';
			}
		}
		echo json_encode($data);
	}

}

/* End of file medicalInfo.php */
/* Location: ./application/controllers/medicalInfo.php */