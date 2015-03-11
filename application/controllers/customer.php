<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Customer Controller Class
 *
 * @author		Clément Tessier
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Customer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->model('country_model');
		$this->load->model('partnership_model');

		// Il est dans tous les cas nécessaire d'être connecté pour accéder à cette classe
		if (!$this->session->userdata('connected'))
		{
			redirect('login?next=compte/famille');
		}
	}

	/**
	 * index : affiche l'ensemble des clients pour le backend
	 */
	public function index()
	{
		// Les doctors seulement peuvent accéder à cette méthode
		if ($this->session->userdata('user_right') <= 0)   //
			show_404();									   //
		// --------------------------------------------------
		
		$this->config->set_item('user-nav-selected-menu', 5); // menu item 5 à highlight

		// On récupère les infos de tous les clients
		$data['customers'] = $this->customer_model->Customer_get();
		// Affichage de la vue
		$this->layout->show('backend/customer/list', $data);

	}

	/**
	 * view : affiche les infos d'un client pour le backend
	 */
	public function view($customer_key = '')
	{
		// Les doctors seulement peuvent accéder à cette méthode
		if ($this->session->userdata('user_right') <= 0)   //
			show_404();									   //
		// --------------------------------------------------
		
		if (empty($customer_key))
			redirect('customer');
		else
		{
			// On récupère les infos du client
			$data = $this->customer_model->Customer_getFromKey($customer_key);
			if ($data != null)
			{
				// le client existe, on récupère ses infos médicales, son dossier et ses rendez-vous
				$this->config->set_item('user-nav-selected-menu', 5); // menu item 5 à highlight
				$data = $data[0];
				$this->load->model('medicalInfo_model');
				$this->load->model('medicalRecord_model');
				$this->load->model('appointment_model');
				// On récupère également les infos du compte correspond
				$user = $this->user_model->User_getFromKey($data['customer_user_key']);
				$data = array_merge($data, $user[0]);
				$data['appointments'] = $this->appointment_model->Appointment_getFromCustomerKey($data['customer_key']);
				// tri des rendez-vous
				usort($data['appointments'], function($a,$b) {
						return ($a['appointment_start'] < $b['appointment_start']);
					}
				);
				$data['medicalInfo'] = $this->medicalInfo_model->MedicalInfo_getFromId($data['customer_medicalInfo_id']);
				$data['medicalRecord'] = $this->medicalRecord_model->MedicalRecord_getFromId($data['customer_medicalRecord_id']);
				// Affichage de la vue
				$this->layout->show('backend/customer/view', $data);	
			}
			else
			{
				echo 'Client introuvable';
				return;
			}
		}
	}

	/**
	 * Create : page de création d'un nouveau client (membre de la famille)
	 */
	public function create()
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------

		$this->config->set_item('user-nav-selected-menu', 3); // menu item 3 à highlight
		
		if ($this->form_validation->run('customer') == false)
		{
			$this->layout->show('customer/create');
		}
		else
		{
			// Récupération des données du formulaire
			$title = $this->input->post('title');
			$lastname = $this->input->post('lastname');
			$firstname = $this->input->post('firstname');
			$birthdate = $this->input->post('birthdate_year') . '-' . $this->input->post('birthdate_month') . '-' . $this->input->post('birthdate_day');
			//$age = $this ->input->post('age');
			$birthcity = $this->input->post('birthcity');
			$birth_country_id = $this->input->post('birth_country_id');
			//$weight = $this->input->post('weight');

			if($title == 'M.') $sex = 'M'; else $sex = 'F';
			$numsecu = $this->input->post('numsecu');
			$bloodgroup = $this->input->post('bloodgroup');

			$user_key = $this->session->userdata('user_key');
			$doctor_id = null;

			
			// Création du nouveau membre
			if ($this->customer_model->Customer_create($title, $firstname, $lastname, $birthdate, $height, $birthcity, 
		 						 $birth_country_id, $weight, $sex, $user_key, $numsecu, $bloodgroup, $doctor_id))
			{
				// Message de succès
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Le profil de ' . $firstname . ' ' . $lastname . ' a bien été créé.'));
			}
			else
			{
				// Message d'erreur
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite lors de la création du membre.'));
			}
			
			// Redirection vers la page famille
			redirect('compte/famille');
		}
	}

	/**
	 * CreateFast : fonction de création rapide d'un client (profil, enfant, ..) pour BACKEND
	 * AJAX CALL
	 */
	public function createFast()
	{
		$data['success'] = false;
		$data['reload'] = false;
		$data['message'] = '';

		// Seuls les doctors peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') <= 0)	   //
			show_404();									   //
		// --------------------------------------------------
		
		if ($this->form_validation->run('customer/createFast') == false)
		{
			$data['message'] = validation_errors(); // récupération des erreurs
		}
		else
		{
			// Récupération des données du formulaire
			$title = $this->input->post('title');
			$lastname = $this->input->post('lastname');
			$firstname = $this->input->post('firstname');
			$birthdate = $this->input->post('birthdate');
			if($title == 'M.') $sex = 'M'; else $sex = 'F';

			do {
				$customer_key = 'U' . random_string('alnum', 9);
				} while ($this->Customer_get(array('customer_key' => $customer_key)) != null);
			

			// Création du nouveau membre
			if ($this->customer_model->Customer_create($title, $firstname, $lastname, $birthdate, $height, null, 
		 						 null, $weight, $sex, $user_key, null, null, null))
			{
				$data['success'] = true;
				$data['reload'] = true;
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Le profil de ' . $firstname . ' ' . $lastname . ' a bien été créé.'));
			}
			else
			{
				$data['message'] = 'Une erreur s\'est produite.';
			}
		}

		echo json_encode($data);
	}

	/**
	 * Update : page d'édition d'un client
	 */
	public function update($customer_key = '')
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------

		if ($customer_key == '') // L'utilisateur modifie le compte principal
		{
			$this->config->set_item('user-nav-selected-menu', 1);

			// Récupération de la clé client par défaut
			$default_customer_key = $this->session->userdata('user_default_customer_key');
			// Récupération des infos du client par défaut
			$default_customer = $this->customer_model->Customer_getFromKey($default_customer_key);

			// Affichage de la vue
			$data['customer'] = $default_customer[0];
		}
		else
		{
			$this->config->set_item('user-nav-selected-menu', 3); // menu item 4 à highlight

			// On récupère les infos du client à modifier
			$customer = $this->customer_model->Customer_getFromKey($customer_key);
			if ($customer != null)
			{
				$customer = $customer[0];
				// On regarde si on a les droits
				if ($this->session->userdata('user_key') == $customer['customer_user_key'] || $this->session->userdata('user_right') > 0)
				{
					$data['customer'] = $customer;
				}
				else
				{
					echo 'Permission denied';
					return;
				}					
			}
			else
			{
				show_404();
			}
		}

		if ($this->form_validation->run('customer') == FALSE)
		{
			// Affichage de la vue
			$this->layout->show('customer/update', $data);
		}
		else
		{
			// Récupération des données du client à modifier
			$key = $this->input->post('customer_key');			
			$customer = $this->customer_model->Customer_getFromKey($key);

			// Vérifications des droits
			if ($customer != null && ($customer[0]['customer_user_key'] == $this->session->userdata('user_key') || $this->session->userdata('user_right') > 0))
			{
				// La mise à jour peut être effectuée
				// Récupération des données du formulaire
				$title = $this->input->post('title');
				$lastname = $this->input->post('lastname');
				$firstname = $this->input->post('firstname');
				$birthdate = $this->input->post('birthdate_year') . '-' . $this->input->post('birthdate_month') . '-' . $this->input->post('birthdate_day');
				$height = $this ->input->post('height');
				$birthcity = $this->input->post('birthcity');
				$birth_country_id = $this->input->post('birth_country_id');
				$weight = $this ->input->post('weight');
				$numsecu = $this->input->post('numsecu');
				$bloodgroup = $this->input->post('bloodgroup');
				if($title == 'M.') $sex = 'M'; else $sex = 'F';
				
				// Mises à jour des infos du clients
				if ($this->customer_model->Customer_update($key, $title, $firstname, $lastname, $birthdate, $height, $birthcity, $birth_country_id, $weight,
																$sex, $numsecu, $bloodgroup))
				{
					// Mise à jour de la variable session si nécessaire
					if ($this->session->userdata('user_default_customer_key') == $key)
						$this->session->set_userdata('user_fullname', $this->customer_model->Customer_getFullName($key));

					// Redirection vers la page d'accueil avec l'alert qui va bien
					$this->session->set_userdata(array('alert-type' => 'success'));
					$this->session->set_userdata(array('alert-message' => 'Les informations personnelles de ' . $firstname . ' ' . $lastname . ' ont bien été mises à jour.'));
					
					// On redirige l'utilisateur selon qu'il a édité son propre compte ou non
					if ($customer_key != '')
						redirect('compte/famille');
					else
						redirect('compte');
				}
				else
				{
					$this->session->set_userdata(array('alert-type' => 'error'));
					$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite. Merci de réessayer.'));
					redirect('compte');
				}
			}
			else
			{
				// Le client à modifier n'existe pas ou l'utilisateur n'a pas les droits
				show_404();
			}
		}
	}

	/**
	 * Update : page d'édition d'un client (pour backend)
	 * AJAX CALL
	 */
	public function updateAjax()
	{
		$data['success'] = false;

		// Les clients ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') < 0)	 {
			$data['message'] = 'Vous n\'avez pas les droits.';
			echo json_encode($data);
			return;
		}
		// --------------------------------------------------------

		if ($this->form_validation->run('customer/updateAjax') == FALSE)
		{
			$data['message'] = validation_errors(); // récupération des erreurs
		}
		else
		{
			// Récupération des données du client à modifier
			$key = $this->input->post('customer_key');			
			$customer = $this->customer_model->Customer_getFromKey($key);

			// Vérifications des droits
			if ($customer != null && ($customer[0]['customer_user_key'] == $this->session->userdata('user_key') || $this->session->userdata('user_right') > 0))
			{
				// La mise à jour peut être effectuée
				// Récupération des données du formulaire
				$title = $this->input->post('title');
				$lastname = $this->input->post('lastname');
				$firstname = $this->input->post('firstname');
				$birthdate = $this->input->post('birthdate');
				$height = $this ->input->post('height');
				$birthcity = $this->input->post('birthcity');
				$birth_country_id = $this->input->post('birth_country_id');
				$weight = $this ->input->post('weight');
				$numsecu = $this->input->post('numsecu');
				$bloodgroup = $this->input->post('bloodgroup');
				if($title == 'M.') $sex = 'M'; else $sex = 'F';
				
				// Mise à jour du client
				if ($this->customer_model->Customer_update($key, $title, $firstname, $lastname, $birthdate, $height, $birthcity, $birth_country_id, $weight, 
																$sex, $numsecu, $bloodgroup))
				{
					$data['success'] = true;
					$data['message'] = 'Les informations du client ont bien été mises à jour.';
				}
				else
				{
					$data['message'] = 'Une erreur s\'est produite.';
				}
			}
			else
			{
				// Le client à modifier n'existe pas ou l'utilisateur n'a pas les droits
				$data['message'] = 'Client à modifier introuvable.';
			}
		}
		echo json_encode($data);
		return;
	}

	/**
	 * Affiche les clients d'une même famille
	 */
	public function family()
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------

		$this->config->set_item('user-nav-selected-menu', 4);

		$connected_user = $this->user_model->User_getFromKey($this->session->userdata('user_key'));
		$connected_user = $connected_user[0];

		// Récupération des profils liés (sauf l'utilisateur par défaut)
		$profiles = $this->customer_model->Customer_get(
			array('customer_user_key' => $connected_user['user_key'],
				  'customer_key <>' => $connected_user['user_default_customer_key'])
		);

		// Récupération des utilisateurs associés (ACK = true)
		$partnerships_acked = $this->partnership_model->Partnership_getFromUserKey($connected_user['user_key']);
		$partnerships_users = array();
		foreach($partnerships_acked as $partnership)
		{
			$partnerToAdd = null;
			if ($partnership['partnership_a_user_key'] == $connected_user['user_key'])
				$partnerToAdd = $this->user_model->User_getFromKey($partnership['partnership_b_user_key']);
			if ($partnership['partnership_b_user_key'] == $connected_user['user_key'])
				$partnerToAdd = $this->user_model->User_getFromKey($partnership['partnership_a_user_key']);

			if ($partnerToAdd != null)
			{
				array_push($partnerships_users, $partnerToAdd[0]);
			}
		}

		// Récupération des clients issus des relations
		$partnership_profiles = array();
		foreach($partnerships_users as $partners)
		{
			$customersToAdd = $this->customer_model->Customer_getFromUserKey($partners['user_key']);
			if ($customersToAdd != null)
			{
				$partnership_profiles = array_merge($partnership_profiles, $customersToAdd);
			}
		}

		// Récupération des relations en attente
		$partnership_non_acked = $this->partnership_model->Partnership_getFromUserKey($connected_user['user_key'], false);
		$partnership_pendings = array();
		foreach($partnership_non_acked as $pending)
		{
			$user = null;
			if ($pending['partnership_a_user_key'] == $connected_user['user_key'])
				$user = $this->user_model->User_getFromKey($pending['partnership_b_user_key']);
			if ($pending['partnership_b_user_key'] == $connected_user['user_key'])
				$user = $this->user_model->User_getFromKey($pending['partnership_a_user_key']);
			
			if ($user != null)
			{
				$pendingToAdd = $pending;
				$pendingToAdd['user'] = $user[0];
				array_push($partnership_pendings, $pendingToAdd);
			}
				
		}

		// Affichage de la vue
		$data = array( 'profiles' => $profiles,
					   'partnership_profiles' => $partnership_profiles,
					   'partnerships_users' => $partnerships_users,
					   'partnership_pendings' => $partnership_pendings
				);
				
		$this->layout->show('customer/view', $data);
	}

	/**
	 * Affiche les informations médicales d'un client
	 */
	public function medicalinfo($customer_key = '')
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------
		
		// Chargement des modèles
		$this->load->model('medicalInfo_model');
		$this->load->model('allergy_model');
		$this->load->model('chronicDisease_model');

		if ($customer_key == '') // L'utilisateur affiche les infos du compte principal
		{
			$this->config->set_item('user-nav-selected-menu', 2);

			// Récupération de la clé client par défaut
			$default_customer_key = $this->session->userdata('user_default_customer_key');
			// Récupération des infos du client par défaut
			$default_customer = $this->customer_model->Customer_getFromKey($default_customer_key);
			$customer = $default_customer[0];

		}
		else
		{
			$this->config->set_item('user-nav-selected-menu', 3); // menu item 3 à highlight

			// Récupération des données du client
			$customer = $this->customer_model->Customer_getFromKey($customer_key);
			if ($customer != null)
			{
				$customer = $customer[0];
				if ($this->session->userdata('user_key') != $customer['customer_user_key'] && $this->session->userdata('user_right') == 0)
				{
					echo 'Permission denied';
					return;
				}					
			}
			else
			{
				show_404();
			}
		}

		// Affichage de la vue
		$data['customer_key'] = $customer['customer_key'];
		$data['title'] = $customer['customer_title'];
		$data['firstname'] = $customer['customer_firstname'];
		$data['lastname'] = $customer['customer_lastname'];
		$data['sex'] = $customer['customer_sex'];
			// Récupération des infos médicales du clients
		$data['medicalInfo'] = $this->medicalInfo_model->MedicalInfo_getFromId($customer['customer_medicalInfo_id']);
		$this->layout->show('customer/medicalinfo', $data);
	}
	

	/**
	 * Affiche l'historique médical ' d'un client
	 */
	public function medicalhistoric($customer_key = '')
	{
		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------
		$this->layout->show('customer/medicalhistoric');
	}
	


	/**
	 * search : fonction de recherche d'un client (backend)
	 *	ajax call
	 */
	public function search()
	{
		// Les doctors seulement ont accès à cette méthode
		if ($this->session->userdata('user_right') <= 0)
		{
			show_404();
		}
		// --------------------------------------------------
	
		if (($s = $this->input->get('s')) && ($f = $this->input->get('f')))
		{
			// Requête avec le champ de recherche et le filtre
			$customers = $this->customer_model->Customer_search($s, $f);
		}
		else
		{
			// Aucune recherche faite, on affiche tout
			$customers = $this->customer_model->Customer_get();
		}
		
		// Création du tableau des clients à renvoyer
		foreach ($customers as $customer)
		{
			$birthdate = new DateTime($customer['customer_birthdate']);
			$age = $birthdate->diff(new DateTime())->format('%y');
			$hasDisease = ($this->customer_model->Customer_hasDisease($customer['customer_key'], array('chronicDiseases'))) ? 'O' : 'N';
			echo '<tr class="clickable" onclick="window.location=\'' . site_url('customer/view/'.$customer['customer_key']) . '\';">';
			echo '<td style="font-size:2em;text-align:center;">' . (($customer['customer_sex'] == 'M') ? '<i class="fi-male"></i>' : '<i class="fi-female"></i>') . '</td>';
			echo '<td>' . $customer['customer_firstname'] . '</td>';
			echo '<td>' . $customer['customer_lastname'] . '</td>';
			echo '<td>' . display_date($customer['customer_birthdate']) . ' (' . $age . ' ans)</td>';
			echo '<td>' . $customer['customer_birthcity'] . '</td>';
			echo '<td>' . $hasDisease . '</td>';
			echo '</tr>';
		}
	}

}

/* End of file customer.php */
/* Location: ./application/controllers/customer.php */