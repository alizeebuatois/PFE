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


	public function StockRegulation_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}


	public function StockRegulation_new($stock_vaccin_id, $stock_vaccin_lot, $stock_theorical_quantity, $stock_real_quantity, $stock_date, $stock_comment){

	}

	}

	
// END StockRegulation Model Class

/* End of file stockregulation_model.php */
/* Location: ./application/models/stockregulation_model.php */