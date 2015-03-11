<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Doctor Controller Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Doctor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('user_model');
		$this->load->model('doctor_model');
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
	 * Index : liste des docteurs
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 4); // item 4 du menu à highlight

		// Pour chaque docteur, on récupère les relatives au compte utilisateur
		$data['doctors'] = $this->doctor_model->Doctor_get();
		for($i=0;$i<count($data['doctors']);++$i)
		{
			$data['doctors'][$i]['user'] = $this->user_model->User_getFromDefaultCustomerKey($data['doctors'][$i]['doctor_key'])[0];
		}
		
		// Affichage de la vue
		$this->layout->show('backend/doctor/list', $data);
	}

	/**
	 * View : page d'un médecin
	 */
	public function view($doctor_key)
	{
		if (!isset($doctor_key)) redirect('doctor');
		
		// On récupère les informations du docteur et de compte utilisateur associé
		$user = $this->user_model->User_getFromDefaultCustomerKey($doctor_key);
		$doctor = $this->doctor_model->Doctor_getFromKey($doctor_key);
		if ($user == null || $doctor == null)
		{
			show_404();
		}
		
		// La page d'un docteur est accessible au docteur lui même, aux secrétaires et aux admins seulement
		if ($doctor_key != $this->session->userdata('user_doctor_key') && $this->session->userdata('user_right') < 2)
		{
			echo 'Permission denied.';
			return;
		}
		else
		{
			$data['user'] = $user[0];
			$data['doctor'] = $doctor[0];
			if ($data['user']['user_key'] == $this->session->userdata('user_key'))
				$this->config->set_item('user-nav-selected-menu', 2); // menu item 2 à highlight si c'est son propre compte
			else
				$this->config->set_item('user-nav-selected-menu', 4); // menu item 4 sinon

			// Affichage de la vue
			$this->layout->show('backend/doctor/view', $data);
		}
	}

	/**
	 * create
	 */
	public function create()
	{
		// Création possible pour les secrétaires ou admins seulement
		if ($this->session->userdata('user_right') < 2)
		{
			show_404();
		}

		$this->config->set_item('user-nav-selected-menu', 4); // menu item 4 à highlight

		if ($this->form_validation->run() == false)
		{
			$this->layout->show('backend/doctor/create');
		}
		else
		{
			// Récupération des données du formulaire
			$title = $this->input->post('title');
			$lastname = $this->input->post('lastname');
			$firstname = $this->input->post('firstname');
			
			$birthdate = $this->input->post('birthdate');
			$birthcity = $this->input->post('birthcity');
			$birth_country_id = $this->input->post('birth_country_id');
			$address1 = $this->input->post('address1');
			$address2 = $this->input->post('address2');
			$postalcode = $this->input->post('postalcode');
			$city = $this->input->post('city');
			$phone = $this->input->post('phone');
			$country_id = $this->input->post('country_id');
			$email = $this->input->post('email');
			$user_right = $this->input->post('user_right');
			$type = $this->input->post('type');

			$fax = $this->input->post('fax');
			$adeli = $this->input->post('adeli');

			// Génération du login
			// Premières lettres des nom/prenom plus date de naissance
			$login = generate_doctor_login($firstname, $lastname);

			// On génère le mot de passe
			$password = random_string('alnum', 8);

			// Création de l'utilisateur
			if( $user_key = $this->user_model->User_create($login, $password, $email, $address1,
											   	$address2, $postalcode, $city, $country_id, $phone, $user_right) )
			{
				// Création du docteur
				if( ($doctor_key = $this->doctor_model->Doctor_create($title, $firstname, $lastname, 
					$birthdate, $birthcity, $birth_country_id, $type, $fax, $adeli)) != null )
				{
					// Mise à jour de la clé du défaut customer pour l'utilisateur venant d'être créé
					if( $this->user_model->User_editDefaultCustomerKey($user_key, $doctor_key) )
					{
						// Redirection vers la page d'accueil avec l'alert qui va bien
						$fullname = $title . ' ' . strtoupper($lastname) . ' ' . $firstname;
						$this->session->set_userdata(array('alert-type' => 'success'));
						$this->session->set_userdata(array('alert-message' => 'Le compte pour ' . $fullname . ' a bien été créé.'));
						redirect('doctor');
					}
						
					return;
				}
				// Si la création du docteur échoue, on supprime l'utilisateur
				else
				{
					// Suppression de l'utilisateur qui vient d'être créé
					$this->user_model->User_delete( $user['user_id'] );
					// Affichage de la vue d'erreur
					$this->session->set_userdata(array('alert-type' => 'error'));
					$this->session->set_userdata(array('alert-message' => '<strong>Oops !</strong><br />Une erreur s\'est produite lors 
									de la création de votre compte.<br />Merci de réessayer.'));
					redirect('doctor');
				}
			}
			// Affichage de la vue d'erreur
			$this->session->set_userdata(array('alert-type' => 'error'));
			$this->session->set_userdata(array('alert-message' => '<strong>Oops !</strong><br />Une erreur s\'est produite lors de la  
								création de votre compte.<br />Merci de réessayer.'));
			redirect('doctor');
		}
	}

	/**
	 * update : page de modification d'un membre du personnel
	 *			AJAX CALL
	 */
	public function update()
	{
		$data['success'] = false;
		$doctor_key = $this->input->post('doctor_key');

		// On regarde si l'utilisateur est autorisé à effectuer les modifications
		if ($doctor_key == $this->session->userdata('user_doctor_key') || $this->session->userdata('user_right') > 1)
		{
			if ($this->form_validation->run() == false)
			{
				$data['message'] = validation_errors();
			}
			else
			{
				// Récupération des champs du formulaire
				$title = $this->input->post('title');
				$firstname = $this->input->post('firstname');
				$lastname = $this->input->post('lastname');
				$birthdate = $this->input->post('birthdate');
				$birthcity = $this->input->post('birthcity');
				$birth_country_id = $this->input->post('birth_country_id');
				$type = $this->input->post('type');
				$fax = $this->input->post('fax');
				$adeli = $this->input->post('adeli');

				// TIMETABLE
				$days = array();
				array_push($days, array('id' => 0, 'fr' => 'lundi', 'en' => 'monday'));
				array_push($days, array('id' => 1, 'fr' => 'mardi', 'en' => 'tuesday'));
				array_push($days, array('id' => 2, 'fr' => 'mercredi', 'en' => 'wednesday'));
				array_push($days, array('id' => 3, 'fr' => 'jeudi', 'en' => 'thursday'));
				array_push($days, array('id' => 4, 'fr' => 'vendredi', 'en' => 'friday'));
				array_push($days, array('id' => 5, 'fr' => 'samedi', 'en' => 'saturday'));
				array_push($days, array('id' => 6, 'fr' => 'dimanche', 'en' => 'sunday'));

				// Création du JSON de la timetable
				$timetable = array();
				foreach($days as $day)
				{
					$newEntry = array();
					$newEntry = array(
						'am' => array($this->input->post($day['en'].'MorningStart'), $this->input->post($day['en'].'MorningEnd')),
						'pm' => array($this->input->post($day['en'].'AfternoonStart'), $this->input->post($day['en'].'AfternoonEnd')),
						);
					array_push($timetable, $newEntry);
				}
				
				// Mise à jour du docteur
				if ($this->doctor_model->Doctor_update($doctor_key, $title, $firstname, $lastname, $birthdate, $birthcity, $birth_country_id, $type, json_encode($timetable), $fax, $adeli) )
				{
					// Si le docteur modifié est celui connecté, on change la variable de session correspondant à son nom
					if ($doctor_key == $this->session->userdata('user_doctor_key'))
						$this->session->set_userdata('user_fullname',
								$title.' '.strtoupper($lastname).' '.$firstname);
					$data['success'] = true;
					$data['message'] = 'Les informations personnelles ont bien été mises à jour.';
				}
				else
				{
					$data['message'] = 'Une erreur s\'est produite.<br />Réessayez.';
				}				
			}
		}
		else
		{
			$data['message'] = 'Vous n\'avez pas les droits.';
		}
		
		echo json_encode($data);
	}

	/**
	 * updateTimetable : Mise à jour de la timetable seulement
	 */
	public function updateTimetable()
	{
		$data['success'] = false;
		$doctor_key = $this->input->post('doctor_key');

		if (($doctor = $this->doctor_model->Doctor_getFromKey($doctor_key) == null))
		{
			$data['message'] = 'Doctor introuvable.';
			echo json_encode($data);
			return;
		}

		// On regarde si l'utilisateur est autorisé à effectuer les modifications
		if ($doctor_key == $this->session->userdata('user_doctor_key') || $this->session->userdata('user_right') > 0)
		{
			// TIMETABLE
			$days = array();
			array_push($days, array('id' => 0, 'fr' => 'lundi', 'en' => 'monday'));
			array_push($days, array('id' => 1, 'fr' => 'mardi', 'en' => 'tuesday'));
			array_push($days, array('id' => 2, 'fr' => 'mercredi', 'en' => 'wednesday'));
			array_push($days, array('id' => 3, 'fr' => 'jeudi', 'en' => 'thursday'));
			array_push($days, array('id' => 4, 'fr' => 'vendredi', 'en' => 'friday'));
			array_push($days, array('id' => 5, 'fr' => 'samedi', 'en' => 'saturday'));
			array_push($days, array('id' => 6, 'fr' => 'dimanche', 'en' => 'sunday'));

			// Création du tableau JSON de la timetable
			$timetable = array();
			foreach($days as $day)
			{
				$newEntry = array();
				$newEntry = array(
					'am' => array($this->input->post($day['en'].'MorningStart'), $this->input->post($day['en'].'MorningEnd')),
					'pm' => array($this->input->post($day['en'].'AfternoonStart'), $this->input->post($day['en'].'AfternoonEnd')),
					);
				array_push($timetable, $newEntry);
			}

			// Mise à jour de la timetable
			if ($this->doctor_model->Doctor_updateTimetable($doctor_key, json_encode($timetable)))
			{
				$data['success'] = true;
				$data['message'] = 'Les horaires de présence ont bien été mis à jour.';
			}
			else
			{
				$data['message'] = 'Une erreur s\'est produite.<br />Réessayez.';
			}
		}
		else
		{
			$data['message'] = 'Vous n\'avez pas les droits.';
		}
		
		echo json_encode($data);
	}

}

/* End of file doctor.php */
/* Location: ./application/controllers/doctor.php */