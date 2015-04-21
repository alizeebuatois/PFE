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
		$this->load->model('stockcurrent_model');
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
						->order_by('historic_date', "desc")
						->get()
						->result_array();

		return $historic;
	}

		public function HistoricVaccin_getByCustomerJSON($historic_customer_key)
	{

		$historic = $this->db->select('*')
						->where('historic_customer_key', $historic_customer_key)
						->from( $this->table )
						->order_by('historic_date', "desc")
						->get()
						->result_array();

		return json_encode($historic);
	}

	public function HistoricVaccin_add($customer_key, $vaccin_id, $lot, $date, $doctor_key, $historic_comment)
	{

		$this->db->set('historic_customer_key', $customer_key);
		$this->db->set('historic_vaccin_id', $vaccin_id);
		$this->db->set('historic_lot', $lot);
		$this->db->set('historic_date', $date);
		$this->db->set('historic_doctor_key', $doctor_key);
		$this->db->set('historic_comment', $historic_comment);

		return $this->db->insert($this->table);

	}

		public function HistoricVaccin_update($historic_id, $customer_key, $vaccin_id, $lot, $date, $doctor_key, $historic_comment)
	{

		$this->db->set('historic_customer_key', $customer_key);
		$this->db->set('historic_vaccin_id', $vaccin_id);
		$this->db->set('historic_lot', $lot);
		$this->db->set('historic_date', $date);
		$this->db->set('historic_doctor_key', $doctor_key);
		$this->db->set('historic_comment', $historic_comment);
		$this->db->where('historic_id', $historic_id);

		return $this->db->update($this->table);
						

	}


	public function update($vaccinations, $customer, $doctor){

	$donnees = json_decode($vaccinations);

		$return = null;

		for($i=0 ; $i<count($donnees) ; $i++)
		{

			$vaccinations_id = $donnees[$i]->id;
			$vaccinations_date = $donnees[$i]->date;
			$vaccinations_lot = $donnees[$i]->lot;
			$vaccinations_comment = $donnees[$i]->comment;
			$vaccinations_historic_id = $donnees[$i]->historic_id;

			if($this->checkIdIfExist($vaccinations_historic_id)){
				$return = $this->HistoricVaccin_update($vaccinations_historic_id, $customer, $vaccinations_id, $vaccinations_lot, $vaccinations_date, $doctor, $vaccinations_comment);
			}
			else{
			$return = $this->HistoricVaccin_add($customer, $vaccinations_id, $vaccinations_lot, $vaccinations_date, $doctor, $vaccinations_comment);
			
			// On décrémente la quantité du vaccin courrant
			$this->stockcurrent_model->decreaseStockCurrent($vaccinations_id, $vaccinations_lot);
			}

		}

		return $return;

	}

	public function delete($id){

	return $this->db->where( 'historic_id', $id)
					->delete( $this->table );

	}


	public function checkIdIfExist($id)
	{

	$vaccin = $this->db->select('historic_id')
						->where('historic_id', $id)
						->from($this->table)
						->get()
						->result_array();

	return (count($vaccin) > 0);
	}

}
	
// END HistoricVaccin Model Class

/* End of file historicvaccin_model.php */
/* Location: ./application/models/historicvaccin_model.php */