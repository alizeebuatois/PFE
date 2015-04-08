<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * medicalRecord Controller Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class medicalRecord extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('medicalRecord_model');


		// Il est dans tous les cas nécessaire d'être connecté et membre du personnel pour accéder à cette classe
		if (!$this->session->userdata('connected') || $this->session->userdata('user_right') == 0)
		{
			echo 'Permission denied';
			exit();
		}
	}

	/**
	 * Renvoi la liste des vaccins du CVI et des vaccins généraux
	 * AJAX CALL
	 */
	public function getMedicalRecordVaccinsTreatments()
	{
		// Envoi des listes de vaccins généraux et vaccin
		$data['generalVaccins'] = $this->generalvaccins_model->GeneralVaccins_getAll();
		$data['vaccins'] = $this->vaccin_model->Vaccin_getAll('vaccin_label');
		$data['treatments'] = $this->treatment_model->Treatment_getAll();

		echo json_encode($data);
	}

	/**
	 * Fonction de mise à jour du dossier médical
	 * AJAX CALL
	 */
	public function update()
	{
		// Modèle nécessaire
		$this->load->model('customer_model');
		$this->load->model('historicvaccin_model');

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
			if ($customer != null && $this->session->userdata('user_right') > 0)
			{
				// On est autorisé à faire la modification

				// YELLOW FEVER
				$yellowFeverJSON = null;
				foreach ($this->yellowfever_model->YellowFever_getAll() as $yf)
				{
					if ($this->input->post('yellowFever_' . $yf['yellowFever_id']))
					{
						$yellowFeverJSON[$yf['yellowFever_id']]['done'] = $this->input->post('yellowFever_' . $yf['yellowFever_id']);
						$yellowFeverJSON[$yf['yellowFever_id']]['comment'] = htmlentities($this->input->post('yellowFever_' . $yf['yellowFever_id'] . '_comment'));
					}
				}
				if ($yellowFeverJSON != null) $yellowFeverJSON = json_encode($yellowFeverJSON);
				//-----------------------------------------------

				// STAMARIL			
				$stamarilsJSON = null;
				$stamaril_dates = $this->input->post('stamaril_dates');
				$stamaril_lots = $this->input->post('stamaril_lots');
				if (is_array($stamaril_dates) && is_array($stamaril_lots))
				{
					$stamarilsJSON = array();
					foreach(array_combine($stamaril_dates, $stamaril_lots) as $date => $lot)
					{
						if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date))
							array_push($stamarilsJSON, array('date' => $date, 'lot' => $lot));
					}
					$stamarilsJSON = json_encode($stamarilsJSON);
				}
				//------------------------------------------------

				// VACCINATIONS ANTERIEURES	
				$previousVaccinations = null;
				$previousVaccinations_id = $this->input->post('previousVaccinationsIds');
				$previousVaccinations_date = $this->input->post('previousVaccinationsDates');
				$previousVaccinations_comment = $this->input->post('previousVaccinationsComments');		
				if (is_array($previousVaccinations_id) && is_array($previousVaccinations_date) && is_array($previousVaccinations_comment))
				{
					// Création du tableau JSON
					$previousVaccinations = array();
					for($i=0 ; $i < count($previousVaccinations_id) ; ++$i)
					{
						if(is_numeric($previousVaccinations_id[$i]) && $previousVaccinations_id[$i] > 0)
						{
							if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $previousVaccinations_date[$i]))
								array_push($previousVaccinations, 
									array('id' => $previousVaccinations_id[$i], 
										'date' => $previousVaccinations_date[$i], 
										'comment' => $previousVaccinations_comment[$i]));
						}
					}
				}
				//------------------------------------------------

				// VACCINATIONS PAR LE CVI
				$vaccinations = null;
				$vaccinations_id = $this->input->post('vaccinationsIds');
				$vaccinations_date = $this->input->post('vaccinationsDates');
				$vaccinations_lot = $this->input->post('vaccinationsLots');
				$vaccinations_comment = $this->input->post('vaccinationsComments');	
				$vaccinations_historic_id = $this->input->post('historicIds');
				if (is_array($vaccinations_id) && is_array($vaccinations_date) && is_array($vaccinations_lot) && is_array($vaccinations_comment))
				{
					// Création du tableau JSON
					$vaccinations = array();
					for($i=0 ; $i < count($vaccinations_id) ; ++$i)
					{
						if(is_numeric($vaccinations_id[$i]) && $vaccinations_id[$i] > 0)
						{
							if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $vaccinations_date[$i]))
								array_push($vaccinations, 
									array('historic_id' => $vaccinations_historic_id[$i],
										'id' => $vaccinations_id[$i], 
										'date' => $vaccinations_date[$i], 
										'lot' => $vaccinations_lot[$i],
										'comment' => $vaccinations_comment[$i]));
						}
					}
				}

				$doctor_key = $this->session->userdata('user_doctor_key');
				$key = $this->input->post('customer_key');	
				$vaccinationsA = json_encode($vaccinations);

				$this->historicvaccin_model->update($vaccinationsA, $key, $doctor_key);
				
				//------------------------------------------------

				if($this->medicalRecord_model->MedicalRecord_update($customer[0]['customer_key'],
					$customer[0]['customer_medicalRecord_id'], $yellowFeverJSON, $stamarilsJSON, $previousVaccinations, $vaccinations))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Le dossier médical a été mis à jour.';
				}
				else
				{
					$data['message'] = 'Une erreur s\'est produite lors de la mise à jour du dossier médical.';
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


	public function deleteHistoricVaccin(){

		$id = $this->input->post('vaccin_id');

		// Modèles nécessaires
		$this->load->model('historicvaccin_model');

		$data['success'] = false;

		if($this->historicvaccin_model->delete($id))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les vaccins ont bien été mis à jour.';
				}

		echo 1;
	}


	public function deleteHistoricTreatment(){

		$id = $this->input->post('treatment_id');

		// Modèles nécessaires
		$this->load->model('historictreatment_model');

		$data['success'] = false;

		if($this->historictreatment_model->delete($id))
				{
					// Message de succès
					$data['success'] = true;
					$data['message'] = 'Les traitements ont bien été mis à jour.';
				}

		echo 1;
	}

	

}

/* End of file medicalRecord.php */
/* Location: ./application/controllers/medicalRecord.php */