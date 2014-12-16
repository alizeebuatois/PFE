<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Country Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Country_Model extends CI_Model {

	protected $table = 'country';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table ´country´
	 *
	 * @return Tableau des éléments de la table ´country´
	 *
	 */
	public function Country_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->order_by($this->table . '_label_fr')
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Récupère le label d'un continent/pays/dom-tom donné par son Id et la langue
	 *
	 * @param $country_id 	ID du continent/pays/dom-tom
	 * @param $lang 		Langue du label à retourner
	 * @return Label du pays donné par l'id et la langue
	 *
	 */
	public function Country_getLabelById($country_id, $lang = 'fr')
	{
		$country = $this->db->select($this->table . '_label_' . $lang)
							->where($this->table . '_id', $country_id)
							->from($this->table)
							->get()
							->result_array();
		return $country[0][$this->table . '_label_' . $lang];
	}

	/**
	 * Renvoie l'ensemble des continents
	 *
	 * @return Tableau des continents
	 *
	 */
	public function Country_getContinents()
	{
		return $this->db->select('*')
						->where($this->table . '_type', 'CONTINENT')
						->from($this->table)
						->order_by($this->table . '_label_fr')
						->get()
						->result_array();
	}

	/**
	 * Renvoie l'ensemble des DOM-TOM
	 *
	 * @return Tableau des DOM-TOM
	 *
	 */
	public function Country_getDOMTOM()
	{
		return $this->db->select('*')
						->where($this->table . '_type', 'DOM-TOM')
						->from($this->table)
						->order_by($this->table . '_label_fr')
						->get()
						->result_array();
	}

	/**
	 * Renvoie l'ensemble des pays
	 *
	 * @return Tableau des pays
	 *
	 */
	public function Country_getCountries()
	{
		return $this->db->select('*')
						->where($this->table . '_type', 'COUNTRY')
						->from($this->table)
						->order_by($this->table . '_label_fr')
						->get()
						->result_array();
	}

	/**
	 * Récupère l'ensemble des pays pour les lister dans un formulaire
	 *
	 * @return Tableau des pays à lister (pays et dom-tom) sous forme (country_id => country_label)
	 *
	 */
	public function Country_getCountriesTable()
	{
		// Recherche de l'ensemble des pays de type COUNTRY or DOM-TOM
		$all = $this->Country_getAll( $this->table . '_type = "COUNTRY" OR ' .
									  $this->table . '_type = "DOM-TOM"');
		
		// Formatage des données. Id du tableau = Id du pays
		$return = array();
		foreach($all as $country)
		{
			$return[$country['country_id']] = $country['country_label_fr'];
		}

		return $return;
	}

	/**
	 * Récupère l'ensemble des pays pour les lister dans un formulaire
	 *
	 * @return Tableau des pays à lister (pays et dom-tom)
	 *
	 */
	public function Country_getAllCountries()
	{
		// Recherche de l'ensemble des pays de type COUNTRY or DOM-TOM
		$countries = $this->Country_getAll( $this->table . '_type = "COUNTRY" OR ' .
									  $this->table . '_type = "DOM-TOM"');
		
		// Formatage des données pour être affichées dans un select
		return $countries;
	}
	
}
// END Country Model Class

/* End of file country_model.php */
/* Location: ./application/models/country_model.php */