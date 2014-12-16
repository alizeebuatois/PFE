<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Vaccins Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Vaccin_Model extends CI_Model {

	protected $table = 'vaccin';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des vaccins du CVI
	 *
	 * @return Tableau des éléments de la table `vaccin`
	 *
	 */
	public function Vaccin_getAll($where = array())
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
	 * @param $vaccin_id 	ID du vaccin
	 * @return Label du vaccin donné par son ID
	 *
	 */
	public function Vaccin_getLabelById($vaccin_id)
	{
		$vaccin = $this->db->select($this->table . '_label')
							->where($this->table . '_id', $vaccin_id)
							->from($this->table)
							->get()
							->result_array();
		return $vaccin[0][$this->table . '_label'];
	}
	
}
// END Vaccin Model Class

/* End of file vaccin_model.php */
/* Location: ./application/models/vaccin_model.php */