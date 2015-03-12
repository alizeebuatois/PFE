<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * HistoricTreatment Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Historictreatment_Model extends CI_Model {

	protected $table = 'historicTreatment';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}


	public function HistoricTreatment_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )

						->get()
						->result_array();
	}

	

	public function HistoricTreatment_getByCustomer($historic_customer_key)
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
	
// END HistoricTreatment Model Class

/* End of file historictreatment_model.php */
/* Location: ./application/models/historictreatment_model.php */