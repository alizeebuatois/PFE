<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Dparameters Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Dparameters_Model extends CI_Model {

	protected $table = 'dparameters';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table ´dparameters´
	 *
	 * @return Tableau des éléments de la table ´dparameters´
	 *
	 */
	public function Dparameters_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Renvoie la liste des derniers dparamètres enregistrés
	 */
	public function Dparameters_getLastDparameters()
	{
		return $this->db->limit(1)
						->order_by($this->table . '_creation', 'DESC')
						->from($this->table)
						->get()
						->result_array();
	}
	
	/**
	 * Enregistre les nouveaux dparamètres
	 */

	public function Dparameters_save($id, $hospital_phone_number, $hospital_finess, $center_phone_number, $center_fax, $head_service, $adeli_head_service, $doctors)
	{
		$this->db->set($this->table . '_hospital_phone_number', $hospital_phone_number);
		$this->db->set($this->table . '_hospital_finess', $hospital_finess);
		$this->db->set($this->table . '_center_phone_number', $center_phone_number);
		$this->db->set($this->table . '_center_fax', $center_fax);
		$this->db->set($this->table . '_head_service', $head_service);
		$this->db->set($this->table . '_adeli_head_service', $adeli_head_service);
		$this->db->set($this->table . '_doctors', $doctors);
		$this->db->set($this->table . '_creation', 'NOW()', false);

		if ($id == null)
		{
			// Création d'une nouvelle ligne de dparamètres
			return $this->db->insert($this->table);
		}
		else
		{
			// Mise à jour d'une ligne de dparamètre
			return $this->db->where($this->table . '_id', $id)
					 ->update($this->table);
		}		
	}

	public function Dparameters_getHospitalFiness()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_hospital_phone_number'];
	}


	public function Dparameters_getHospitalPhoneNumber()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_hospital_finess'];
	}

	public function Dparameters_getCenterPhoneNumber()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_center_phone_number'];
	}

	public function Dparameters_getCenterFax()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_center_fax'];
	}

		public function Dparameters_getHeadService()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_head_service'];
	}

		public function Dparameters_getAdeliHeadService()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_adeli_head_service'];
	}

		public function Dparameters_getDoctors()
	{
		$parameters = $this->Dparameters_getLastDparameters();
		return $parameters[0][$this->table . '_doctors'];
	}
	
}
// END DParameters Model Class

/* End of file dparameters_model.php */
/* Location: ./application/models/dparameters_model.php */