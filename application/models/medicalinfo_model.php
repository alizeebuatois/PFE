<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * MedicalInfo Model Class
 *
 * @author		Clément Tessier
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class medicalInfo_Model extends CI_Model {

	protected $table = 'medicalInfo';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * MedicalInfo_get : Récupère les informations médicales
	 *
	 * @param $where 	Condition WHERE
	 * @return array 	Résultat de la requête
	 *
	 */
	public function MedicalInfo_get($where = array())
	{
		$data = $this->db->where( $where )
						->from( $this->table )
						->get()
						->result_array();

		if ($data == null) return null;

		// Pour chacun on récupère les infos de `pregnancy
		$ret = array();
		foreach ($data as $info)
		{
			if (($preg_id = $info[$this->table . 'Pregnancy_id']) != null)
			{
				$preg = $this->db->where($this->table . 'Pregnancy_id', $preg_id)
								 ->from($this->table . 'Pregnancy')
								 ->get()
								 ->result_array();
				$info[$this->table . '_pregnancy'] = $preg[0];
			}
			else
			{
				$info[$this->table . '_pregnancy'] = null;
			}
			array_push($ret, $info);
		}
		return $ret;

	}

	/**
	 * MedicalInfo_getFromId : Récupère les informations médicales depuis un ID
	 *
	 * @param $id 		ID des infos médicales
	 * @return array 	Résultat de la requête
	 *
	 */
	public function MedicalInfo_getFromId($id)
	{
		return $this->MedicalInfo_get(array($this->table . '_id' => $id))[0];
	}

	/**
	 * MedicalInfo_update : Modifier les informations médicales d'un client donné par sa clé
	 *
	 * @param $customer_key 	Clé du client concerné
	 * @param $id 				ID des infos à modifier
	 * @param $pregnancy 		Tableau contenant les informations de grossesse
	 * @param $repatriation 	Assurance rapatriation (Y,N ou DK)
	 * @param $recentIntervention 	Intervention récente
	 * @param $previousVaccinReaction 	Antécédents de réaction vaccinale
	 * @param $diseaseOrRecentFever 	Maladie aiguë ou fièvre récente
	 * @param $allergies 		Données sur les allergies (forme Json)
	 * @param $chronicDiseases 	Données sur les malaies chronique (form Json)
	 * @param $immunosuppressives 	Données sur les traitements immunosuppresseurs (forme Json)
	 * @param $currentTreatments 	Traitements actuels
	 * @return bool
	 *
	 */
	public function MedicalInfo_update($customer_key, $id, $pregnancy, $repatriation, $recentIntervention,
			$previousVaccinReaction, $diseaseOrRecentFever, $allergies, $chronicDiseases, 
			$immunosuppressives, $currentTreatments)
	{

		if(!is_numeric($id) || $id <= 0) $id = null;

		// Mise à jour ou création des infos de grossesse
		if($pregnancy == null)
		{
			$this->db->set($this->table . 'Pregnancy_id', null);
		}
		else
		{
			if (($inserted_id = $this->MedicalInfo_updatePregnancy($id, $pregnancy[$this->table . 'Pregnancy_state'],
				$pregnancy[$this->table . 'Pregnancy_contraception'], 
				$pregnancy[$this->table . 'Pregnancy_breastFeeding'])) == null)
			{
				return false;
			}
			$this->db->set($this->table . 'Pregnancy_id', $inserted_id);
		}
		$this->db->set($this->table . '_repatriationInsurance', $repatriation);
		$this->db->set($this->table . '_recentIntervention', $recentIntervention);
		$this->db->set($this->table . '_previousVaccinReaction', $previousVaccinReaction);
		$this->db->set($this->table . '_diseaseRecentFever', $diseaseOrRecentFever);
		$this->db->set($this->table . '_allergies', $allergies);
		$this->db->set($this->table . '_chronicDiseases', $chronicDiseases);
		$this->db->set($this->table . '_immunosuppressiveTreatments', $immunosuppressives);
		$this->db->set($this->table . '_currentTreatment', $currentTreatments);

		if($id != null)
		{ 
			return $this->db->where(array($this->table . '_id' => $id))
				 			->update($this->table);
		}
		else
		{
			$this->db->insert($this->table);
			return $this->customer_model->Customer_updateMedicalInfo_id($customer_key, $this->db->insert_id());
		}
	}

	/*
	 * MedicalInfo_updatePregnancy : Modifie les informations de grossesses selon l'id des infos médicales
	 *								 Procède également à la création si aucune info n'existe encore
	 */
	private function MedicalInfo_updatePregnancy($medicalInfo_id, $state, $contraception, $breastFeeding)
	{
		$this->db->set($this->table . 'Pregnancy_state', $state);
		$this->db->set($this->table . 'Pregnancy_contraception', $contraception);
		$this->db->set($this->table . 'Pregnancy_breastFeeding', $breastFeeding);

		$medicalInfo = $this->db->where($this->table . '_id', $medicalInfo_id)
							  ->from($this->table)
							  ->get()
							  ->result_array();
		if ($medicalInfo != null && ($preg_id = $medicalInfo[0][$this->table . 'Pregnancy_id']) != null)
		{
			// On doit faire une mise à jour d'une ligne qui existe déjà
			$medicalInfo = $medicalInfo[0];
			
			// La ligne dans `pregnancy` existe déjà, on met à jour
			if($this->db->where($this->table . 'Pregnancy_id', $preg_id)
						 ->update($this->table . 'Pregnancy'))

				return $preg_id;
		}
		else
		{
			// La ligne dans `pregnancy` n'existe pas, ou le dossier médical n'existe pas non plus
			// On la crée
			if($this->db->insert($this->table . 'Pregnancy'))
				return $this->db->insert_id();
		}

		return false;
	}
	
}
// END MedicalInfo Model Class

/* End of file medicalInfo_model.php */
/* Location: ./application/models/medicalInfo_model.php */