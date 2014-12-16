<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Hosting Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Hosting_Model extends CI_Model {

	protected $table = 'hosting';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table `hosting`
	 *
	 * @return Tableau des éléments de la table `hosting`
	 *
	 */
	public function Hosting_getAll($where = array())
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
	 * @param $hosting_id 	ID de l'hébergement
	 * @param $lang 		Langue du label à retourner
	 * @return Label de l'hébergement donné par l'id et la langue
	 *
	 */
	public function Hosting_getLabelById($hosting_id, $lang = 'fr')
	{
		$hosting = $this->db->select($this->table . '_label_' . $lang)
							->where($this->table . '_id', $hosting_id)
							->from($this->table)
							->get()
							->result_array();
		return $hosting[0][$this->table . '_label_' . $lang];
	}
	
}
// END Hosting Model Class

/* End of file hosting_model.php */
/* Location: ./application/models/hosting_model.php */