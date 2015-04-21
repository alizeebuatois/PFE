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
						// trié par date décroissante
						->order_by('historic_date', "desc")
						->get()
						->result_array();

		return $historic;
	}

	public function HistoricTreatment_getByCustomerJSON($historic_customer_key)
	{

		$historic = $this->db->select('*')
						->where('historic_customer_key', $historic_customer_key)
						->from( $this->table )
						->order_by('historic_date', "desc")
						->get()
						->result_array();

		return json_encode($historic);
	}

	public function HistoricTreatment_update($historic_id, $customer_key, $treatment_id, $date, $doctor_key, $historic_comment)
	{

		$this->db->set('historic_customer_key', $customer_key);
		$this->db->set('historic_treatment_id', $treatment_id);
		$this->db->set('historic_date', $date);
		$this->db->set('historic_doctor_key', $doctor_key);
		$this->db->set('historic_comment', $historic_comment);
		$this->db->where('historic_id', $historic_id);

		return $this->db->update($this->table);
						

	}


	public function update($treatments, $customer, $doctor)
	{

	$donnees = json_decode($treatments);

		$return = null;

		for($i=0 ; $i<count($donnees) ; $i++)
		{

			$treatments_id = $donnees[$i]->id;
			$treatments_date = $donnees[$i]->date;
			$treatments_comment = $donnees[$i]->comment;
			$treatments_historic_id = $donnees[$i]->historic_id;

			if($this->checkIdIfExist($treatments_historic_id)){
				$return = $this->HistoricTreatment_update($treatments_historic_id, $customer, $treatments_id, $treatments_date, $doctor, $treatments_comment);
			}
			else{
			$return = $this->HistoricTreatment_add($customer, $treatments_id, $treatments_date, $doctor, $treatments_comment);

			}

		}

		return $return;

	}

	public function delete($id)
	{

	return $this->db->where( 'historic_id', $id)
					->delete( $this->table );

	}


	public function checkIdIfExist($id)
	{

	$treatment = $this->db->select('historic_id')
						->where('historic_id', $id)
						->from($this->table)
						->get()
						->result_array();

	return (count($treatment) > 0);
	}


}
	
// END HistoricTreatment Model Class

/* End of file historictreatment_model.php */
/* Location: ./application/models/historictreatment_model.php */