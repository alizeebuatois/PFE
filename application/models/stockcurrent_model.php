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


	public function StockCurrent_getAll($order ='stock_id', $where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->order_by($order)
						->get()
						->result_array();
	}

	public function StockCurrent_getRemainingQuantity($stock_vaccin_id)
	{

		return $this->db->select('stock_remaining')
				->where('stock_vaccin_id', $stock_vaccin_id)
				->from( $this->table )
				->get()
				->result_array();

	}

	public function StockCurrent_getLot($stock_vaccin_id)
	{

		return $this->db->select('stock_vaccin_lot')
				->where('stock_vaccin_id', $stock_vaccin_id)
				->from( $this->table )
				->get()
				->result_array();
		
	}

	public function StockCurrent_getFromLot($stock_vaccin_id, $stock_vaccin_lot)
	{

		return $this->db->select('stock_quantity_lot')
			->where('stock_vaccin_id', $stock_vaccin_id)
			->where('stock_vaccin_lot', $stock_vaccin_lot)
			->from( $this->table )
			->get()
			->result_array();

	}


	public function StockCurrent_new($stock_vaccin_id, $stock_vaccin_lot, $stock_quantity_lot, $stock_remaining)
	{
		if ($this->checkIdIfExist($stock_vaccin_id)) 
			{

			$this->db->set('stock_vaccin_lot', $stock_vaccin_lot);
			$this->db->set('stock_quantity_lot', $stock_quantity_lot);
			$this->db->set('stock_remaining', $stock_remaining);
			$this->db->set('stock_last_update', date("Y-m-d"));
			$this->db->where('stock_vaccin_id', $stock_vaccin_id);

			return $this->db->update($this->table);

			}

		else
			{


			$this->db->set('stock_vaccin_id', $stock_vaccin_id);
			$this->db->set('stock_vaccin_lot', $stock_vaccin_lot);
			$this->db->set('stock_quantity_lot', $stock_quantity_lot);
			$this->db->set('stock_remaining', $stock_remaining);
			$this->db->set('stock_last_update', date("Y-m-d"));

			return $this->db->insert($this->table);

			}
	}

	public function StockCurrent_save($stock_vaccin_id, $stock_vaccin_lot, $stock_quantity_lot, $stock_remaining, $stock_last_update)
	{


	}


	public function checkIdIfExist($id)
	{

	$current = $this->db->select('stock_vaccin_id')
						->where('stock_vaccin_id', $id)
						->from($this->table)
						->get()
						->result_array();

	return (count($current) > 0);
	}

	}

	
// END StockCurrent Model Class

/* End of file stockcurrent_model.php */
/* Location: ./application/models/stockcurrent_model.php */