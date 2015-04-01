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


	public function StockLot_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	public function StockLot_new($stock_vaccin_id,$stock_lot,$stock_quantity_lot)
	{

		// récupérer la date courante
	}

	}

	
// END StockLot Model Class

/* End of file stocklot_model.php */
/* Location: ./application/models/stocklot_model.php */