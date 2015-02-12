<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Appointment Controller Class
 *
 * @author		Clément Tessier
 * @author 		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Appointment extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('appointment_model');
		$this->load->model('hosting_model');
		$this->load->model('activity_model');
		$this->load->model('user_model');		
		$this->load->model('customer_model');
		$this->load->model('doctor_model');
		$this->load->model('country_model');		

		// Il est dans tous les cas nécessaire d'être connecté pour accéder à cette classe
		if (!$this->session->userdata('connected'))
		{
			redirect('login');
		}
	}

	/**
	 * Index : liste les rendez-vous du client connecté ou de celui donné en paramètre
	 */
	public function index($user_key = '')
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------

		$this->config->set_item('user-nav-selected-menu', 4); // item 4 du menu à highlight

		if ($user_key == '')
		{
			$user_key = $this->session->userdata('user_key');
		}
		else
		{
			if ($user_key != $this->session->userdata('user_key') && $this->session->userdata('user_right') == 0)
			{
				redirect('appointment');
			}
		}


		// On récupère les rendez-vous du compte utilisateur
		$appointments = $this->appointment_model->Appointment_getFromUserKey($user_key);

		// Séparation des rendez-vous passés et à venir
		$data['previousAppointments'] = array();
		$data['nextAppointments'] = array();
		foreach ($appointments as $appointment)
		{
			$appointment_start = new DateTime($appointment['appointment_start']);
			$now = new DateTime();
			if ($appointment_start >= $now)
			{
				array_push($data['nextAppointments'], $appointment);
			}
			else
			{
				array_push($data['previousAppointments'], $appointment);
			}
		}
		
		// Affichage de la vue
		$this->layout->show('appointment/index', $data);
	}

	/**
	 * View : Affiche les détails d'un rendez-vous pour le client
	 */
	public function view($appointment_id = '')
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------

		if (empty($appointment_id)) // redirection si pas d'id de rendez-vous donné en paramètre
			redirect('appointment');

		// On récupère les informations du rendez-vous
		$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);
		if ($appointment == null || $appointment['appointment_user_key'] != $this->session->userdata('user_key'))
		{
			// Le rendez-vous n'existe pas ou on est pas autorise à afficher les infos			
			if ($appointment != null)
			{
				// Le rendez-vous existe
				
				// On regarde si le client connecté est en droit d'afficher les infos
				$allowed = false;

				// Peut-être qu'un profil du compte connecté est concerné par ce rendez-vous...
				$customers_key = $this->appointment_model->Appointment_getCustomers($appointment_id);
				foreach($customers_key as $customer_key) // parcours des clients concernés par le rendez-vous
				{
					$customer = $this->customer_model->Customer_getFromKey($customer_key);
					if ($customer != null && $customer[0]['customer_user_key'] == $this->session->userdata('user_key'))
						$allowed = true;
				}
				if (!$allowed)
				{
					show_404();
				}
			}
			else
			{
				show_404(); // le rendez-vous n'existe pas
			}
		}

		$this->config->set_item('user-nav-selected-menu', 4); // menu item 4 à highlight

		// On récupère les membres
		$appointment['appointment_customers'] = $this->appointment_model->Appointment_getCustomers($appointment_id);
		// On récupère les destinations
		$appointment['appointment_destinations'] = $this->appointment_model->Appointment_getCountries($appointment_id);
		// On récupères les hébergements
		$appointment['appointment_hostings'] = $this->appointment_model->Appointment_getHostings($appointment_id);
		// On récupère les activitiés
		$appointment['appointment_activities'] = $this->appointment_model->Appointment_getActivities($appointment_id);
		// Affichage de la vue
		$this->layout->show('appointment/view', $appointment);
	}


	public function make($step = '')
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		//if ($this->session->userdata('user_right') > 0)	   //
		//	show_404();									   //
		// --------------------------------------------------
		if ($this->session->userdata('user_right') > 0)
			$this->config->set_item('user-nav-selected-menu', 6);
		else
			$this->config->set_item('user-nav-selected-menu', 4);

		if ($step == '') // première étape
		{
			$data = array();
 
 			if ($this->session->userdata('user_right') > 0)
				{   // on récupère l'id passé ds l'URL
					$user_key = $_GET["user-selected"];
					$this->session->set_userdata('appointment_user_key', $user_key);

				}
			else
			{
			$user_key = $this->session->userdata('user_key');
			$this->session->set_userdata('appointment_user_key', $user_key);
			}

			//$user_key = $this->session->userdata("user_key_clicked");
			//$this->session->set_userdata('appointment_user_key', $this->session->userdata("user_key_clicked"));

			//$this->session->userdata("user_key_clicked") = $user_key;

			//$data['user_key'] = $user_key;
			$data['family'] = $this->customer_model->Customer_getAllFamily($user_key);	

			// Affichage du la vue, première étape!
			$this->layout->show('appointment/make', $data, $user_key);
		}
		else //-----------------------------------------AJAX CALL--------------------------------//
		{
			// Si il n'y a aucun POST, la page a été appelée comme ça. On redirige.
			if (!$_POST)
			{

				redirect('appointment/make');

			}

			switch ($step)
			{
				case 1:
				
					// Validation étape 1 : Choix des membres
					echo $this->validate_members($this->input->post('members'));
					break;

				case 2:
					// Validation étape 2 : Choix des dates
					$departure = reverse_date(str_replace('/','-',$this->input->post('departureDate')));
					$return = reverse_date(str_replace('/','-',$this->input->post('returnDate')));
					echo $this->validate_travelling_dates($departure, $return);	
					break;

				case 3:
					// Validation étape 3 : Choix des destinations
					echo $this->validate_destinations($this->input->post('destinations'));
					break;

				case 4: 
					// Validation étape 4 : Choix des hébergements
					echo $this->validate_hostings($this->input->post('hostings'));
					break;

				case 5: 

					// Validation étape 5 : Choix des activités
					echo $this->validate_activities($this->input->post('activities'));
					break;

				case 6:
					/*
						Validation étape 6 : Date du rendez-vous
						------------------------------------------------------------------
						Cette étape effectue également une revalidation de l'ensemble
						des autres parties du formulaire avant d'envoyer les données pour
						afficher la page de confirmation (récapitulatif du formulaire)
					*/
					//$user_key = $_GET["user-selected"];
					
					// Tableau en cas d'erreur sur une des étapes
					$data = array('success' => true);
				 	$data['error-members']['message'] = '';
                    $data['error-travelling-date']['message'] = '';
                    $data['error-destinations']['message'] = '';
                    $data['error-hostings']['message'] = '';
                    $data['error-activities']['message'] = '';
                    $data['error-datetime']['message'] = '';

					// Vérification des members
					if (($message = $this->validate_members($this->input->post('members'))) === true)
					{
						// Les membres sont validés
						// On prépare l'affichage pour la page de récapitulation
						$data['displayed-members'] = '';
						foreach ($this->session->userdata('appointment_members') as $member_key)
						{
							$data['displayed-members'] .= $this->customer_model->Customer_getFullName($member_key) . '<br />';
						}
					}
					else
					{
						// Les membres contiennent une erreur
						// L'erreur est ajoutée
						$data['success'] = false;
						$data['error-members'] = json_decode($message); 
					}
					
					// Vérification des dates du voyage
					$departure = reverse_date(str_replace('/','-',$this->input->post('departureDate')));
					$return = reverse_date(str_replace('/','-',$this->input->post('returnDate')));
					if (($message = $this->validate_travelling_dates($departure, $return)) === true)
					{
						// Les dates sont validées
						// On prépare l'affichage pour la page de récapitulation
						$data['displayed-travelling-date'] = '';
						$data['displayed-travelling-date'] .= 'Départ : ' . full_date($this->session->userdata('appointment_departure'),false) . '<br />';
						if ($this->session->userdata('appointment_return') != '')
						{
							$data['displayed-travelling-date'] .= 'Retour : ' . full_date($this->session->userdata('appointment_return'),false);
						}
						else
						{
							$data['displayed-travelling-date'] .= 'Retour : <i>Non spécifiée</i>';
						}
					}
					else
					{
						// Erreur avec les dates
						// On ajoute le message d'erreur
						$data['success'] = false;
						$data['error-travelling-date'] = json_decode($message); 
					}
					
					// Vérification des destinations
					if (($message = $this->validate_destinations($this->input->post('destinations'))) === true)
					{
						// Les destinations sont validées
						// On prépare l'affichage pour la page de récap
						$data['displayed-destinations'] = '';
						$nbDestinations = count($this->session->userdata('appointment_destinations'));
						$i = 0;
						foreach ($this->session->userdata('appointment_destinations') as $destination)
						{							
							$data['displayed-destinations'] .= $this->country_model->Country_getLabelById($destination);
							if (++$i < $nbDestinations)
							{
								$data['displayed-destinations'] .= ', ';
							}							
						}
					}
					else
					{
						// Erreur avec les destinations
						// L'erreur est ajoutée
						$data['success'] = false;
						$data['error-destinations'] = json_decode($message); 
					}
					
					// Vérification des hébergements
					if (($message = $this->validate_hostings($this->input->post('hostings'))) === true)
					{
						// Les hébergements sont validés
						// On prépare l'affichage pour le récap
						$data['displayed-hostings'] = '';
						$nbHostings = count($this->session->userdata('appointment_hostings'));
						$i = 0;
						foreach ($this->session->userdata('appointment_hostings') as $hosting)
						{							
							$hosting = $this->hosting_model->Hosting_getLabelById($hosting);
							if (++$i == 1)
								$data['displayed-hostings'] .= ucfirst($hosting);
							else
								$data['displayed-hostings'] .= $hosting;
							if ($i < $nbHostings)
							{
								$data['displayed-hostings'] .= ', ';
							}							
						}
					}
					else
					{
						// Erreur avec les hébergements
						// On ajoute l'erreur
						$data['success'] = false;
						$data['error-hostings'] = json_decode($message); 
					}
					
					// Vérification des activités
					if (($message = $this->validate_activities($this->input->post('activities'))) === true)
					{
						// Les activités sont validées
						// On prépare l'affichage pour le récap
						$data['displayed-activities'] = '';
						$nbHostings = count($this->session->userdata('appointment_activities'));
						$i = 0;
						foreach ($this->session->userdata('appointment_activities') as $activity)
						{				
							$activity = $this->activity_model->Activity_getLabelById($activity);			
							if (++$i == 1)
								$data['displayed-activities'] .= ucfirst($activity);
							else
								$data['displayed-activities'] .= $activity;
							if ($i < $nbHostings)
							{
								$data['displayed-activities'] .= ', ';
							}							
						}
					}
					else
					{
						// Erreur avec les activités
						// On ajoute l'erreur
						$data['success'] = false;
						$data['error-activities'] = json_decode($message);
					}					

					// Vérification de la date de rendez-vous
					$dateTimeStart = new DateTime($this->input->post('appointmentDate'));
					if (($message = $this->validate_appointmentDate($dateTimeStart)) === true)
					{
						// On a re-vérifie la disponibilité du créneau et c'est bon	
						// On prépare l'affichage pour le récap				
						$date = $this->session->userdata('appointment_datetimeStart');						
						$data['displayed-datetime'] = $date->format('d/m/Y H\hi');
					}
					else
					{
						// La date n'est plus disponible ou y'a une erreur
						// On ajoute l'erreur
						$data['success'] = false;
						$data['error-datetime'] = json_decode($message);
					}

					echo json_encode($data);
					break;

				case 7:
					// Confirmation
					$this->create(); // CREATION DU RENDEZ-VOUS DANS LA BDD
					break;

				default:
				break;
			}
		}
	}


	
	/**
	 * create : Créer le rendez-vous dans la base de données
	 *			Les informations sont tirés des variables sessions créées lors de la validation du formulaire
	 *			La disponibilité de la date du rendez-vous est revérifier une dernière fois
	 */
	public function create()
	{
		// On récupère l'ensemble des infos depuis les variables SESSION

		

		$members = $this->session->userdata('appointment_members');
		$departureDate = $this->session->userdata('appointment_departure');
		$returnDate = $this->session->userdata('appointment_return');
		$destinations = $this->session->userdata('appointment_destinations');
		$hostings = $this->session->userdata('appointment_hostings');
		$activities = $this->session->userdata('appointment_activities');
		$datetimeStart = $this->session->userdata('appointment_datetimeStart');
		$dateTimeEnd = $this->session->userdata('appointment_datetimeEnd');
		$doctor_key = $this->session->userdata('appointment_doctor_key');
		$user_key = $this->session->userdata('appointment_user_key');
		$user_creator_key = $this->session->userdata('user_key');

		// Dernière vérification
		$error_message = '';



		// liste des membres
		if (($message = $this->validate_members($members)) !== true)
		{
			$message = json_decode($message, true);
			$error_message .= $message['message'] . '<br />';
		}
		// dates du voyage
		if (($message = $this->validate_travelling_dates($departureDate, $returnDate)) !== true)
		{
			$message = json_decode($message, true);
			$error_message .= $message['message'] . '<br />';
		}
		// destinations
		if (($message = $this->validate_destinations($destinations)) !== true)
		{
			$message = json_decode($message, true);
			$error_message .= $message['message'] . '<br />';
		}
		// hébergements
		if (($message = $this->validate_hostings($hostings)) !== true)
		{
			$message = json_decode($message, true);
			$error_message .= $message['message'] . '<br />';
		}
		// activities
		if (($message = $this->validate_activities($activities)) !== true)
		{
			$message = json_decode($message, true);
			$error_message .= $message['message'] . '<br />';
		}			

		if ($error_message == '')
		{
			// On crée le rendez-vous
			if ($this->appointment_model->Appointment_create(
				$members,
				$departureDate,
				$returnDate,
				$destinations,
				$hostings,
				$activities,
				$datetimeStart,
				$dateTimeEnd,
				$doctor_key,
				$user_key,
				$user_creator_key
				))
			{				
				// On récupère les clés de tous les utilisateurs concernés
				$users_keys = array();
				foreach($members as $customer_key)
				{
					$customer = $this->customer_model->Customer_getFromKey($customer_key);
					if ($customer != null)
					{	
						if (!in_array($customer[0]['customer_user_key'], $users_keys))
						{
							array_push($users_keys, $customer[0]['customer_user_key']);
						}
					}							
				}
				// Envoi des mails
				foreach	($users_keys as $user_key)
				{					
					$user = $this->user_model->User_getFromKey($user_key);
					if ($user != null)
					{
						$user = $user[0];
						$this->email->from($this->parameters_model->Parameters_getEmailContact(), 'Centre de Vaccinations Internationales de Tours');
						$this->email->to($user['user_email']);
						$this->email->subject('Vous avez rendez-vous');
						$data['message'] = 'Ce message est pour vous informer que nous avons bien enregistré votre demande de rendez-vous du ' . substr(full_date($datetimeStart->format('Y-m-d H:i:s')), 0, -3) . '.</p>';
						$data['message'] .= '<p>Vous trouverez ci-dessous un récapitulatif de votre demande :</p>';
						$data['message'] .= '<p>Vous êtes attendu au Centre de Vaccinations Internationales du CHRU de Tours le ' . substr(full_date($datetimeStart->format('Y-m-d H:i:s')), 0, -3) . ' muni des documents suivants : Carte Vitale, Carnet de Santé et de Vaccinations.</p>';
						$data['message'] .= '<p>Si vous avez un traitement en cours, pensez aussi à emmener votre ordonnance.</p>';
						$this->email->message($this->load->view('template/email', $data, true));
						$data['fullName'] = $this->user_model->User_getMainName($user['user_key']);
						$this->email->send();	
					}
				}
				
				// On crée le message de succès
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Félicitations ! Votre rendez-vous a bien été enregistré.'));
				$data['success'] = true;
			}


			// On vide les variables de session !!
			$this->session->unset_userdata(
				array(
					'appointment_members' => '',
					'appointment_departure' => '',
					'appointment_return' => '',
					'appointment_hostings' => '',
					'appointment_activities' => '',
					'appointment_datetimeStart' => '',
					'appointment_datetimeEnd' => '',
					'appointment_doctor_key' => ''
				)
			);
		}
		else
		{
			// on affiche les messages d'erreur
			$data['success'] = false;
			$data['message'] = $error_message;
		}		
		echo json_encode($data);
	}

	/** 
	 * validate_members : Fonction de vérification de l'étape 1 : Choix des membres
	 */
	private function validate_members($members)
	{

		if ($members == false)
		{
			return json_encode(array('message' => 'Vous devez sélectionner au moins une personne.'));
		}
		else
		{
			// Le nombre de membre sélectionné doit pas dépasser la valeur indiquée dans les paramètres de l'app
			if (count($members) > ($nb=$this->parameters_model->Parameters_getAppointmentNbMaxCustomer()))
			{
				return json_encode(array('message' => 'Vous ne pouvez sélectionner qu\'un maximum de '.$nb.' membres.<br />Merci de privilégier plusieurs rendez-vous.'));
			}
		}
		
		// On vérifie l'existance de tous les voyageurs sélectionnés
		foreach ($members as $member)
		{	
			$customer_key = $member;
			$user_key = $this->customer_model->getCustomerUserKeyByCustomerKey($customer_key);
			if (!$this->customer_model->Customer_exists($member, $user_key))
			{
				return json_encode(array('message' => 'Un des voyageurs sélectionné n\'existe pas.'));
			}

		}

		// C'est bon, on met les membres en session et renvoi true
		$this->session->set_userdata('appointment_members', $members);
		return true;
	}

	/**
	 * validate_travelling_dates : Fonction de vérification de l'étape 2 : Dates du voyage
	 */
	private function validate_travelling_dates($departure, $return)
	{
		// Vérification du format de la date de départ
		$checkDeparture = explode('-', $departure);
		if (count($checkDeparture) != 3 || !checkdate($checkDeparture[1], $checkDeparture[2], $checkDeparture[0]))
		{
			return json_encode(array('message' => 'Le format de date est incorrect.'.$departure));
		}
		
		// Vérifications de la date de retour
		if ($departure != '')
		{
			if ($return != '')
			{
				// Vérification du format de la date de retour
				$checkReturn = explode('-', $return);
				if (count($checkReturn) != 3 || !checkdate($checkReturn[1], $checkReturn[2], $checkReturn[0]))
				{
					return json_encode(array('message' => 'Le format de date est incorrect.'));
				}
				// La date de retour doit être supérieur à la date d'aller
				else if (strtotime($return) < strtotime($departure))
				{
					return json_encode(array('message' => 'La date de retour ne peut pas être inférieure à la date de départ.'));
				}
			}						
		}
		else
		{
			return json_encode(array('message' => 'Vous devez sélectionner une date de départ.'));
		}

		// C'est bon, on met les valeurs en session et renvoi true
		$this->session->set_userdata('appointment_departure', $departure);
		$this->session->set_userdata('appointment_return', $return);
		return true;	
	}

	/**
	 * validate_destinations : Fonction de vérification de l'étape 3 : Destinations
	 */
	private function validate_destinations($destinations)
	{
		// On vérifie qu'il y a au moins 1 destination
		$destinations = array_filter($destinations, "not_null");
		if (empty($destinations))
		{
			return json_encode(array('message' => 'Vous devez sélectionner au moins une destination.'));
		}
		
		// C'est bon, on met les destinations en session et renvoie true
		$this->session->set_userdata('appointment_destinations', $destinations);
		return true;
	}

	/**
	 * validate_hostings : Fonction de vérification de l'étape 4 : Héberhements
	 */
	private function validate_hostings($hostings)
	{
		// On vérifie qu'il y a au moins un hébergement
		if ($hostings == false)
		{
			return json_encode(array('message' => 'Vous devez sélectionner au minimum un type d\'hébergement.'));
		}
		
		// C'est bon, on met en session et on renvoie True
		$this->session->set_userdata('appointment_hostings', $hostings);
		return true;
	}

	/**
	 * validate_activities : Fonction de vérification de l'étape 5 : Activités
	 */
	private function validate_activities($activities)
	{
		// On vérifie qu'il y a au moins une activité
		if ($activities == false)
		{
			return json_encode(array('message' => 'Vous devez sélectionner au minimum une activité.'));
		}

		// C'est bon, on met en session et on renvoie True
		$this->session->set_userdata('appointment_activities', $activities);
		return true;
	}

	/**
	 * validate_appointmentDate : Fonction de vérification de l'étape 6 : Date du rendez-vous
	 */
	private function validate_appointmentDate($appointmentDate)
	{
		$now = new DateTime();
		
		// On vérifie qu'une suggestion de date à bien été proposée par le client
		if (empty($appointmentDate) && $appointmentDate == '')
		{
			return json_encode(array('message' => 'Vous devez sélectionner un créneau.'));
		}

		// Cas où aucune date n'est choisi, le champ renvoi alors la date actuelle
		if ($now->getTimestamp() === $appointmentDate->getTimestamp())
		{
			return json_encode(array('message' => 'Vous devez sélectionner un créneau.'));
		}

		// On re-regarde s'il s'agit d'un long voyage
		$isLongTrip = $this->isLongTrip(
			$this->session->userdata('appointment_departure'), 
			$this->session->userdata('appointment_return')
		);
		// On re-calcule la durée de la consultation
		$duration = $this->calculateAppointmentDuration(
			$this->session->userdata('appointment_members'), 
			$isLongTrip
		);
		// On regarde le type de doctor requis
		$doctor_type = $this->getAppointmentDoctorType(
			$this->session->userdata('appointment_members'),
			$isLongTrip
		);

		// On calcule la date de début du rendez-vous ainsi que la date de fin du rendez-vous
		$selectedDateTimeStart = $appointmentDate;
		$selectedDateTimeEnd = clone $selectedDateTimeStart;
		$selectedDateTimeEnd->add(new DateInterval('PT'.$duration.'M'));

		// On vérifie que la date du rendez-vous peut coller avec les dates du voyages
		$departure = new DateTime($this->session->userdata('appointment_departure'));
		
		$maxDate = clone $departure;
		// Date maximum du rendez-vous 1 mois avant le départ pour un voyage long, 10 jour pour un voyage court
		$maxDate = ($isLongTrip) ? $maxDate->sub(new DateInterval('P1M')) : $maxDate->sub(new DateInterval('P10D'));

		// On vérifie également la date du retour par rapport à la date du rendez-vous
		if ($this->session->userdata('appointment_return') != '')
		{
			$return = new DateTime($this->session->userdata('appointment_return'));
			if ($selectedDateTimeStart > $return)
			{
				return json_encode(array('message' => 'Vous ne pouvez pas prendre rendez-vous après votre voyage.'));
			}
		}

		// On vérifie que la date du rendez-vous est plausible
		if ($selectedDateTimeStart > $departure)
		{
			return json_encode(array('message' => 'Vous serez en voyage ce jour là !'));
		}
		else if ($selectedDateTimeStart > $maxDate)
		{
			return json_encode(array('message' => 'La date de rendez-vous est trop proche de la date de départ.'));
		}

		// La date est okay, on vérifie la disponibilité
		if (($doctor_key = $this->appointment_model->Appointment_isAvailable(
					$selectedDateTimeStart, $selectedDateTimeEnd, $doctor_type)) != null)
		{
			$this->session->set_userdata('appointment_datetimeStart', $selectedDateTimeStart);
			$this->session->set_userdata('appointment_datetimeEnd', $selectedDateTimeEnd);
			$this->session->set_userdata('appointment_doctor_key', $doctor_key);
			return true;
		}
		else
		{
			return json_encode(array('message' => 'Cette date de rendez-vous n\'est pas disponible.'));
		}

	}

	/**
	 * calculateAppointmentDuration : Calcule la durée nécessaire pour le rendez-vous
	 *
	 * Dans le cas d’un rendez-vous n’incluant qu’une seule personne, celui-ci doit avoir 
	 * une durée de 15 minutes. Cependant, s’il s’agit d’un voyage d’une durée de plus d’un mois, 
	 * la consultation doit être prévue pour 30 minutes.
	 * Dans le cas d’un rendez-vous incluant plusieurs personnes, il s’agit ici de compter 10 minutes 
	 * par personne et de s’assurer d’un total d’au moins 30 minutes dans le cas d’un voyage long (au moins 1 mois).
	 *
	 * @param $members 			Tableau des clients concerné par le rendez-vous
	 * @param $isLongTrip 		Booléan indiquant s'il s'agit d'un long voyage ou non
	 * @return Durée nécessaire pour le rendez-vous
	 *
	 */
	private function calculateAppointmentDuration($members, $isLongTrip)
	{
		// Nombre de client concerné
		$nbMembers = count($members);

		if ($nbMembers == 1)
		{
			if ($isLongTrip)
			{
				// Il s'agit d'un long voyage pour une seule personne
				return $this->parameters_model->Parameters_getAppointmentLongTripMinDuration();
			}
			else
			{
				// Il s'agit d'un petit voyage pour une seule personne
				return $this->parameters_model->Parameters_getAppointment1Pduration();
			}
		}
		else
		{
			$totalDuration = $nbMembers * $this->parameters_model->Parameters_getAppointmentNPdurationPP();
			if ($isLongTrip)
			{
				// Dans le cas d'un long voyage, on s'assure que la durée 
				// est d'au moins celle requis pour un long voyage.
				if (!$isLongTrip)
				{
					return $totalDuration;
				}
				else
				{
					// Si tel n'est pas le cas, on renvoi la durée minimum pour ce type de voyage
					return $this->parameters_model->Parameters_getAppointmentLongTripMinDuration();
				}
			}
			return $totalDuration;
		}
	}

	/**
	 * getAppointmentDoctorType : Décide si la consultation doit être assurée par un médecin (1) ou une infirmière (0)
	 *
	 * Si le rendez-vous n’inclue aucun enfant agé de moins de 10 ans, la consultation sera assurée par une infirmière. 
	 * De même si les adultes à vacciner ne sont pas atteints de maladies particulières (comme le demande le formulaire
	 * sur les informations médicales). Dans les cas contraires, les vaccinations sont déléguées à un médecin.
	 * Cependant, dans le cas d’un voyage supérieur à 1 mois, la consultation devra automatiquement être assurée par un médecin.
	 *
	 * @param $members 			Tableau des clients concernés par le rendez-vous
	 * @param $isLongTrip 		Booléan indiquant s'il s'agit d'un long voyage ou non
	 * @return int(1)			Médecin ou infirimère
	 *
	 */
	private function getAppointmentDoctorType($members, $isLongTrip)
	{
		if ($isLongTrip)
		{
			return 2;
		}	

		else
		{
			// On regarde si y'a des enfants ou des maladies particulières
			foreach($members as $member_key)
			{
				if ($this->customer_model->Customer_isChild($member_key))
					return 2;
				if ($this->customer_model->Customer_hasDisease($member_key, array('diseaseRecentFever','chronicDiseases')))
					return 2;
			}
			return 1;
		}
	}

	/** 
	 * getPropositions : retourne un ensemble de 3 propositions de date de rendez-vous
	 *					 AJAX CALL
	 */
	public function getPropositions()
	{
		$date1 = $this->input->get('date1');
		//$date2 = $this->input->get('date2');
		$option1 = $this->input->get('option1');
		$option2 = $this->input->get('option2');

		$options = array('am','pm');

		$propositions = array();

		if (!empty($date1) && in_array($option1,$options))
		{
			// On vérifie les données nécessaires à la recherche de créneau
			$error = false;
			$message = '';
			if ($this->validate_members($this->session->userdata('appointment_members')) !== true)
			{
				$error = true;
				$message .= 'La sélection des voyageurs est incorrecte.<br />';
			}
			$checkDate = explode('-', $this->session->userdata('appointment_departure'));
			if (count($checkDate) != 3 || !checkDate($checkDate[1], $checkDate[2], $checkDate[0]))
			{
				$error = true;
				$message .= 'La date de départ est invalide.<br />';
			}
			if ($error)
			{
				echo '<div class="row"><div class="columns large-12"><div data-alert class="alert-box warning radius">';
				echo $message . '<br />Ces informations sont nécessaires pour la recherche de créneaux disponibles.';
				echo '<a href="#" class="close">&times;</a></div></div></div>';
				return;
			}			

			// Initialisation de l'algorithme
			$startDate = new DateTime($date1);
			$startOption = $option1;
			$departureDate = new DateTime($this->session->userdata('appointment_departure'));
			$isLongTrip = $this->isLongTrip($this->session->userdata('appointment_departure'), $this->session->userdata('appointment_return'));

			$appointmentDuration = $this->calculateAppointmentDuration($this->session->userdata('appointment_members'), $isLongTrip);
			$doctor_type = $this->getAppointmentDoctorType($this->session->userdata('appointment_members'), $isLongTrip);
			// Booléens si les bornes ont été dépassées
			$tooEarly = 0;
			$tooLate = 0;
			// Booléens indiquant qu'une demi-journée a été parcourue
			$amChecked = false;
			$pmChecked = false;
			$currentOption = $startOption;
			// Compteur et facteur permettant le parcours des dates autour de celle souhaitée
			$count = 1;
			$factor = (+1);

			// Calcul des bornes de recherche
			$minDate = new DateTime('tomorrow');

			$maxDate = clone $departureDate;
			if ($isLongTrip)
				$maxDate->sub(new DateInterval('P1M'));
			else
				$maxDate->sub(new DateInterval('P10D'));

			// Intervals
			$emergencySlotDuration = new DateInterval('PT' . $this->parameters_model->Parameters_getAppointmentEmergencySlotDuration() . 'M');
			$propositionsInterval = new DateInterval('PT1H');
			$searchInterval = new DateInterval('PT15M');

			// On vérifie la date du rendez-vous par rapport au départ et la date de rendez-vous maximum
			if ($startDate > $departureDate)
			{
				echo '<div class="row"><div class="columns large-12"><div data-alert class="alert-box warning radius">';
				echo 'Vous devez prendre rendez-vous avant votre départ.';
				echo '<a href="#" class="close">&times;</a></div></div></div>';
				return;
			}
			if ($startDate > $maxDate)
			{
				echo '<div class="row"><div class="columns large-12"><div data-alert class="alert-box warning radius">';
				echo 'La date désirée est trop proche de la date de départ.';
				echo '<a href="#" class="close">&times;</a></div></div></div>';
				return;
			}

			// On cherche les créneaux disponibles
			do
			{
				// Heure d'ouverture du centre à la date de recherche (issu des timetable des docteurs)
				$currentAppointmentStart = $this->doctor_model->Doctor_getOpeningHour($startDate, $currentOption);

				if ($currentAppointmentStart != null)
				{
					// Calcule du premier créneau plausible et sa durée
					$currentAppointmentStart->add($emergencySlotDuration);
					$currentAppointmentEnd = clone $currentAppointmentStart;
					$currentAppointmentEnd->add(new DateInterval('PT'.$appointmentDuration.'M'));

					// On regarde si le créneau courant est plausible
					if ($currentAppointmentStart < $minDate)
					{
						$tooEarly = true;
					}
					if ($currentAppointmentEnd > $maxDate)
					{
						$tooLate = true;
					}
					if ($currentOption == 'am')
						$amChecked = true;
					if ($currentOption == 'pm')
						$pmChecked = true;
					
					// On s'assure qu'on dépasse pas l'horaire de fermeture du centre
					$closingHour = $this->doctor_model->Doctor_getClosingHour($startDate, $currentOption);
					$closingHour->sub($emergencySlotDuration);

					// Parcours des créneaux de la journée
					while ($currentAppointmentEnd <= $closingHour && count($propositions) < 3)
					{
						// On regarde si un docteur est disponible sur ce créneau
						if (($doctor_key = $this->appointment_model->Appointment_isAvailable(
							$currentAppointmentStart, $currentAppointmentEnd, $doctor_type)) != null)
						{
							// Un docteur est disponible, on garde la proposition
							array_push($propositions, clone $currentAppointmentStart);
							$currentAppointmentStart->add(new DateInterval('PT55M'));	// propositions séparées d'au moins 1h (55m plus l'ajout des 5m ensuite)
						}
						// Pas de disponibilité, on va voir 5 minutes plus tard
						$currentAppointmentStart->add(new DateInterval('PT5M'));		// test des disponibilités toutes les 5 minutes
						// On recalcule la date de fin du rendez-vous
						$currentAppointmentEnd = clone $currentAppointmentStart;
						$currentAppointmentEnd->add(new DateInterval('PT'.$appointmentDuration.'M'));
					}
				}
				else
				{
					if ($currentOption == 'am')
						$amChecked = true;
					if ($currentOption == 'pm')
						$pmChecked = true;
				}

				// On change de jour si le matin et l'après-midi ont été parcourus
				if ($amChecked && $pmChecked)
				{
					// Réinitialisation
					$amChecked = false;
					$pmChecked = false;
					$currentOption = $startOption;

					// On passe au jour suivant
					if ($tooEarly)
						$startDate->add(new DateInterval('P1D'));
					else if ($tooLate)
						$startDate->sub(new DateInterval('P1D'));
					else
					{
						if ($factor < 0)
							$startDate->sub(new DateInterval('P'.$count.'D'));
						else
							$startDate->add(new DateInterval('P'.$count.'D'));
						$count++;
						$factor *= -1;
					}
				}
				// On regarde l'autre demi-journée 
				else
				{
					if ($amChecked)
						$currentOption = 'pm';
					else
						$currentOption = 'am';
				}
			}
			while (count($propositions) < 3 && (!$tooEarly || !$tooLate)); // algo tant qu'on a pas 3 propositions
																		   // et qu'on est dans les bornes

		}
		else
		{
			// Erreur de saisie
			echo '<div class="row"><div class="columns large-12"><div data-alert class="alert-box warning radius">';
			echo 'Impossible de rechercher les créneaux disponibles avec les dates spécifiées.';
			echo '<a href="#" class="close">&times;</a></div></div></div>';
			return;
			
		}		

		// MESSAGE
		if (count($propositions) > 0)
		{
			// AFFICHAGE DES PROPOSITIONS
			$days = array ('0' => 'Dimanche', '1' => 'Lundi', '2' => 'Mardi', '3' => 'Mercredi', 
						'4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi');
			$months = array ('1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', 
					'5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août', 
					'9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre');
			echo '<p class="text-center">Veuillez sélectionner un créneau parmi ceux disponibles.</p>';

			// on trie les propositions
			usort($propositions, function ($a, $b) {
				if ($a >= $b)
					return 1;
				return 0;
			});


			foreach($propositions as $dateTime)
			{
				$day = $days[$dateTime->format('w')];
				$month = $months[$dateTime->format('n')];
				echo '<label><input type="radio" name="appointmentDate" value="' . $dateTime->format('Y-m-d H:i:s') . '" /> ';
				echo $day;
				echo $dateTime->format(' d ');
				echo $month;
				echo ' à ';
				echo $dateTime->format('H\hi');
				echo '</label>';
			}
		}
		else
		{
			// Aucun créneau possible
			echo '<div class="row"><div class="columns large-12"><div data-alert class="alert-box alert radius">';
			echo 'Le planning des rendez-vous est malheureusement complet. ';
			echo 'Il nous est impossible de trouver un créneau disponible pour vous.<br />';
			echo '<br />Essayer de nous contacter par téléphone au 02 47 47 47 47.';
			echo '<a href="#" class="close">&times;</a></div></div></div>';
		}

	}

	/**
	 * getEventsJson : Renvoit les événements sous format json pour être affichés dans le calendrier
	 *
	 * @param $doctor_key 	Clé du médecin associé
	 * @param $date 		Date où chercher les rendez-vous
	 * @return JSON des événements (rendez-vous)
	 *
	 */
	public function getEventsJson($doctor_key = 'all', $date = null)
	{
		// On regarde si l'utilisateur à le droit d'accéder aux rendez-vous demandés
		if ($doctor_key != $this->session->userdata('user_doctor_key') && $this->session->userdata('user_right') < 2)
		{
			return null;
		}

		// On récupère et renvoit les rendez-vous sous un formet pour la librairie Javascript FullCalendar
		$data = $this->appointment_model->Appointment_get($doctor_key, $date);
		$events = array();
		foreach($data as $event)
		{
			$user = $this->user_model->User_getFromKey($event['appointment_user_key']);
			if ($user != null)
				$title = $this->customer_model->Customer_getFullName($user[0]['user_default_customer_key']);
			else
				$title = "Client inconnu";
			$url = site_url('appointment/proceed/' . $event['appointment_id']);
			$departure = new DateTime($event['appointment_departure']);
			$newEntry = array(
				'title' => $title,
				'description' => $this->doctor_model->Doctor_getInitials($event['appointment_doctor_key']),
				'start' => $event['appointment_start'],
				'end' => $event['appointment_end'],
				'url' => $url,
				'color' => '#70BC1F',
				'allDay' => false
			);
			array_push($events, $newEntry);
		}
		echo json_encode($events);
	}

	/**
	 * isLongTrip : renvoit vrai ou faux s'il s'ajout d'un long voyage ou non
	 *
	 * @param $departure 	Date de départ
	 * @param $return 		Date de retour
	 * @return bool
	 *
	 */
	private function isLongTrip($departure, $return = '')
	{
		if ($return == '')
			return true;
		else
		{
			$tripDuration = (strtotime($return) - strtotime($departure)) / (3600*24); // en jour
			$isLongTripFrom = $this->parameters_model->Parameters_getIsLongTripFrom();
			return ($tripDuration >= $isLongTripFrom);
		}
	}

	/**
	 * upcomingAppointments : chargé dans la bannière lorsque le client est connecté
	 */
	public function upcomingAppointments()
	{
		if ($this->session->userdata('connected') && $this->session->userdata('user_right') == 0)
		{
			// On récupère les rendez-vous du compte
			$appointments = $this->appointment_model->Appointment_getFromUserKey($this->session->userdata('user_key'));
			if (!empty($appointments))
			{
				// On ne renvoit que le prochain rendez-vous du client
				foreach($appointments as $appointment)
				{
					$appointmentStart = new DateTime($appointment['appointment_start']);
					if ($appointmentStart > new DateTime('now'))
					{
						echo '<div class="panel radius text-right">';
						echo '<h6><i class="fi-alert"></i>&nbsp;Vous avez un rendez-vous !</h6>';
						echo '<small>Le ' . substr(full_date($appointment['appointment_start']), 0, -3) . '<br /><a href="' . site_url('appointment/view/' . $appointment['appointment_id']) . '">En savoir plus...</a></small>';
						echo '</div>';
						break;
					}						
				}
			}
			else
				return '';
		}
		return '';
	}

	/**
	 * proceed : Accessible par les médecins uniquement
	 * 			 Permet d'effectuer une consultation
	 */
	public function proceed($appointment_id)
	{
		$this->config->set_item('user-nav-selected-menu', 1);

		// On récupère les données du rendez-vous
		$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);
		if ($appointment != null)
		{
			$data['appointment'] = $appointment;
			$data['destinations'] = $this->appointment_model->Appointment_getCountries($appointment['appointment_id']);
			$data['customers'] = $this->appointment_model->Appointment_getCustomers($appointment['appointment_id']);
			$dataCustomers = array();
			// On récupère les info des clients concernés par le rendez-vous
			foreach ($data['customers'] as $customer_key)
			{
				$customer = $this->customer_model->Customer_getFromKey($customer_key);
				array_push($dataCustomers, $customer[0]);
			}
			$data['customers'] = $dataCustomers;
			$data['hostings'] = $this->appointment_model->Appointment_getHostings($appointment['appointment_id']);
			$data['activities'] = $this->appointment_model->Appointment_getActivities($appointment['appointment_id']);
		}
		else
		{
			show_404();
		}

		// Affichage de la vue
		$this->layout->show('backend/appointment/proceed', $data);
	}


	/**
	 * documents : Accessible par les médecins uniquement
	 * 			   Permet d'accéder à la page de génération de documents
	 */
	public function documents($appointment_id)
	{
		$this->config->set_item('user-nav-selected-menu', 1);

		$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);

		if ($appointment != null) {

			$data['appointment'] = $appointment;
			$data['customers'] = $this->appointment_model->Appointment_getCustomers($appointment['appointment_id']);

		} else {
			show_404();
		}

		// Affichage de la vue
		$this->layout->show('backend/appointment/documents', $data);

	}
	
	/**
	 * cancel : Supprime un rendez-vous
	 */
	public function cancel($appointment_id = '')
	{
		// On récupère les informations du rendez-vous
		$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);
		
		if ($appointment != null && ($this->session->userdata('user_key') == $appointment['appointment_user_key'] || $this->session->userdata('user_right') >1))
		{

			/* /!\ Cette partie devra être rajoutée en fonction des besoins pour qu'un utilisateur ne puisse pas 
			supprimer n'importe quel rendez-vous et n'importe quand

			// S'il s'agit d'un client, on regarde s'il est en droit de supprimer le rendez-vous
			/*$tomorrow = new DateTime();
			$tomorrow = $tomorrow->add(new DateInterval('PT24H'));
			if ($appointment['appointment_start'] <= $tomorrow) //  && $this->session->userdata('user_right') == 0
			{
				// Echec et redirection
				$this->session->set_userdata(array('alert-type' => 'warning'));
				$this->session->set_userdata(array('alert-message' => 'Le rendez-vous ne peut plus être annulé.'));
				redirect('appointment');
			}*/
			
			// On récupère les clés de tous les utilisateurs concernés
			$users_keys = array();
			$customers_keys = $this->appointment_model->Appointment_getCustomers($appointment_id);
			foreach($customers_keys as $customer_key)
			{
				$customer = $this->customer_model->Customer_getFromKey($customer_key);
				if ($customer != null)
				{	
					if (!in_array($customer[0]['customer_user_key'], $users_keys))
					{
						array_push($users_keys, $customer[0]['customer_user_key']);
					}
				}							
			}

			// On supprime le rendez-vous
			if ($this->appointment_model->Appointment_deleteById($appointment_id))
			{
				// Envoi des mails
				foreach	($users_keys as $user_key)
				{					
					$user = $this->user_model->User_getFromKey($user_key);
					if ($user != null)
					{
						$user = $user[0];
						$this->email->from($this->parameters_model->Parameters_getEmailContact(), 'Centre de Vaccinations Internationales de Tours');
						$this->email->to($user['user_email']);
						$this->email->subject('Votre rendez-vous a été annulé');
						$data['message'] = 'Ce message est pour vous informer que votre rendez-vous du ' . substr(full_date($appointment['appointment_start']), 0, -3) . ' vient d\'être annulé ';
						$data['message'] .= 'suite à la demande de ' . $this->user_model->User_getMainName($this->session->userdata('user_key')) . '.';
						$this->email->message($this->load->view('template/email', $data, true));
						$data['fullName'] = $this->user_model->User_getMainName($user['user_key']);
						$this->email->send();	
					}
				}
				
				// Succès et redirection
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Le rendez-vous a été annulé avec succès.'));
				redirect('appointment');
			}
			else
			{
				// Échec
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Erreur lors de l\'annulation du rendez-vous. Merci de réessayer.'));
				redirect('appointment');
			}
		}
		else
		{
			// Rendez-vous inexistant ou pas les droits
			$this->session->set_userdata(array('alert-type' => 'warning'));
			$this->session->set_userdata(array('alert-message' => 'Impossible d\'annuler le rendez-vous. Celui-ci n\'existe pas ou vous n\'avez simplement pas les droits nécessaires.'));
			redirect('appointment');
		}
	}
	
	/**
	 * finish : Passe une consultation en 'DONE' et redirige l'utilisateur vers sa prochaine consultation
	 */
	public function finish($appointment_id)
	{
		// Seul le membre du personnel peut accéder à cette méthode
		if ($this->session->userdata('user_right') == 0)
			show_404();
		// --------------------------------------------------------
		
		// On récupère les informations du rendez-vous
		$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);
		
		// Pour valider l'action, l'utilisateur doit soit être assigné à la consultation, ou de niveau supérieur ou égal à secrétaire
		if ($appointment != null && ($this->session->userdata('user_doctor_key') == $appointment['appointment_doctor_key'] || $this->session->userdata('user_right') > 1))
		{
			// On passe le rendez-vous en 'DONE'
			if (!$this->appointment_model->Appointment_done($appointment_id))
			{
				// Erreur
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite.'));
				redirect('appointment/proceed/'.$appointment['appointment_id']);
			}
			
			// On redirige l'utilisateur vers le rendez-vous suivant, ou les planning
			if ($appointment['appointment_doctor_key'] == $this->session->userdata('user_doctor_key'))
			{
				// On recherche la prochaine consultation
				$appDate = new DateTime($appointment['appointment_start']);
				$appointmentsToday = $this->appointment_model->Appointment_get($appointment['appointment_doctor_key'], $appDate->format('Y-m-d'));
				foreach ($appointmentsToday as $app)
				{
					if ($app['appointment_start'] > $appointment['appointment_start'])
					{
						redirect('appointment/proceed/'.$app['appointment_id']);
					}
				}
				
				// Aucun rendez-vous n'a été trouvé après celui-ci...
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'La journée est terminée !'));
				redirect('dashboard');
			}
			else
			{
				redirect('appointment/proceed/'.$appointment['appointment_id']);
			}
		}
		else
		{
			// Rendez-vous inexistant ou pas les droits
			$this->session->set_userdata(array('alert-type' => 'warning'));
			$this->session->set_userdata(array('alert-message' => 'Impossible d\'effectuer cette action. La consultation n\'existe pas ou vous n\'avez simplement pas les droits nécessaires.'));
			redirect('backend/schedule');
		}
	}
	
	/**
	 * updateFeedback : Met à jour les feedback (remarques) d'un rendez-vous (AJAX CALL)
	 */
	public function updateFeedback($appointment_id)
	{
		$data['success'] = false;
		$data['reload'] = false;
		$data['message'] = 'ok';
	
		// On récupère les informations du rendez-vous
		$appointment = $this->appointment_model->Appointment_getFromId($appointment_id);
		
		// Si le rendez-vous existe et qu'on a les droits
		if ($appointment != null && ($this->session->userdata('user_key') == $appointment['appointment_user_key'] || $this->session->userdata('user_right') > 1))
		{
			if ($this->form_validation->run('appointment/updateFeedback') == false)
			{
				$data['message'] = validation_errors();
			}
			else
			{
				// Enregistrement du feedback
				if ($this->appointment_model->Appointment_updateFeedback($appointment_id, $this->input->post('feedback')))
				{
					$data['message'] = 'Merci, vos remarques ont bien été enregistrées.';
					$data['success'] = true;
				}
				else
				{
					$data['message'] = 'Une erreur s\'est produite lors de la prise en compte de vos remarques. Merci de réessayer.';
				}
			}
		}
		else
		{
			$data['message'] = 'Impossible de prendre en compte vos remarques. Le rendez-vous spécifié n\'existe pas ou vous n\'avez pas les droits.';
		}
		
		echo json_encode($data);
	}

}

/* End of file appointment.php */
/* Location: ./application/controllers/appointment.php */