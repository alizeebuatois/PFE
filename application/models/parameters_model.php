<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Parameters Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Parameters_Model extends CI_Model {

	protected $table = 'parameters';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des éléments de la table ´parameters´
	 *
	 * @return Tableau des éléments de la table ´parameters´
	 *
	 */
	public function Country_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}

	/**
	 * Renvoie la liste des derniers paramètres enregistrés
	 */
	public function Parameters_getLastParameters()
	{
		return $this->db->limit(1)
						->order_by($this->table . '_creation', 'DESC')
						->from($this->table)
						->get()
						->result_array();
	}
	
	/**
	 * Enregistre les nouveaux paramètres
	 */
	public function Parameters_save($id, $isLongTripFrom, $appointmentNbMaxCustomer, $appointment1Pduration, $appointmentLongTripMinDuration, 
									$appointmentNPdurationPP, $appointmentEmergencySlotDuration, $appointmentNbRoom, $emailContact)
	{
		$this->db->set($this->table . '_isLongTripFrom', $isLongTripFrom);
		$this->db->set($this->table . '_appointmentNbMaxCustomer', $appointmentNbMaxCustomer);
		$this->db->set($this->table . '_appointment1Pduration', $appointment1Pduration);
		$this->db->set($this->table . '_appointmentLongTripMinDuration', $appointmentLongTripMinDuration);
		$this->db->set($this->table . '_appointmentNPdurationPP', $appointmentNPdurationPP);
		$this->db->set($this->table . '_appointmentEmergencySlotDuration', $appointmentEmergencySlotDuration);
		$this->db->set($this->table . '_appointmentNbRoom', $appointmentNbRoom);
		$this->db->set($this->table . '_emailContact', $emailContact);
		$this->db->set($this->table . '_creation', 'NOW()', false);

		if ($id == null)
		{
			// Création d'une nouvelle ligne de paramètres
			return $this->db->insert($this->table);
		}
		else
		{
			// Mise à jour d'une ligne de paramètre
			return $this->db->where($this->table . '_id', $id)
					 ->update($this->table);
		}		
	}

	/**
	 * Renvoie le paramètre : nombre maximum de client par rendez-vous
	 */
	public function Parameters_getAppointmentNbMaxCustomer()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_appointmentNbMaxCustomer'];
	}

	/**
	 * Renvoie le paramètre : durée d'une consultation pour une personne (petit voyage)
	 */
	public function Parameters_getAppointment1Pduration()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_appointment1Pduration'];
	}

	/**
	 * Renvoie le paramètre : durée par personne dans une consultation à plusieurs (petit voyage)
	 */
	public function Parameters_getAppointmentNPdurationPP()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_appointmentNPdurationPP'];
	}

	/**
	 * Renvoie le paramètre : durée à partir de laquelle un petit voyage devient long (en jours)
	 */
	public function Parameters_getIsLongTripFrom()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_isLongTripFrom'];
	}

	/**
	 * Renvoie le paramètre : durée minimum d'une consultation (1P ou NP) (long voyage)
	 */
	public function Parameters_getAppointmentLongTripMinDuration()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_appointmentLongTripMinDuration'];
	}

	/**
	 * Renvoie le paramètre : durée des créneaux d'urgences (début et fin de chaque demi-journée)
	 */
	public function Parameters_getAppointmentEmergencySlotDuration()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_appointmentEmergencySlotDuration'];
	}

	/**
	 * Renvoie le paramètre : nombre de salle (nombre de rendez-vous simultanés possible)
	 */
	public function Parameters_getAppointmentNbRoom()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_appointmentNbRoom'];
	}
	
	/**
	 * Renvoie le paramètre : email de contact du centre
	 */
	public function Parameters_getEmailContact()
	{
		$parameters = $this->Parameters_getLastParameters();
		return $parameters[0][$this->table . '_emailContact'];
	}
	
}
// END Parameters Model Class

/* End of file parameters_model.php */
/* Location: ./application/models/parameters_model.php */