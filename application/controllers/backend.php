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
		$this->load->model('medicalrecord_model');
		$this->load->model('medicalinfo_model');

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


	public function admin()
	{

		if ($this->session->userdata('user_right') != 3)
			show_404();
		// 7ème item du menu à highlight
		$this->config->set_item('user-nav-selected-menu', 7); 

		// Affichage de la vue
		$this->layout->show('backend/admin');

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

		$data['mean_age'] = $this->meanAge();
		$data['yellow_fever'] = $this->contraindicationYFcertificates();
		$data['particular_situation'] = $this->particularSituations();

		// En fonction des demandes du CVI boucler sur les différents pays et mois et boucler ensuite dans l'affiche d'un tableau ou d'un graphe par mois ou par destination
		$data['visited_coutriesEurope'] = $this->visitedCountries(8,5);
		$data['visited_coutriesAsie1'] = $this->visitedCountries(6,4);
		$data['visited_coutriesAsie2'] = $this->visitedCountries(7,4);
		$data['visited_coutriesGuadeloupe'] = $this->visitedCountries(8,99);


		// Affichage de la vue
		$this->layout->show('backend/statistics', $data);
	}

	// fonctions utiles aux statistiques

	// Fonction qui retourne l'âge moyen des voyageurs
	public function meanAge(){

		// On récupère tous les customers, on boucle sur eux
		// et on fait la moyenne d'âge
		$customers = $this->customer_model->Customer_get();

		$ages = 0;
		foreach($customers as $customer)
		{
			$birthdate = new DateTime($customer['customer_birthdate']);
			$age = $birthdate->diff(new DateTime())->format('%y');
			$ages += $age;

		}

		$all = $this->db->count_all('customer');

		$meanAge = $ages / $all ;

		// arrondi au dixième
		return ceil($meanAge/0.1)*0.1 ;


	}



	// nombre de certificats de contre indication pour le vaccin de la fièvre jaune
	public function contraindicationYFcertificates(){


	$records = $this->medicalrecord_model->MedicalRecord_get();

	$value =null;
	$nbcertificate=0;
	foreach($records as $record)
	{
		// si on trouve un enregistrement pour la contre-indication
		if(stripos($record['medicalRecord_yellowFever'], '"4":{"done":"') !== false)
			{
				// On récupère la position du début de l'enregistrement de la contre-indication
				$pos = strrpos($record['medicalRecord_yellowFever'], '"4":{"done":"');

				// On récupère la valeur Y ou N de la contre-indication, dont la valeur est à la 13ème position dans la chaine de caractères
				$value = substr($record['medicalRecord_yellowFever'], $pos+13, 1);
				
				// Si c'est Y ie si le patient a une contre-indication, on incrémente le nb de certificats
				if ($value == 'Y')
					$nbcertificate++;
			}
	}

	return $nbcertificate;

	}

	// vérifiées ici : grossesse-allaitement, maladies chroniques, allergies
	// NB : si une personne a plus d'une situation particulière elle n'est comptée qu'une fois
	public function particularSituations(){

		// (on parcourt les MedicalInfo)

		$infos = $this->medicalinfo_model->MedicalInfo_get();

		$nbsituations =0;
		foreach($infos as $info)
		{
			if ( ($info['medicalInfoPregnancy_id'] != null) || ($info['medicalInfo_allergies'] != null) || ($info['medicalInfo_chronicDiseases'] != null) )
				$nbsituations++;
		}

		return $nbsituations;
	}


	// gérer l'affichage ensuite
	public function visitedCountries($month, $country){ //$month, $country
	
	// On récupère tous les rendez-vous dans appointment country
	// On teste pour chaque si l'id du pays correspond
		// si c'est le cas on récupère l'id du rdv
		// on va dans la table rdv et on vérifie si le mois correpond
		// si c'est la cas on incrémente la valeur result

	// On récupère tous les rendez-vous dans appointment country
       $results = $this->db->select('*')
				->from('appointmentCountry')
				->get()
				->result_array();

		$res =0;
		foreach($results as $result){


			if ($result['country_id'] == $country)

			{

				$appointment_id = $result['appointment_id'];
				$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);

				$datedep = date('m',strtotime($appointment['appointment_departure']));
				$dateret = date('m',strtotime($appointment['appointment_return']));

				echo $datedep;
				echo $dateret;


				if ( $datedep == $month || $dateret == $month){

					$res++;
				}

			}

		}
			
		return $res;

	}


	// nombre de vaccins réalisés par mois et par vaccins // on pourra faire de même pr les traitements // idem que visitedCountries il faudra boucler sur 
	// la fonction pour l'affichage dans la vue 
	public function nbVaccinations($vac, $month){

		// on parcourt la table historicVaccin
		// on teste si le mois correspond

		// ou bien on fait une requête qui récupère tous les vaccins faits tel mois

		// ensuite on teste si ça correspond au vaccin et on incrémente une variable

	}


	// Non implémentées

	// nombre d'incidents post-vaccination  // pourra être implémentée après le module de retour voyageur
	public function postVaccinationIncidents(){

	// on devra parcourir les rdv passés (appointment_done)
	// et aller chercher dans la table associée qui recense les réponses du module retour voyageur

	}


	// rajouter un attribut dans appointment pour vaccination ou non 
	// rajouter un pop up lors de l'appui sur le bouton "terminer consultation" avec un choix
	// Rdv avec ou sans vac ? ou bien rajouter dans l'interface un bouton à cocher genre "rdv avec vaccination" pour enregistrer ds la bdd

	public function appointmentsWithoutVaccinations(){


	}


}

/* End of file backend.php */
/* Location: ./application/controllers/backend.php */