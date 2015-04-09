<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * StockRegulation Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Stockregulation_Model extends CI_Model {

	protected $table = 'stockRegulation';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function StockRegulation_getAll($order='stock_id', $where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->order_by($order)
						->get()
						->result_array();
	}

	public function StockRegulation_getAllById($vaccin_id)
	{
		$regu = $this->db->select('*')
							->where('stock_vaccin_id', $vaccin_id)
							->from($this->table)
							->get()
							->result_array();
		return $regu;
	}

	

	public function StockRegulation_new($stock_vaccin_id, $stock_vaccin_lot, $stock_theorical_quantity, $stock_real_quantity, $stock_comment){


		$this->db->set('stock_vaccin_id', $stock_vaccin_id);
		$this->db->set('stock_vaccin_lot', $stock_vaccin_lot);
		$this->db->set('stock_theorical_quantity', $stock_theorical_quantity);
		$this->db->set('stock_real_quantity', $stock_real_quantity);
		$this->db->set('stock_date', date("Y-m-d"));
		$this->db->set('stock_comment', $stock_comment);

		return $this->db->insert($this->table);

	}

	}

	
// END StockRegulation Model Class

/* End of file stockregulation_model.php */
/* Location: ./application/models/stockregulation_model.php */