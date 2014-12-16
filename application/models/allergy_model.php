<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Allergy Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Allergy_Model extends CI_Model {

	protected $table = 'allergy';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table `allergy`
	 *
	 * @return Tableau des éléments de la table `allergy`
	 *
	 */
	public function Allergy_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Récupère le label d'une allergie donné par son Id et la langue
	 *
	 * @param $allergy_id 	ID de l'allergie
	 * @param $lang 		Langue du label à retourner
	 * @return Label de l'allergie donné par l'id et la langue
	 *
	 */
	public function Allergy_getLabelById($allergy_id, $lang = 'fr')
	{
		$allergy = $this->db->select($this->table . '_label_' . $lang)
							->where($this->table . '_id', $allergy_id)
							->from($this->table)
							->get()
							->result_array();
		return $allergy[0][$this->table . '_label_' . $lang];
	}
	
}
// END Allergy Model Class

/* End of file allergy_model.php */
/* Location: ./application/models/allergy_model.php */