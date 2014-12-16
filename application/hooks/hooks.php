<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Hooks Classes
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Autologin extends CI_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();

		// Chargement du modèle autologin
		$this->load->model('autologin_model');
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->model('doctor_model');
	}

	/**
	 * Set_auto_login : Regarde si un auto login doit être effectué et connecte l'utilisateur si besoin
	 * 					Le cookie est alors recréé avec un nouveau hash qui est mis à jour dans la bdd
	 */
	public function set_auto_login()
	{
		if( ! $this->session->userdata('connected') && ($cookie = get_cookie('cvi_user_auto_login')) != null )
		{
			$cookieValue = explode('/', $cookie);
			if ($this->autologin_model->Autologin_reset($cookieValue[0], $cookieValue[1]))
			{
				$user = $this->user_model->User_get( array('user_key' => $cookieValue[0]));
				if ($user != null)
				{
					// Création de la session
					$newSession = array(
						'connected' => true,
						'user_key' => $user[0]['user_key'],
						'user_login' => $user[0]['user_login'],
						'user_lastConnection' => $user[0]['user_lastConnection'],
						'user_right' => $user[0]['user_right']
					);
					$this->session->set_userdata($newSession);

					if ($user[0]['user_right'] == 0)
					{
						$this->session->set_userdata('user_default_customer_key', $user[0]['user_default_customer_key']);
						$this->session->set_userdata('user_fullname',
							$this->customer_model->Customer_getFullName($user[0]['user_default_customer_key']));
						redirect();
					}
					else
					{
						$this->session->set_userdata('user_doctor_key', $user[0]['user_default_customer_key']);
						$this->session->set_userdata('user_fullname',
							$this->doctor_model->Doctor_getFullName($user[0]['user_default_customer_key']));
						redirect('dashboard');
					}
				}		
			}
		}
	}

}