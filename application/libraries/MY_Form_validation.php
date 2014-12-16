<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Form validation
 * 
 */

class MY_Form_validation extends CI_Form_validation {

    public function __construct($config = array())
    {
		parent::__construct($config);
		log_message('DEBUG', 'MY FORM VALIDATION Initialized!!');		
    }

    /**
     * User_loggable : Test si un login/e-mail et son mot de passe correspondent
     *
     * @return bool
     *
     */
    public function user_loggable()
    {
		// Chargement du modèle ´user´
		$CI =& get_instance();
		$CI->load->model('user_model');

		// Récupération des champs ´login´ et ´mot de passe´
		$login = strtoupper($CI->input->post('login'));
		$password = $CI->input->post('password');

		if ($CI->user_model->User_passwordVerification($login, $password))
		{
		    // Retourne VRAI si le ´password´ est correct pour le ´login´ donné
		    return true;
		}

		// Retourne FAUX sinon
		return false;
    }

    /**
     * User_unique_email : Vérifie la disponibilité d'une adresse e-mail lors d'un user/update
     *
     * @param $email		E-mail à vérifier
     * @return bool
     *
     */
    public function user_unique_email($email)
    {
		// Chargement du modèle ´user´
		$CI =& get_instance();
		$CI->load->model('user_model');

		// Recherche des utilisateurs ayant la même adresse e-mail
		// Et extraction de l'utilisateur en train de mettre à jour son profil
		$where = array('user_email' => $email,
				       'user_key <>' => $CI->input->post('user_key'));

		if ($CI->user_model->User_get($where) != null)
		{
		    // Retourne FAUX si aucun autre utilisateur avec la main adresse e-mail a été trouvé
		    return false;
		}

		// Retourne VRAI si un autre utilisateur avec la même adresse a été trouvé
		return true;
    }

    /**
     * User_check_password : Vérifie que le mot de passe entré est correct pour l'édition du compte
     *
     * @param $password     Mot de passe à vérifier
     * @return bool     
     *
     */
    public function user_check_password($password)
    {
		// Chargement du modèle ´user´
		$CI =& get_instance();
		$CI->load->model('user_model');

		// Récupération du mot de passe utilisateur
		$user = $CI->user_model->User_getFromKey($CI->session->userdata('user_key'));
		if ($user != null)
		{
		    return ($user[0]['user_password'] == do_hash($password));
		}

		// On retourne FAUX si l'utilisateur est introuvable
		return false;
    }

    /**
     * user_exists : Vérifie que l'utilisateur existe
     *
     * @param   $str    Login ou adresse e-mail
     * @return  bool
     *
     */
    public function user_exists($str, $include_doctor = false)
    {  
		// Chargement du modèle ´user´
		$CI =& get_instance();
		$CI->load->model('user_model');

		// Récupération de l'utilisateur
		$user = $CI->user_model->User_getForSignIn($str);
		if ($user != null)
        {
            if ($user['user_right'] == 0)
                return true;
            else
            {
                if ($include_doctor)
                    return true;
                else
                    return false;
            }
        }

		// On retourne FAUX si l'utilisateur est introuvable
		return false;
    }

    /**
     * is_adult : Vérifie de l'année correspond à une personne majeure
     *
     * @param $year     Année 
     * @return bool
     *
     */
    public function is_adult($year)
    {
        $currentYear = new DateTime();
        $currentYear = $currentYear->format('Y');

        return ($currentYear - $year) >= 18;
    }

    /**
     * is_child : Vérifie de l'année correspond à une personne mineure
     *
     * @param $year     Année 
     * @return bool
     *
     */
    public function is_child($year)
    {
        $CI =& get_instance();

        $currentYear = new DateTime();
        $currentYear = $currentYear->format('Y');

        // S'il s'agit du compte principal, on autorise qu'il soit majeur
        if ($CI->input->post('customer_key') == $CI->session->userdata('user_default_customer_key'))
            return true;

        return ($currentYear - $year) < 18;
    }

    /**
     * partnership_not_self : Vérifie que l'utilisateur n'est pas en train d'associer son propre compte
     *
     * @param $str  Adresse e-mail
     * @return bool
     *
     */
    public function partnership_not_self($str, $otherUser = '')
    {
		// Chargement du modèle ´user´
		$CI =& get_instance();
		$CI->load->model('user_model');

		// Récupération de l'utilisateur
		$user = $CI->user_model->User_getForSignIn($str);
		if ($user != null)
		{
            if (empty($otherUser))
                return  (!($user['user_key'] == $CI->session->userdata('user_key')));
            else
            {
                $user2 = $CI->user_model->User_getForSignIn($CI->input->post($otherUser));
                return  (!($user['user_key'] == $user2['user_key']));
            }
		}

		// On retourne TRUE si l'utilisateur est introuvable
		return true;
    }

    /**
     * partnership_unique : Vérifie que la relation n'existe pas déjà
     *
     * @param $str  Adresse e-mail
     * @return bool
     *
     */
    public function partnership_unique($str, $otherUser = '')
    {
        // Chargement du modèle ´user´
        $CI =& get_instance();
        $CI->load->model('user_model');

        // Récupération de l'utilisateur
        $user = $CI->user_model->User_getForSignIn($str);
        if ($user != null)
        {
            if (!empty($otherUser))
            {
                $user2 = $CI->user_model->User_getForSignIn($CI->input->post($otherUser));
                $user2_key = $user2['user_key'];
            }
            else
            {
                $user2_key = $CI->session->userdata('user_key');
            }

            $tot = 0;
            $query = $this->CI->db->limit(1)->get_where('partnership', array(
                                         'partnership_a_user_key' => $user2_key,
                                         'partnership_b_user_key' => $user['user_key']));
        
            $tot += $query->num_rows();

            $query = $this->CI->db->limit(1)->get_where('partnership', array(
                                         'partnership_b_user_key' => $user2_key,
                                         'partnership_a_user_key' => $user['user_key']));
            
            $tot += $query->num_rows();
            
            return $tot === 0;
        }

        return true; 
    }

}