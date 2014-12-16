<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Activity Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Activity_Model extends CI_Model {

	protected $table = 'activity';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table `activity`
	 *
	 * @return Tableau des éléments de la table `activity`
	 *
	 */
	public function Activity_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Récupère le label d'un hébergement donné par son Id et la langue
	 *
	 * @param $activity_id 	ID de l'hébergement
	 * @param $lang 		Langue du label à retourner
	 * @return Label de l'hébergement donné par l'id et la langue
	 *
	 */
	public function Activity_getLabelById($activity_id, $lang = 'fr')
	{
		$activity = $this->db->select($this->table . '_label_' . $lang)
							->where($this->table . '_id', $activity_id)
							->from($this->table)
							->get()
							->result_array();
		return $activity[0][$this->table . '_label_' . $lang];
	}
	
}
// END Activity Model Class

/* End of file activity_model.php */
/* Location: ./application/models/activity_model.php */