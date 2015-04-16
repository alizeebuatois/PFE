<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Partnership Controller Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Partnership extends CI_Controller {

	public function __construct()
	{

		parent::__construct();

		// Chargement des modèles
		$this->load->model('user_model');
		$this->load->model('customer_model');
		$this->load->model('partnership_model');

		// Cette classe n'est accessible que si l'utilisateur est connecté
		if (!$this->session->userdata('connected'))
		{
			show_404();
		}
	}
	
	/**
	 * create : Demande de relation entre deux comptes
	 * AJAX CALL
	 */
	public function create()
	{
		$data = array(
			'success' => false,
			'message' => '');

		if ($this->form_validation->run() == false)
		{
			$data['message'] = validation_errors(); // récupération des erreurs
		}
		else
		{
			// Préparation des variables pour création de la relation
			$loginA = $this->session->userdata('user_login'); // compte connecté faisant la demande
			$loginB = $this->input->post('login'); // compte à associer
			$user_a = $this->user_model->User_getForSignIn($loginA); // compte connecté faisant la demande
			$user_b = $this->user_model->User_getForSignIn($loginB); // compte à associer
			
			// Création de la relation (qui sera par défaut en attente)
			if ($this->partnership_model->Partnership_create($loginA, $loginB, $this->session->userdata('user_key')))
			{
				// Envoi du mail
				$this->email->from($this->parameters_model->Parameters_getEmailContact(), 'Centre de Vaccinations Internationales de Tours');
				$this->email->to($user_b['user_email']);
				$this->email->subject('Nouvelle demande d\'association');
				$data['fullName'] = $this->user_model->User_getMainName($user_b['user_key']);
				$data['message'] = $this->user_model->User_getMainName($user_a['user_key']) . ' (' . $user_a['user_email'] . ') souhaite associer vos deux comptes sur la plateforme web du Centre de Vaccinations Internationales du CHRU de Tours.</p><p>En acceptant cette demande, vos profils seront visibles par ' . $this->user_model->User_getMainName($user_a['user_key']) . ' (et inversement) et vous pourrez désormais prendre des rendez-vous communs.</p>';
				$data['message'] .= '<p class="text-center"><strong><a href="'. site_url('compte/famille') . '" class="button small">Accepter la demande</a></strong></p><p>';
				$this->email->message($this->load->view('template/email', $data, true));				
				if ($this->email->send())
				{
					// Succès
					$data['success'] = true;
				}
				else
				{
					// On supprime l'association si y'a une erreur qui informer l'autre compte
					$this->partnership_model->Partnership_delete($user_a['user_key'], $user_b['user_key']);
					$data['message'] = 'Une erreur s\'est produite lors de l\'association des deux comptes. Merci de réessayer.';
				}
			}
			else
			{
				// Echec
				$data['message'] = "Une erreur s'est produite lors de l'association des deux comptes. Merci de réessayer.";
			}
		}

		echo json_encode($data);
	}

	/**
	 * createFast : Demande de relation entre deux comptes (METHODE RAPIDE POUR BACKEND)
	 * AJAX CALL
	 */
	public function createFast()
	{
		$data = array(
			'success' => false,
			'reload' => false,
			'message' => '');

		// seuls le personnel de soin peut accéder à cette méthode
		if ($this->session->userdata('user_right') == 0)
		{
			$data['message'] = 'Vous n\'avez pas les droits.';
			echo json_encode($data);
			return;
		}

		if ($this->form_validation->run() == false)
		{
			$data['message'] = validation_errors();
		}
		else
		{
			// Compte à associer
			$loginA = $this->input->post('user_a');
			$loginB = $this->input->post('user_b');
			// Création de la relation (confirmée par défaut avec le second paramètre à 1)
			if ($this->partnership_model->Partnership_create($loginA, $loginB, $this->session->userdata('user_key'), 1))
			{
				// Message de succès après rechargement de la page
				$data['success'] = true;
				$data['reload'] = true;
				$this->session->set_userdata(array('alert-type' => 'success'));
				$this->session->set_userdata(array('alert-message' => 'Relation ajoutée avec succès !'));
			}
			else
			{
				$data['message'] = "Une erreur s'est produite lors de l'association des deux comptes.";
			}
		}

		echo json_encode($data);
	}

	/**
	 * cancel : Annule une relation entre deux comptes
	 * 			Si l'utilisateur b est vide, on utilise la clé de l'utilisateur connecté
	 *
	 * AJAX CALL
	 */
	public function cancel($user_key_a, $user_key_b = '')
	{
		if ($user_key_b == '')
			$user_key_b = $this->session->userdata('user_key');

		// Suppression de la relation
		if ($this->partnership_model->Partnership_delete($user_key_a, $user_key_b))
			echo json_encode(array('success' => true));
		else
			echo json_encode(array('success' => false));
	}

	/**
	 * confirm : Confirme une relation entre deux comptes clients
	 * ajax call
	 */
	public function confirm($user_key_a, $user_key_b = '')
	{
		if ($user_key_b == '')
			$user_key_b = $this->session->userdata('user_key');

		// Passage de la relation en "confirmé" (ack)
		if ($this->partnership_model->Partnership_setAck($user_key_a, $user_key_b, 'ack'))
			echo json_encode(array('success' => true));
		else
			echo json_encode(array('success' => false));
	}

}

/* End of file partnership.php */
/* Location: ./application/controllers/partnership.php */