<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * GeneralVaccins Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class GeneralVaccins_Model extends CI_Model {

	protected $table = 'generalVaccin';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des vaccins généraux
	 *
	 * @return Tableau des éléments de la table `generalVaccin`
	 *
	 */
	public function GeneralVaccins_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Récupère le label d'un vaccin donné par son ID
	 *
	 * @param $generalVaccin_id 	ID du vaccin
	 * @return Label du vaccin donné par son ID
	 *
	 */
	public function GeneralVaccins_getLabelById($generalVaccin_id)
	{
		$generalVaccin = $this->db->select($this->table . '_label')
							->where($this->table . '_id', $generalVaccin_id)
							->from($this->table)
							->get()
							->result_array();
		return $generalVaccin[0][$this->table . '_label'];
	}
	
}
// END GeneralVaccins Model Class

/* End of file generalvaccins_model.php */
/* Location: ./application/models/generalvaccins_model.php */