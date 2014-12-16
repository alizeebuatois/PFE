<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Appointment Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Appointment_Model extends CI_Model {

	protected $table = 'appointment';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * get : récupère des rendez-vous
	 *
	 * @param $doctor_key 	Clé du docteur dont faut récupérer les rendez-vous
	 * @param $date 		Date des rendez-vous à récupérer
	 *
	 */
	public function Appointment_get($doctor_key = 'all', $date = null)
	{
		if ($date != null)
			$this->db->like($this->table . '_start', $date, 'after');
		if ($doctor_key != 'all')
			$this->db->where($this->table . '_doctor_key', $doctor_key);
		return $this->db->order_by($this->table . '_start', 'ASC')
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * getOrderBy : récupère des rendez-vous classés
	 *
	 * @param $order_by 	Champ de la table pour le tri
	 * @param $way 			Sens de tri
	 *
	 */
	public function Appointment_getOrderBy($order_by, $way)
	{
		return $this->db->order_by($this->table . '_' . $order_by, $way)
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * getFromId : récupère un rendez-vous depuis un id
	 *
	 * @param $appointment_id 	Id du rendez-vous à récupérer
	 */
	public function Appointment_getFromId($appointment_id)
	{
		$data = $this->db->where($this->table . '_id', $appointment_id)
						->from($this->table)
						->get()
						->result_array();
		if ($data != null)
			return $data[0];
		else
			return null;
	}
	
	/**
	 * count : compte les rendez-vous
	 */
	public function Appointment_count($where = array())
	{
		return $this->db->where($where)
						->from($this->table)
						->count_all_results();
	}
	/**
	 * create : créer un rendez-vous
	 *
	 * @param $members 	Tableau des membres
	 * @param $departure 	Date du départ
	 * @param $return 		Date du retour
	 * @param $destinations 	Tableau des destinations
	 * @param $hostings 		Tableau des hébergements
	 * @param $activities 		Tableau des activités
	 * @param $datetime_start 	Date de début du rendez-vous
	 * @param $datetime_end		Date de fin du rendez-vous
	 * @param $doctor_key 		Clé du docteur assigné
	 * @param $user_key 		Compte concerné par le rendez-vous
	 * @param $creator_user_key 	Compte ayant créé le rendez-vous
	 */
	public function Appointment_create($members, $departure, $return, $destinations, $hostings,
		$activities, $datetime_start, $datetime_end, $doctor_key, $user_key, $creator_user_key)
	{
		// On créer le rendez-vous
		$this->db->set($this->table . '_start', $datetime_start->format('Y-m-d H:i:s'));
		$this->db->set($this->table . '_end', $datetime_end->format('Y-m-d H:i:s'));
		$this->db->set($this->table . '_doctor_key', $doctor_key);
		$this->db->set($this->table . '_departure', $departure);
		if (!empty($return))
			$this->db->set($this->table . '_return', $return);
		$this->db->set($this->table . '_done', 0);
		$this->db->set($this->table . '_user_key', $user_key);
		$this->db->set($this->table . '_creator_user_key', $creator_user_key);

		if ($this->db->insert($this->table))
		{
			$appointment_id = $this->db->insert_id(); // id du rendez-vous qui vient d'être ajouté

			// On associe les membres
			foreach ($members as $member)
			{
				$this->db->set($this->table . '_id', $appointment_id);
				$this->db->set('customer_key', $member);
				if (!$this->db->insert($this->table . 'Customer'))
				{
					$this->Appointment_deleteById($appointment_id);
					return false;
				}
			}

			// On associe les destinations
			foreach ($destinations as $destination)
			{
				$this->db->set($this->table . '_id', $appointment_id);
				$this->db->set('country_id', $destination);
				if (!$this->db->insert($this->table . 'Country'))
				{
					$this->Appointment_deleteById($appointment_id);
					return false;
				}
			}

			// On associe les hébergements
			foreach ($hostings as $hosting)
			{
				$this->db->set($this->table . '_id', $appointment_id);
				$this->db->set('hosting_id', $hosting);
				if (!$this->db->insert($this->table . 'Hosting'))
				{
					$this->Appointment_deleteById($appointment_id);
					return false;
				}
			}

			// On associe les activités
			foreach ($activities as $activity)
			{
				$this->db->set($this->table . '_id', $appointment_id);
				$this->db->set('activity_id', $activity);
				if (!$this->db->insert($this->table . 'Activity'))
				{
					$this->Appointment_deleteById($appointment_id);
					return false;
				}
			}

			return true;
		}
		return false;
	}

	/**
	 * deleteById : supprime un rendez-vous par son id
	 *
	 * @param $id	ID du rendez-vous
	 *
	 */
	public function Appointment_deleteById($id)
	{
		// Suppression des dépendances dans les autres tables
		$this->db->where($this->table . '_id', $id)
				 ->delete($this->table . 'Customer');
		$this->db->where($this->table . '_id', $id)
				 ->delete($this->table . 'Hosting');
		$this->db->where($this->table . '_id', $id)
				 ->delete($this->table . 'Activity');
		$this->db->where($this->table . '_id', $id)
				 ->delete($this->table . 'Country');
		
		// Suppression du rendez-vous
		return $this->db->where($this->table . '_id', $id)
				 		->delete($this->table);
	}

	/**
	 * Appointment_getFromStart : récupère les rendez-vous suivant un jour donné
	 *
	 * @param $start	Jour
	 *
	 */
	public function Appointment_getFromStart($start)
	{
		return $this->db->like($this->table . '_start', $start->format('Y-m-d'), 'after')
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * Appointment_getFromUserKey : retourne l'ensemble des rendez-vous d'un utilisateur donné par sa clé
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @param $checkPartners 	booléan indiquant si les rendez-vous des partenaires doivent aussi apparaître
	 *
	 */
	public function Appointment_getFromUserKey($user_key, $checkPartners = true)
	{
		// On récupère les rendez-vous qu'il a créé lui
		$appointments = $this->db->where($this->table . '_user_key', $user_key)
						->from($this->table)
						->get()
						->result_array();

		if ($checkPartners)
		{
			// On récupère les autres dans lequel il est impliqué
			// Liste des partenaires
			$this->load->model('customer_model');
			$this->load->model('partnership_model');
			$partners = $this->partnership_model->Partnership_getPartnersKey($user_key, true);
			foreach($partners as $partner_key)
			{
				$othersAppointments = $this->Appointment_getFromUserKey($partner_key, false);
				$customers = $this->customer_model->Customer_get(array('customer_user_key' => $user_key));
				foreach($othersAppointments as $othersAppointment)
				{
					// On regarde si un de ses profils est concerné par le rendez-vous
					$travelers = $this->Appointment_getCustomers($othersAppointment[$this->table . '_id']);
					foreach($customers as $customer)
					{
						if (in_array($customer['customer_key'], $travelers) && !in_array($othersAppointment, $appointments))
							array_push($appointments, $othersAppointment);
					}
				}
			}
		}
			
		// On trie par date décroissante
		usort($appointments, function($a, $b) {
		    return ($a['appointment_start'] > $b['appointment_start']);
		});

		// On retourne les rendez-vous		
		return $appointments;
	}

	/** 
	 * Appointment_getFromCustomerKey : Retourne l'ensemble des rendez-vous d'un client
	 *
	 * @param $customer_key 	Clé du client
	 *
	 */
	public function Appointment_getFromCustomerKey($customer_key)
	{
		$ids = $this->db->where('customer_key', $customer_key)
						->select($this->table . '_id')
						->from($this->table . 'Customer')
						->get()
						->result_array();

		$ret = array();
		foreach ($ids as $id)
		{
			array_push($ret, $this->Appointment_getFromId($id[$this->table . '_id']));
		}
		return $ret;
	}

	/**
	 * Appointment_getFromDoctorKey : retourne l'ensemble des rendez-vous d'un docteur
	 *
	 * @param $doctor_key 	Clé du docteur
	 *
	 */
	public function Appointment_getFromDoctorKey($doctor_key)
	{
		return $this->db->where($this->table . '_doctor_key', $doctor_key)
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * Appointment_getCustomers : retourne l'ensemble des clés des voyageurs concernés par un rendez-vous
	 *
	 * @param $appointment_id		ID du rendez-vous
	 * @return Tableau des clés des clients
	 *
	 */
	public function Appointment_getCustomers($appointment_id)
	{
		$appointments = $this->db->where($this->table . '_id', $appointment_id)
						->from($this->table . 'Customer')
						->get()
						->result_array();

		// On renvoi que les clés
		$ret = array();
		foreach ($appointments as $appointment)
		{
			array_push($ret, $appointment['customer_key']);
		}
		return $ret;
	}

	/**
	 * Appointment_getCountries : retourne l'ensemble des destinations d'un rendez-vous
	 *
	 * @param $appointment_id		ID du rendez-vous
	 * @return Tableau des id des destinations
	 *
	 */
	public function Appointment_getCountries($appointment_id)
	{
		$appointments = $this->db->where($this->table . '_id', $appointment_id)
						->from($this->table . 'Country')
						->get()
						->result_array();

		// On garde que les id des destinations
		$ret = array();
		foreach ($appointments as $appointment)
		{
			array_push($ret, $appointment['country_id']);
		}
		return $ret;
	}

	/**
	 * Appointment_getHostings : retourne l'ensemble des hébergements d'un rendez-vous
	 *
	 * @param $appointment_id		ID du rendez-vous
	 * @return Tableau des id des hébergements
	 *
	 */
	public function Appointment_getHostings($appointment_id)
	{
		$appointments = $this->db->where($this->table . '_id', $appointment_id)
						->from($this->table . 'Hosting')
						->get()
						->result_array();

		// On garde que les id des hébergements
		$ret = array();
		foreach ($appointments as $appointment)
		{
			array_push($ret, $appointment['hosting_id']);
		}
		return $ret;
	}

	/**
	 * Appointment_getActivities : retourne l'ensemble des activités d'un rendez-vous
	 *
	 * @param $appointment_id		ID du rendez-vous
	 * @return Tableau des id des activités
	 *
	 */
	public function Appointment_getActivities($appointment_id)
	{
		$appointments = $this->db->where($this->table . '_id', $appointment_id)
						->from($this->table . 'Activity')
						->get()
						->result_array();

		// On garde que les id des activités
		$ret = array();
		foreach ($appointments as $appointment)
		{
			array_push($ret, $appointment['activity_id']);
		}
		return $ret;
	}

	/**
	 * Appointment_isAvailable : retourn une clé de docteur si le rendez-vous est possible
	 *
	 * @param $start 	Date du début du rendez-vous
	 * @param $end 		Date de fin du rendez-vous
	 * @param $doctor_type 	Type de doctor
	 * @return null ou clé d'un doctor
	 *
	 */
	public function Appointment_isAvailable($start, $end, $doctor_type)
	{
		// Chargement du modèle doctor
		$this->load->model('doctor_model');

		// On récupère les doctors disponible
		$availableDoctors = $this->doctor_model->Doctor_getAvailableDoctors($start, $end, $doctor_type);

		if ($availableDoctors == null)
		{
			return null;
		}
		else
		{
			// On regarde les rendez-vous de la journée
			$appointmentsOfTheDay = $this->Appointment_getFromStart($start);
			// On compte le nombre de rendez-vous simultané (on doit pas dépasser le nombre de bureau dispo)
			$count = 0;
			// On supprime les médecin disponible s'ils sont déjà en rendez-vous
			foreach($appointmentsOfTheDay as $appointment)
			{
				// Date du rendez-vous
				$appointmentStart = new DateTime($appointment[$this->table . '_start']);
				$appointmentEnd= new DateTime($appointment[$this->table . '_end']);

				if ( !($appointmentStart >= $end || $start >= $appointmentEnd) )
				{
					if(($doctor_key = array_search($appointment[$this->table . '_doctor_key'], $availableDoctors)) !== false)
					{
					    unset($availableDoctors[$doctor_key]);
					    $count++;
					}
				}
			}
			
			// On renvoi une clé de doctor s'il en reste et si une salle est disponible
			if (count($availableDoctors) > 0 && $count <= $this->parameters_model->Parameters_getAppointmentNbRoom())
			{
				// On renvoi la clé d'un médecin disponible
				return reset($availableDoctors);
			}

			return null;			
		}
	}
	
	/**
	 * Appointment_updateFeedback : Met à jour le champ feedback d'un rendez-vous
	 *
	 * @param $id 	ID du rendez-vous
	 * @param $feedback 	Feedback
	 * @return Résultat de la requête
	 *
	 */
	public function Appointment_updateFeedback($id, $feedback = '')
	{
		return $this->db->set($this->table . '_feedback', $feedback)
						->where($this->table . '_id', $id)
						->update($this->table);
	}
	
	/**
	 * Appointment_done : Passe un rendez-vous en 'DONE'
	 *
	 * @param $id 	ID du rendez-vous
	 * @return Résultat de la requête
	 *
	 */
	public function Appointment_done($id)
	{
		return $this->db->set($this->table . '_done', 1, false)
						->where($this->table . '_id', $id)
						->update($this->table);
	}
	
}
// END Appointment Model Class

/* End of file appointment_model.php */
/* Location: ./application/models/appointment_model.php */