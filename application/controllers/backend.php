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
 * @author		Alizée Buatois
 *
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

		public function create2($doctor_key = '')
	{
		$this->config->set_item('user-nav-selected-menu', 1); // 3ème item du menu à highlight

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
	
		$this->config->set_item('user-nav-selected-menu', 7);

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

	// fonctions utilises aux statistiques

	// Fonction qui retourne l'âge moyen des voyageurs
	public function meanAge(){

		// On récupère tous les customers, on boucle sur eux
		// et on fait la moyenne d'âge

	}

	// rajouter un attribut dans appointment pour vaccination ou non 
	// rajouter un pop up lors de l'appui sur le bouton "terminer consultation" avec un choix
	// Rdv avec ou sans vac ? ou bien rajouter dans l'interface un bouton à cocher genre "rdv avec vaccination" pour enregistrer ds la bdd

	public function appointmentsWithoutVaccinations(){


	}


	// gérer l'affichage ensuite
	public function visitedCountries($month, $country){

	// récupérer tous les rendez-vous du mois (month)
	// les parcourir
		// récupérer leur id et en fonction de cet id
		// récupérer l'id de country correspondant dans la table appointemant country
		// aller chercher le nom du pays (si c'est le nom passé en param sinon pas besoin de cette requette) pays correspondant à cet id dans la table country
		// si il correspond à "country" le compter (l'ajouter dans une variable)

	// on aura alors compté le nombre de visites dans tel pays

	}

	// à voir : grossesse, allaitement, maladies chroniques
	public function particularSituations(){

		// (on parcourt les customers)
		// on regarde leurs champs yellowfever, medicalInfoPregnancy, medicalinfo 
		// on compte le nombre d'id pr par exemple les maladies chroniques car stockées en json
	}

	// nombre d'incidents post-vaccination
	public function postVaccinationIncidents(){

	// on devra parcourir les rdv passés (appointment_done)
	// et aller chercher dans la table associée qui recense les réponses du module retour voyageur

	}


	// nombre de certificat de contre indication pour le vaccin de la fièvre jaune
	public function contraindicationYFcertificates(){

		// medicalRecord -> yellowfever -> compter en json
	}

	// nombre de vaccins réalisés par mois et par vaccins // on pourra faire de même pr les traitements // idem que visitedCountries il faudra boucler sur 
	// la fonction pour l'affichage dans la vue 
	public function nbVaccinations($vac, $month){

		// on parcourt la table historicVaccin
		// on teste si le mois correspond

		// ou bien on fait une requête qui récupère tous les vaccins faits tel mois

		// ensuite on teste si ça correspond au vaccin et on incrémente une variable

	}


	public function admin()
	{

		if ($this->session->userdata('user_right') != 3)
			show_404();
		// 7ème item du menu à highlight
		$this->config->set_item('user-nav-selected-menu', 7); 

		// Affichage de la vue
		$this->layout->show('backend/admin');

	}

}

/* End of file backend.php */
/* Location: ./application/controllers/backend.php */