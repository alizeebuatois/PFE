<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * StockLot Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Stocklot_Model extends CI_Model {

	protected $table = 'stockLot';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function StockLot_getAll($order = 'stock_id', $where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->order_by($order)
						->get()
						->result_array();
	}

	public function StockLot_getAllById($vaccin_id)
	{
		$lot = $this->db->select('*')
							->where('stock_vaccin_id', $vaccin_id)
							->from($this->table)
							->get()
							->result_array();
		return $lot;
	}

	public function StockLot_new($stock_vaccin_id,$stock_lot,$stock_quantity_lot)
	{

		$this->db->set('stock_vaccin_id', $stock_vaccin_id);
		$this->db->set('stock_lot', $stock_lot);
		$this->db->set('stock_quantity_lot', $stock_quantity_lot);
		$this->db->set('stock_date', date("Y-m-d"));

		return $this->db->insert($this->table);
	}

	}

	
// END StockLot Model Class

/* End of file stocklot_model.php */
/* Location: ./application/models/stocklot_model.php */