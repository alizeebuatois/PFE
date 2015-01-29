<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Page Controller Class
 *
 * Le contrôleur Page a été conçu pour permettre l’utilisation de pages fixes pour le site internet 
 * comme la page d’accueil ou encore la page « Qui sommes-nous ? ». Également, ce contrôleur peut 
 * être utilisé pour une méthode n’ayant pas sa place dans aucune des autres classes du système. 
 * C’est le cas de contact. Les vues associées au contrôleur Page sont placées dans le dossier 
 * application/views/page.
 *
 * Il est important de noté que les méthodes du contrôleur Page se sont vus assigner des routes 
 * dans le fichier application/config/routes.php afin d’éviter les URL du type www.monsite.fr/page/index.
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Page d'accueil
	 */
	public function index()
	{
		$this->layout->show('page/home');
	}

	/**
	 * Page Qui somme-nous ?
	 */
	public function about_us()
	{
		$this->layout->show('page/about-us');
	}

	/**
	 * Page Bien voyager
	 */
	public function good_trip()
	{
		$this->layout->show('page/good-trip');
	}

	/**
	 * Page de contact
	 */
	public function contact()
	{
		if ($this->form_validation->run('contact') == false)
		{
			$this->layout->show('page/contact');
		}
		else
		{
			// Envoi du mail
			$fullName = $this->input->post('firstname') . ' ' . $this->input->post('lastname');
			$this->email->from($this->input->post('email'), $fullName);
			$this->email->to($this->parameters_model->Parameters_getEmailContact());
			$this->email->subject($this->input->post('subject'));
			$data['message'] = '<strong>' . $fullName . ' a envoyé un message depuis le site du CVI :</strong></p><p>';
			$data['message'] .= nl2br($this->input->post('message'));
			$data['sign'] = '<strong>' . $fullName . '</strong><br />' . $this->input->post('email');
			$this->email->message($this->load->view('template/email', $data, true));
			if($this->email->send())
			{
				// Message de succès
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Merci ! Votre message a bien été envoyé.'));
				redirect('contact');
			}
			else
			{
				// Message d'erreur
				$this->session->set_userdata(array('alert-type' => 'alert'));
				$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite lors de l\'envoi de votre message. Merci de réessayer.'));
				redirect('contact');
			}
		}	
	}

	/**
	 * Page d'inscription
	 */
	public function subscribe()
	{
		// Chargement des modèles utilisateur
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->model('country_model');

		// Si l'utilisateur est déjà connecté, on affiche une alerte
		if( $this->session->userdata('connected') )
		{
			$this->session->set_userdata(array('alert-type' => 'warning', 
				'alert-message' => 'Hey, vous êtes déjà connecté. Pas la peine de créer un nouveau compte.'));
			redirect();
		}
		
		// Si le formulaire d'inscription a été validé
		if( $this->form_validation->run('subscribe') )
		{
			// Récupération des données du formulaire
			$title = $this->input->post('title');
			$lastname = $this->input->post('lastname');
			$firstname = $this->input->post('firstname');
			$birthdate = $this->input->post('birthdate_year') . '-' . $this->input->post('birthdate_month') . '-' . $this->input->post('birthdate_day');
			$birthcity = $this->input->post('birthcity');
			$birth_country_id = $this->input->post('birth_country_id');
			if($title == 'M.') $sex = 'M'; else $sex = 'F';
			$address1 = $this->input->post('address1');
			$address2 = $this->input->post('address2');
			$postalcode = $this->input->post('postalcode');
			$city = $this->input->post('city');
			$country_id = $this->input->post('country_id');
			$email = $this->input->post('email');

			// Génération du login
			// Premières lettres des nom/prenom plus date de naissance
			$login = generate_login($firstname, $lastname, $birthdate);

			// On génère le mot de passe
			$password = random_string('alnum', 8);

			// Création de l'utilisateur
			if( $user_key = $this->user_model->User_create($login, $password, $email, $address1,
											   	$address2, $postalcode, $city, $country_id, null, 0) )
			{
				// Récupération de l'ID de l'utilisateur qui vient d'être ajouté
				$user = $this->user_model->User_get( array('user_email' => $email) );
				$user = $user[0];

				// Création du client
				if( ($customer_key = $this->customer_model->Customer_create($title, $firstname, $lastname, 
					$birthdate, $age, $birthcity, $birth_country_id, $weight, $sex, $user['user_key'])) != null )
				{
					// Mis à jour de la clé du défaut customer pour l'utilisateur venant d'être créé
					if( $this->user_model->User_editDefaultCustomerKey($user['user_key'], $customer_key) )
					{
						// Envoi du mail contenant le lien pour l'activation
						$this->email->from('contact@cvi.fr', 'Centre de Vaccinations Internationales de Tours');
						$this->email->to($email);
						$this->email->subject('Bienvenue !');
						$data['message'] = 'Vous venez de vous inscrire sur notre plateforme en ligne et nous vous souhaitons la bienvenue !';
						$data['message'] .= '<br />Pour finaliser cette inscription et accéder à nos services, merci d\'activer votre compte en cliquant sur le lien ci-dessous :';
						$data['message'] .= '</p><p class="text-center"><strong><a href="' . site_url('user/activate/'.$user_key) . '">Activer mon compte</a></strong></p><p>';
						$data['message'] .= 'Une fois votre compte activé, connectez-vous avec les identifiants suivants :<br /><br />';
						$data['message'] .= '<strong>Identifiant : </strong>' . $login . ' <i>(ou votre adresse e-mail ' . $email . ')</i><br />';
						$data['message'] .= '<strong>Mot de passe : </strong>' . $password;
						$data['fullName'] = $this->user_model->User_getMainName($user_key);
						$this->email->message($this->load->view('template/email', $data, true));					
						if($this->email->send())
						{
							// Redirection vers la page d'accueil avec le message de succès
							$this->session->set_userdata(array('alert-type' => 'success'));
							$this->session->set_userdata(array('alert-message' => 'Félicitations, votre inscription est un succès ! Regardez dans votre boîte e-mail pour activer votre compte.'));
							redirect();
						}
						else
						{
							// Message d'erreur
							$this->session->set_userdata(array('alert-type' => 'alert'));
							$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite lors de l\'envoi de vos identifiants. Merci de contacter le CVI afin d\'activer votre compte.'));
							redirect();
						}
					}						
					return;
				}
				// Si la création du client échoue, on supprime l'utilisateur
				else
				{
					// Suppression de l'utilisateur qui vient d'être créé
					$this->user_model->User_delete($user_key);
					// Message d'erreur
					$this->session->set_userdata(array('alert-type' => 'alert'));
					$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite. Merci de contacter le CVI si le problème persiste.'));
					redirect();
				}
			}
			// Message d'erreur
			$this->session->set_userdata(array('alert-type' => 'alert'));
			$this->session->set_userdata(array('alert-message' => 'Une erreur s\'est produite. Merci de contacter le CVI si le problème persiste.'));
			redirect();
		}
		else
		{
			// Affichage de la vue du formulaire d'inscription
			$this->layout->show('page/subscribe');
		}		
	}

}

/* End of file page.php */
/* Location: ./application/controllers/page.php */