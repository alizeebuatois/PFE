<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * ChronicDisease Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class ChronicDisease_Model extends CI_Model {

	protected $table = 'chronicDisease';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table `chronicDisease`
	 *
	 * @return Tableau des éléments de la table `chronicDisease`
	 *
	 */
	public function ChronicDisease_getAll($where = array())
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
	 * @param $chronicDisease_id 	ID de la maladie chronique
	 * @param $lang 		Langue du label à retourner
	 * @return Label de la maladie chronique donné par l'id et la langue
	 *
	 */
	public function ChronicDisease_getLabelById($chronicDisease_id, $lang = 'fr')
	{
		$chronicDisease = $this->db->select($this->table . '_label_' . $lang)
							->where($this->table . '_id', $chronicDisease_id)
							->from($this->table)
							->get()
							->result_array();
		return $chronicDisease[0][$this->table . '_label_' . $lang];
	}
	
}
// END ChronicDisease Model Class

/* End of file chronicDisease_model.php */
/* Location: ./application/models/chronicDisease_model.php */