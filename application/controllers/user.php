<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * User Controller Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class User extends CI_Controller {

	private $user = null;

	public function __construct()
	{
		parent::__construct();

		// Chargement des helper
		$this->load->helper('security'); // pour la fonction de hachage do_hash()

		// Chargement des modèles
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->model('doctor_model');
		$this->load->model('partnership_model');
		$this->load->model('autologin_model');
		$this->load->model('country_model');

		// Récupération des infos de l'utilisateur connecté
		if ($this->session->userdata('connected'))
		{
			$data = $this->user_model->User_getFromKey($this->session->userdata('user_key'));
			if ($data != null)
				$this->user = $data[0];
		}
	}

	/**
	 * Index : page d'accueil du front-office ou liste des utilisateurs pour le back-office
	 */
	public function index()
	{
		if ($this->user == null) redirect('login'); // l'utilisateur doit être connecté

		// Si l'utilisateur connecté fait partie du membre du personnel
		// On affiche la liste complète des utilisateurs
		if ($this->session->userdata('user_right') > 0)
		{
			$this->config->set_item('user-nav-selected-menu', 6); // menu item 6 à highlight
			// On récupère tous les utilisateurs
			$data['users'] = $this->user_model->User_get();
			// Affichage de la vue
			$this->layout->show('backend/user/list', $data);
			
			return; // on va pas plus loin
		}

		// L'utilisateur est un simple client
		$this->config->set_item('user-nav-selected-menu', 1); // menu item 1 à highlight
		
		// Récupération des informations du client associé par défaut à l'utilisateur
		$connected_customer = $this->customer_model->Customer_getFromKey($this->user['user_default_customer_key']);

		// Affichage de la vue
		$data = array( 'user' => $this->user,
					   'customer' => $connected_customer[0]
				);

		$this->layout->show('user/view', $data);
	}

	/**
	 * View : affiche l'ensemble des données d'un utilisateur (backend)
	 *
	 * @param $suer_key 	Clé de l'utilisateur
	 */
	public function view($user_key)
	{
		// Les doctors seulement peuvent accéder à cette méthode
		if ($this->session->userdata('user_right') <= 0)   //
			show_404();									   //
		// --------------------------------------------------

		$this->config->set_item('user-nav-selected-menu', 6); // menu item 6 à highlight
		
		if (empty($user_key))
			redirect('user/list'); // on affiche la liste des utilisateurs si aucun utilisateur n'est spécifié
		else
		{
			// On récupère les infos de l'utilisateur
			$data = $this->user_model->User_getFromKey($user_key);
			if ($data != null)
			{
				$data = $data[0];
				// On récupère les profils
				$data['profiles'] = $this->customer_model->Customer_getFromUserKey($data['user_key']);
				// On récupère les partenaires
				$data['partners'] = $this->partnership_model->Partnership_getFromUserKey($data['user_key']);
				// On affiche la vue
				$this->layout->show('backend/user/view', $data);	
			}
			else
			{
				echo 'Compte introuvable.';
			}
		}
	}

	/**
	 * Déconnexion
	 */
	public function logout()
	{
		// Déstruction de la session et redirection sur la page d'accueil
		$this->autologin_model->Autologin_del( $this->session->userdata('user_key') ); // On supprime l'auto login au cas où
		delete_cookie('cvi_user_auto_login'); // On supprime le cookie au cas où
		$this->session->sess_destroy();
		redirect();
	}

	/**
	 * Page de connexion
	 */
	public function login()
	{
		// Redirection si un utilisateur est déjà connecté
		if ($this->session->userdata('connected'))
		{ 
			redirect('index'); 
		}

		// Gestion du formulaire
		if (!$this->form_validation->run())
		{
			// Affichage de la vue du formulaire de connexion
			$this->layout->show('user/login');
		}
		else
		{
			// Authentification réussie
			
			// On récupère les données de l'utilisateur
			$this->user = $this->user_model->User_getForSignIn (strtoupper($this->input->post('login')));

			if ( ! $this->user['user_actif'])
			{
				// Le compte n'est pas actif, on le fait savoir à l'utilisateur
				$this->session->set_userdata(array('alert-type' => 'warning'));
				$this->session->set_userdata(array('alert-message' => 'Vous devez activer votre compte.<br />
					<a href="' . site_url('user/send_activation_link/'.$this->user['user_key']) . '">Cliquez-ici</a> pour recevoir un nouveau lien d\'activation.'));
				redirect();
			}

			// Connexion de l'utilisateur - Création de la session
			$newSession = array(
				'connected' => true,
				'user_key' => $this->user['user_key'],
				'user_login' => $this->user['user_login'],
				'user_lastConnection' => $this->user['user_lastConnection'],
				'user_right' => $this->user['user_right']
			);
			$this->session->set_userdata($newSession);

			if ($this->user['user_right'] == 0)
			{
				$this->session->set_userdata('user_default_customer_key', $this->user['user_default_customer_key']);
				$this->session->set_userdata('user_fullname', 
					$this->customer_model->Customer_getFullName($this->user['user_default_customer_key']));
			}
			else // Si l'utilisateur fait partir du personnel (user_right > 0) on a :
			{
				$this->session->set_userdata('user_doctor_key', $this->user['user_default_customer_key']);
				$this->session->set_userdata('user_fullname', 
					$this->doctor_model->Doctor_getFullName($this->user['user_default_customer_key']));
			}
			
			// Mise à jour du champ ´lastConnection´ pour l'utilisateur
			$this->user_model->User_setLastConnection( $this->user['user_id'] );

			// Si ´Se souvenir de moi´ a été cochée, on créé un cookie
			if( $this->input->post('remember') == 'yes' )
			{
				if( ! $this->autologin_model->Autologin_set($this->user['user_key']) )
				{
					// Affichage de la vue d'erreur
					$data['alert_type'] = 0;
					$this->layout->show('user/alert-login', $data);
					return;
				}
			}

			// Redirection vers la page d'accueil avec l'alert qui va bien
			$this->session->set_userdata(array('alert-type' => 'success'));
			$this->session->set_userdata(array('alert-message' => 'Bonjour, ' . $this->session->userdata('user_fullname') . '. Vous êtes bien connecté(e).'));

			// On redirige selon que l'utilisateur est un client (compte) ou un membre du personnel (dashboard)
			if ($this->user['user_right'] > 0 && !$this->input->get('next', true))
			{
				redirect('dashboard');
			}
			else if (!$this->input->get('next', true))
			{
				redirect('compte');
			}
			else
			{
				redirect($this->input->get('next', true));
			}
		}
	}

	/**
	 * password : Formulaire de récupération de mot de passe
	 */
	public function password($hash = '')
	{
		// Cas où la clé hash est non vide. Il s'agit donc d'une réinitialisation du mot de passe et non d'une simple demande.
		if (!empty($hash) && ($reinitializationRequest = $this->user_model->User_getPasswordReinitializationRequestByHash($hash)) != null)
		{
			// On récupère les infos de l'utilisateur
			$user = $this->user_model->User_getFromKey($reinitializationRequest[0]['user_key']);
			if ($this->form_validation->run('newpassword') == false)
			{
				// Affichage du formulaire de réinitialisation du mot de passe
				$this->layout->show('user/newpassword');
			}
			else
			{
				// Le nouveau mot de passe peut être changé
				if ($this->user_model->User_setNewPassword($user[0]['user_key'], $this->input->post('newpassword')))
				{
					// On supprime la requête puisque le mot de passe a été changé
					$this->user_model->User_deletePasswordReinitializationRequest($hash);
					// Création du message de succès
					$this->session->set_userdata(array('alert-type' => 'success'));
					$this->session->set_userdata(array('alert-message' => 'Félicitations ! Votre mot de passe a été changé.<br />Vous pouvez maintenant essayer de vous connecter.'));
				}
				else
				{
					// Création du message d'erreur'
					$this->session->set_userdata(array('alert-type' => 'alert'));
					$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite lors de la mise à jour de votre mot de passe.<br />Merci de contacter le CVI si le problème persiste.'));
				}
				// Redirection
				redirect();
			}		
		}
		// Cas où l'utilisateur doit rentrer son adresse email pour recevoir un message avec le lien pour réinitialiser son mot de passe.
		else
		{
			if ($this->form_validation->run('newpasswordrequest') == false)
			{
				// Affichage du formulaire pour la demande de réinitialisation
				$this->layout->show('user/newpasswordrequest');
			}
			else
			{
				// On récupère l'emai et l'utilisateur associé
				$email = $this->input->post('email');
				$user = $this->user_model->User_getForSignIn($email);
				// Création de la clé hash
				$hash = do_hash(random_string('alnum', 15));

				// On regarde si il y a déjà une requête pour cette utilisateur, si oui on la supprime
				if (($reinitializationRequest = $this->user_model->User_getPasswordReinitializationRequestByUserKey($user['user_key'])) != null)
				{
					$this->user_model->User_deletePasswordReinitializationRequest($reinitializationRequest[0]['userPasswordRequest_hash']);
				}

				// Enregistrement de la requête dans la BDD
				if ($this->user_model->User_createPasswordReinitializationRequest($user['user_key'], $hash))
				{
					$link = site_url('user/password/'.$hash);
					// Envoi du mail
					$this->email->from('contact@cvi.fr', 'Centre de Vaccinations Internationales de Tours');
					$this->email->to($email);
					$this->email->subject('Réinitialisation de votre mot de passe');
					$data['message'] = 'Vous avez effectué une demande de réinitialisation de votre mot de passe. Pour obtenir un nouveau mot de passe, cliquez sur le lien ci-dessous.</p>';
					$data['message'] .= '<p class="text-center"><strong><a href="' . $link . '" class="button medium">Choisir un nouveau mot de passe</a></strong></p><p>';
					$data['fullName'] = $this->user_model->User_getMainName($user['user_key']);
					$this->email->message($this->load->view('template/email', $data, true));
					if ($this->email->send())
					{
						// Création du message de succès
						$this->session->set_userdata(array('alert-type' => 'success'));
						$this->session->set_userdata(array('alert-message' => 'Un message vient d\'être envoyé à l\'adresse ' . $email . '.<br />Cliquez sur le lien présent dans ce message pour créer un nouveau mot de passe.'));
					}
					else
					{
						// Création du message d'erreur
						$this->session->set_userdata(array('alert-type' => 'alert'));
						$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite. Merci de contacter le CVI si le problème persiste.'));

					}
				}
				else
				{
					// Création du message d'erreur
					$this->session->set_userdata(array('alert-type' => 'alert'));
					$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite. Merci de contacter le CVI si le problème persiste.'));
				}
				// Redirection
				redirect();
			}	
		}
	}

	/**
	 * create : Création simplifiée d'un nouveau client (BACKEND)
	 */
	public function create()
	{
		// Fonction accessible par les doctors autorisés seulement
		if ($this->session->userdata('user_right') <= 1)
			show_404();
		// -------------------------------------------------------

		$this->config->set_item('user-nav-selected-menu', 6); // menu item 6 à highlight

		if ($this->form_validation->run() == false)
		{
			// Affichage de la vue
			$this->layout->show('backend/user/create');
		}
		else
		{
			// On récupère les champs du formulaire
			$title = $this->input->post('title');
			if($title == 'M.') $sex = 'M'; else $sex = 'F';
			$lastname = $this->input->post('lastname');
			$firstname = $this->input->post('firstname');
			$birthdate = $this->input->post('birthdate');
			// La partie lieu de naissance est sélectionnée
			if ($this->input->post('birthplace') == 'on')
			{
				$birth_city = $this->input->post('birth_city');
				$birth_country_id = $this->input->post('birth_country_id');
			}
			else
			{
				$birth_city = null;
				$birth_country_id = null;
			}
			// La partie adresse postale est sélectionnée
			if ($this->input->post('address') == 'on')
			{
				$address1 = $this->input->post('address1');
				$address2 = $this->input->post('address2');
				$postalcode = $this->input->post('postalcode');
				$city = $this->input->post('city');
				$country_id = $this->input->post('country_id');
			}
			else
			{
				$address1 = null;
				$address2 = null;
				$postalcode = null;
				$city = null;
				$country_id = null;
			}
			// La partie contact est sélectionnée
			if ($this->input->post('contact') == 'on')
			{
				$email = $this->input->post('email');
				$phone = $this->input->post('phone');
			}
			else
			{
				$email = null;
				$phone = null;
			}

			// Création du compte
				// Génération du login
			$login = generate_login($firstname, $lastname, $birthdate);
				// Génération du mot de passe
			$password = random_string('alnum', 8);

			// Création de l'utilisateur
			if ($user_key = $this->user_model->User_create($login, $password, $email, $address1, $address2, $postalcode, $city,
				$country_id, $phone, 0))
			{
				// Création du client
				if ($customer_key = $this->customer_model->Customer_create($title, $firstname, $lastname, $birthdate, $birth_city, 
					$birth_country_id, $sex, $user_key, null, null, null))
				{
					// Mise à jour de clé du customer par défaut
					$this->user_model->User_editDefaultCustomerKey($user_key, $customer_key);

					if ($this->input->post('activate') == 'on')
						$this->user_model->User_setActif($user_key);

					// Message de succès
					$this->session->set_userdata(array('alert-type' => 'success'));
					$this->session->set_userdata(array('alert-message' => 'Un nouveau client vient d\'être créé !'));
					redirect('user/view/' . $user_key);
				}
				else
				{
					// On supprime l'utilisateur
					$this->user_model->User_delete($user_key);

					// Message erreur
					$this->session->set_userdata(array('alert-type' => 'alert'));
					$this->session->set_userdata(array('alert-message' => 'Erreur lors de la création du profil. Merci de réessayer.'));
					redirect('user/create');
				}
			}
			else
			{
				// Message erreur
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Erreur lors de la création du compte. Merci de réessayer.'));
				redirect('user/create');
			}			
		}
	}

	/**
	 * activate : Active un utilisateur
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 *
	 */
	public function activate($user_key = '')
	{
		if (!empty($user_key))
		{
			// On actif l'utilisateur
			if ($this->user_model->User_setActif($user_key))
			{
				// Message de succès
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Votre compte a bien été activé.<br /><a href="login">Cliquez-ici</a> pour vous connecter.'));
				
				// Récupération des infos de l'utilisateur
				$user = $this->user_model->User_getFromKey($user_key);
			
				// Envoi e-mail
				$this->email->from('contact@cvi.fr', 'Centre de Vaccinations Internationales de Tours');
				$this->email->to($user[0]['user_email']);
				$this->email->subject('Félicitations, votre compte est activé !');
				$data['message'] = 'Votre compte a été activé avec succès.';
				$data['message'] .= '<br /><br />Vous pouvez désormais vous connecter à notre plateforme et prendre rendez-vous en ligne en utilisant les identifiants reçus dans le précédent message.';
				$data['fullName'] = $this->user_model->User_getMainName($user[0]['user_key']);
				$this->email->message($this->load->view('template/email', $data, true));					
				$this->email->send();
			}
			else
			{
				// Message d'erreur
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Échec lors de l\'activation du compte. Merci de réessayer.'));
			}
		}
		
		redirect();
	}

	/**
	 * send_activation_link : Envoie par mail le lien d'activation d'un compte utilisateur
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 *
	 */
	public function send_activation_link($user_key = '')
	{
		if (!empty($user_key))
		{
			// Récupération des infos de l'utilisateur
			$user = $this->user_model->User_getFromKey($user_key);
			
			// Envoi du message
			$this->email->from('contact@cvi.fr', 'Centre de Vaccinations Internationales de Tours');
			$this->email->to($user[0]['user_email']);
			$this->email->subject('Bienvenue !');
			$data['message'] = 'Vous venez de vous inscrire sur notre plateforme en ligne et nous vous souhaitons la bienvenue !';
			$data['message'] .= '<br />Pour finaliser cette inscription et accéder à nos services, merci d\'activer votre compte en cliquant sur le lien ci-dessous :</p>';
			$data['message'] .= '<p class="text-center"><strong><a href="' . site_url('user/activate/'.$user_key) . '">Activer mon compte</a></strong></p><p>';
			$data['message'] .= 'Si vous avez oublié votre mot de passe, <a href="' . site_url('user/password') . '">cliquez-ici</a>.';
			$data['fullName'] = $this->user_model->User_getMainName($user[0]['user_key']);
			$this->email->message($this->load->view('template/email', $data, true));					
			if($this->email->send())
			{
				// Message de succès
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Un message vient d\'être envoyé à l\'adresse ' . $user[0]['user_email'] . '.<br />Cliquez sur le lien présent dans ce message pour activer votre compte.'));
			}
			else
			{
				// Message d'erreur
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite. Merci de contacter le CVI si le problème persiste.'));
			}			
		}
		
		redirect();
	}

	/**
	 * update : Page d'édition d'un compte
	 *
	 * @param $user_key Clé de l'utilisateur à modifier
	 */
	public function update($user_key = '')
	{
		if (!$this->session->userdata('connected'))
		{
			// Page d'erreur - il faut être connecté pour accéder à cette page...
			show_404();
		}

		// Les doctors ne peuvent pas accéder à cette méthode
		if ($this->session->userdata('user_right') > 0)	   //
			show_404();									   //
		// --------------------------------------------------

		$this->config->set_item('user-nav-selected-menu', 1); // menu item 1 à highlight

		if ($user_key == '') // par défaut, on prend l'utilisateur connecté
		{
			$user_key = $this->session->userdata('user_key');

			$data = $this->user_model->User_get( array('user_key' => $user_key) );
			if ($data == null)
			{
				$this->logout(); // on le déconnecte si son compte n'existe même pas (GROS BUG chance = 0)
			} 
			else
			{
				$data['user'] = $data[0];
			}		
		}
		else
		{
			if ($this->session->userdata('user_right') <= 0)
			{
				show_404();
			}

			// On récupère les infos du compte en paramètre
			$data = $this->user_model->User_getFromKey($user_key);
			if ($data == null)
			{
				show_404();
			} 
			else
			{
				$data['user'] = $data[0];
			}
		}

		if ($this->form_validation->run('user/update') == FALSE)
		{
			// Affichage de la vue
			$this->layout->show('user/update', $data);
		}
		else
		{
			// Formulaire validé, on récupère les valeurs des champs
			$key = $user_key;
			$password = $this->input->post('newpassword');
			$email = $this->input->post('email');
			$address1 = $this->input->post('address1');
			$address2 = $this->input->post('address2');
			$postalcode = $this->input->post('postalcode');
			$city = $this->input->post('city');
			$country_id = $this->input->post('country_id');
			$phone = $this->input->post('phone');

			// Mise à jour du compte utilisateur
			if ($this->user_model->User_update($key, null, $password, $email, $address1, $address2, 
														$postalcode, $city, $country_id, $phone, 0))
			{
				// Création de l'alerte
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Vos informations ont correctement été mises à jour.'));
				redirect('user');
			}
			else
			{
				// Création de l'alerte
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite lors de la mise à jour de vos informations. Merci de réessayer'));
				redirect('user');
			}
		}
	}

	/**
	 * updateAjax : Page d'édition d'un compte (AJAX)
	 */
	public function updateAjax()
	{
		$data['success'] = false;
		$user_key = $this->input->post('user_key');

		// On regarde si l'utilisateur est autorisé à effectuer les modifications
		if ($user_key == $this->session->userdata('user_key') || $this->session->userdata('user_right') > 1)
		{
			if ($this->form_validation->run('user/updateAjax') == false)
			{
				$data['message'] = validation_errors();
			}
			else
			{				
				$key = $user_key;
				$login = $this->input->post('login');
				$password = $this->input->post('newpassword');
				$email = $this->input->post('email');
				$address1 = $this->input->post('address1');
				$address2 = $this->input->post('address2');
				$postalcode = $this->input->post('postalcode');
				$city = $this->input->post('city');
				$country_id = $this->input->post('country_id');
				$phone = $this->input->post('phone');
				$right = $this->input->post('user_right');

				if ($this->user_model->User_update($key, $login, $password, $email, $address1, $address2, 
														$postalcode, $city, $country_id, $phone, $right))
				{
					$data['success'] = true;
					$data['message'] = 'Les informations du compte ont bien été mise à jour.';
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
	 * getAllAutocomplete : Renvoi un tableau JSON des users pour l'autocomplete
	 * 						Ajax call
	 */
	public function getAllAutocomplete()
	{
		// Les doctors seulement ont accès à cette méthode
		if ($this->session->userdata('user_right') <= 0)
		{
			show_404();
		}
		// --------------------------------------------------

		// On récupère tous les utilisateurs de droits 0 (cad : les clients)
		$users = $this->user_model->User_get(array('user_right' => 0));
		$ret = array();

		// On créer un tableau JSON de la forme user_key => user_name
		foreach ($users as $user)
		{
			$entry['label'] = $this->user_model->User_getMainName($user['user_key']);
			$entry['key'] = $user['user_key'];
			array_push($ret, $entry);
		}

		echo json_encode($ret);
	}
	
	/**
	 * search : Fonction de recherche d'un utilisateur (backend)
	 * ajax call
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
			// On récupère les comptes correspond à la recherche
			$users = $this->user_model->User_search($s, $f);
		}
		else
		{
			// Aucune recherche demandée, on renvoi tout les comptes
			$users = $this->user_model->User_get();
		}
		
		// On créer le tableau de comptes utilisateurs à renvoyer
		foreach ($users as $user)
		{
			// Couleur de fond en fonction des droits du compte
			$style = ($user['user_right'] > 0) ? 'font-weight:bold;' : '';
			switch ($user['user_right'])
			{
				case 0 : $style .= 'background-color:#88ff78;'; break; // client vert
				case 1 : $style .= 'background-color:#519deb;'; break; // secrétaire jaune
				case 2 : $style .= 'background-color:#e6eb51;'; break; // personnel de soin bleu
				case 3 : $style .= 'background-color:#af51eb;'; break; // administrateur violet
				default : continue; break;
			}
			echo '<tr class="clickable" style="' . $style . '" onclick="window.location=\'' . site_url('user/view/'.$user['user_key']) . '\';">';
			echo '<td>' . $this->user_model->User_getMainName($user['user_key']) . '</td>';
			echo '<td>' . $user['user_login'] . '</td>';	
			echo '<td>' . $user['user_email'] . '</td>';
			echo '<td>' . $user['user_phone'] . '</td>';
			echo '<td>';
			if ($user['user_actif'])
				echo '<i class="fi-check"></i>';
			echo '</td>';
			echo '</tr>';
		}
	}
}

/* End of file user.php */
/* Location: ./application/controllers/user.php */?>