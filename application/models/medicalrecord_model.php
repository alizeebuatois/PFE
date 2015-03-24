<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * MedicalRecord Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class MedicalRecord_Model extends CI_Model {

	protected $table = 'medicalRecord';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->load->model('yellowfever_model');
		$this->load->model('generalvaccins_model');
		$this->load->model('vaccin_model');
		$this->load->model('treatment_model');
	}

	/**
	 * Récupère le(s) dossiers médical(caux)
	 *
	 * @return Tableau des éléments de la table `medicalRecord`
	 *
	 */
	public function MedicalRecord_get($where = array())
	{
		$data = $this->db->select('*')
						->where($where)
						->from($this->table)
						->get()
						->result_array();

		if ($data == null) return null;
		return $data;
	}

	/**
	 * Récupère le dossier médical depuis un ID
	 *
	 * @param $medicalRecord_id 	ID
	 * @return Dossier médical
	 *
	 */
	public function MedicalRecord_getFromId($medicalRecord_id)
	{
		return $this->MedicalRecord_get(array($this->table . '_id' => $medicalRecord_id))[0];
	}

	/**
	 * Mise à jour d'un dossier médical
	 *
	 * @param $customer_key 		Clé du client
	 * @param $medicalRecord_id 	ID du dossier
	 * @param $yellowFever 			Données sur la fièvre jaune (JSON)
	 * @param $stamaril 			Stamaril (JSON contenant date et n° lot)
	 * @param $previousVaccinations Vaccinations antérieures (Array contenant id, date et commentaire) 
	 * @param $vaccinations 		Vaccinations par le CVI (Array contentant id, date, lot et commentaire)
	 * @return Résultat de la requête
	 *
	 */
	public function MedicalRecord_update($customer_key, $medicalRecord_id, $yellowFever, $stamaril,
		$previousVaccinations, $vaccinations)
	{
		if(!is_numeric($medicalRecord_id) || $medicalRecord_id <= 0) $medicalRecord_id = null;

		$this->db->set($this->table . '_yellowFever', $yellowFever);
		$this->db->set($this->table . '_stamaril', $stamaril);
		if (empty($previousVaccinations))
			$this->db->set($this->table . '_previousVaccinations', null);
		else
			$this->db->set($this->table . '_previousVaccinations', json_encode($previousVaccinations));
		if (empty($vaccinations))
			$this->db->set($this->table . '_vaccinations', null);
		else
			$this->db->set($this->table . '_vaccinations', json_encode($vaccinations));

		if($medicalRecord_id != null)
		{ 
			return $this->db->where(array($this->table . '_id' => $medicalRecord_id))
				 			->update($this->table);
		}
		else
		{
			$this->db->insert($this->table);
			return $this->customer_model->Customer_updateMedicalRecord_id($customer_key, $this->db->insert_id());
		}
	}
	
}
// END MedicalRecord Model Class

/* End of file medicalrecord_model.php */
/* Location: ./application/models/medicalrecord_model.php */