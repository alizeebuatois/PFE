<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Immunosuppressive Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Immunosuppressive_Model extends CI_Model {

	protected $table = 'immunosuppressive';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table `immunosuppressive`
	 *
	 * @return Tableau des éléments de la table `immunosuppressive`
	 *
	 */
	public function Immunosuppressive_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Récupère le label du traitement immunosuppressif donné par son Id et la langue
	 *
	 * @param $immunosuppressive_id 	ID du traitement immunosuppressif
	 * @param $lang 		Langue du label à retourner
	 * @return Label du traitement immunosuppressif donné par l'id et la langue
	 *
	 */
	public function Immunosuppressive_getLabelById($immunosuppressive_id, $lang = 'fr')
	{
		$immunosuppressive = $this->db->select($this->table . '_label_' . $lang)
							->where($this->table . '_id', $immunosuppressive_id)
							->from($this->table)
							->get()
							->result_array();
		return $immunosuppressive[0][$this->table . '_label_' . $lang];
	}
	
}
// END Immunosuppressive Model Class

/* End of file immunosuppressive_model.php */
/* Location: ./application/models/immunosuppressive_model.php */