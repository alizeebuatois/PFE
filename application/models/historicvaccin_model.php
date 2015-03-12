<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * HistoricVaccin Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Historicvaccin_Model extends CI_Model {

	protected $table = 'historicVaccin';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function HistoricVaccin_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )

						->get()
						->result_array();
	}

	

	public function HistoricVaccin_getByCustomer($historic_customer_key)
	{

		$historic = $this->db->select('*')
						->where('historic_customer_key', $historic_customer_key)
						->from( $this->table )
						->order_by('historic_date')
						->get()
						->result_array();

		return $historic;
	}


}
	
// END HistoricVaccin Model Class

/* End of file historicvaccin_model.php */
/* Location: ./application/models/historicvaccin_model.php */