<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * YellowFever Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class YellowFever_Model extends CI_Model {

	protected $table = 'yellowFever';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table `yellowFever`
	 *
	 * @return Tableau des éléments de la table `yellowFever`
	 *
	 */
	public function YellowFever_getAll($where = array())
	{
		return $this->db->select('*')
						->where($where)
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * Récupère le label du champ fiève jaune donné par son Id
	 *
	 * @param $yellowFever_id 	ID du champ
	 * @return Label du champ donné par l'id
	 *
	 */
	public function YellowFever_getLabelById($yellowFever_id)
	{
		$yellowFever = $this->db->select($this->table . '_label')
							->where($this->table . '_id', $yellowFever_id)
							->from($this->table)
							->get()
							->result_array();
		return $yellowFever[0][$this->table . '_label'];
	}
	
}
// END YellowFever Model Class

/* End of file yellowfever_model.php */
/* Location: ./application/models/yellowfever_model.php */