<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Backend Controller Class
 *
 * Le contrôleur Backend a été créé pour y insérer des méthodes particulières du back-office comme 
 * le dashboard ou la page des statistiques.
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Backend extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Modèles
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->model('doctor_model');
		$this->load->model('appointment_model');
		$this->load->model('country_model');

		// Il est dans tous les cas nécessaire d'être connecté pour accéder à cette classe
		if (!$this->session->userdata('connected'))
		{
			redirect('login?redirect=dashboard');
		}
		else if ($this->session->userdata('user_right') == 0)
		{
			show_404();
		}
	}

	/**
	 * Index : page principale du backend DASHBOARD
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 1); // premier item du menu à highlight!

		// Rendez-vous de la journée
		$today = new DateTime('today');
		$today = $today->format('Y-m-d');

		// On affiche tout les rendez-vous de tout le monde si c'est la secrétaire qui est connectée
		if ($this->session->userdata('user_right') == 2)
			$doctor_key = 'all';
		else
			$doctor_key = $this->session->userdata('user_doctor_key'); // doctor conncté
		
		$appointments = $this->appointment_model->Appointment_get($doctor_key, $today);
		$data['today_appointments'] = array();
		// Récupération des clients de chaque rendez-vous
		foreach($appointments as $appointment)
		{
			$appointment['members'] = $this->appointment_model->Appointment_getCustomers($appointment['appointment_id']);
			array_push($data['today_appointments'], $appointment);
		}

		// Affichage de la vue
		$this->layout->show('backend/index', $data);
	}

	/**
	 * Planning
	 */
	public function schedule($doctor_key = '')
	{
		$this->config->set_item('user-nav-selected-menu', 3); // 3ème item du menu à highlight

		// On fourni à la vue la clé du docteur duquel on veut afficher le planning
		$data['doctor_key'] = $doctor_key;
		// Liste des docteurs pour menu déroulant
		$data['doctors'] = $this->doctor_model->Doctor_get();
		
		// Affichage de la vue
		$this->layout->show('backend/schedule', $data);
	}

	public function create($doctor_key = '')
	{
		$this->config->set_item('user-nav-selected-menu', 3); // 3ème item du menu à highlight

		// On fournit à la vue la clé du docteur duquel on veut afficher le planning
		$data['doctor_key'] = $doctor_key;
		// Liste des docteurs pour menu déroulant
		$data['doctors'] = $this->doctor_model->Doctor_get();
		
		// Affichage de la vue
		$this->layout->show('backend/create', $data);
	}
	
	/**
	 * Statistics
	 */
	public function statistics()
	{
		// Seuls les administrateurs peuvent accéder à cette page
		if ($this->session->userdata('user_right') != 3)
			show_404();
		// ------------------------------------------------------
	
		$this->config->set_item('user-nav-selected-menu', 1);

		// Taux occupation
		$totalAppointments = 0;
		$totalOpenings = 0;
		$appointments = $this->appointment_model->Appointment_getOrderBy('start', 'DESC');
		if ($appointments != null)
		{
			$start = new DateTime($appointments[0]['appointment_start']);
			$data['occupation_rate_endDate'] = clone $start;
			$start->setTime(23,59,59);
			$today = new DateTime('today');
			$today->setTime(0,0,0);
			
			while ($start >= $today)
			{
				$apps = $this->appointment_model->Appointment_get('all', $start->format('Y-m-d'));
				foreach ($apps as $app)
				{
					$startApp = new DateTime($app['appointment_start']);
					$endApp = new DateTime($app['appointment_end']);
					$totalAppointments += $endApp->diff($startApp)->format('%i');
				}
	
				$totalOpenings += $this->doctor_model->Doctor_getNbOpeningMinutesOfTheDay($start);
	
				// On passe au jour d'avant
				$start->sub(new DateInterval('P1D'));
			}		
		}
		if ($totalOpenings == 0) $totalOpenings = 1;
		$data['occupation_rate'] = round(($totalAppointments / $totalOpenings) * 100, 1);
		
		// Nombre total de rendez-vous effectués
		$data['nb_appointments_done'] = $this->appointment_model->Appointment_count(array('appointment_done' => 1));

		// Clients actifs
		$data['active_customer'] = 0;
		$customers = $this->customer_model->Customer_get();
		foreach($customers as $customer)
		{
			$data['active_customer'] += $this->user_model->User_count(
				array('user_key' => $customer['customer_user_key'],
					  'user_actif' => 1
				)
			);
		}

		// Comptes inactifs
		$data['inactive_user'] = $this->user_model->User_count(array('user_actif' => 0));

		// Affichage de la vue
		$this->layout->show('backend/statistics', $data);
	}

}

/* End of file backend.php */
/* Location: ./application/controllers/backend.php */