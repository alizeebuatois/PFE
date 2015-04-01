<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * StockCurrent Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Stockcurrent_Model extends CI_Model {

	protected $table = 'stockCurrent';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function StockCurrent_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}


	public function StockCurrent_new()
	{

	}

	public function StockCurrent_save($stock_vaccin_id, $stock_vaccin_lot, $stock_quantity_lot, $stock_remaining, $stock_last_update)
	{


	}

	public function Vaccin_add($vaccin_label, $vaccin_price, $generalVaccin_id)
	{
		$this->db->set( $this->table . '_label', $vaccin_label );
		$this->db->set( $this->table . '_price', $vaccin_price );
		// On n'ajoute pas $generalVaccin_id car c'est seulement dans la table de jointure

		if ($this->db->insert($this->table))
		{
			$vaccin_id = $this->db->insert_id();  // id du vaccin qui vient d'être ajouté

			// On associe au generalVaccin
			$this->db->set($this->table . '_id', $vaccin_id);
			$this->db->set('generalVaccin_id', $generalVaccin_id);
			$this->db->insert($this->table . 'GeneralVaccin');
			
		}

	return $vaccin_id;

	}

	}

	
// END StockCurrent Model Class

/* End of file stockcurrent_model.php */
/* Location: ./application/models/stockcurrent_model.php */