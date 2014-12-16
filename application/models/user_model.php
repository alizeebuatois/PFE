<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * User Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class User_Model extends CI_Model {

	protected $table = 'user';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * User_get : Récupère les données d'un utilisateur selon les conditions en paramètre
	 *
	 * @param $where 	Clause WHERE
	 * @return array 	Résultat de la requête
	 *
	 */
	public function User_get($where = array())
	{
		return $this->db->where( $where )
						->from( $this->table )
						->order_by($this->table . '_creation', 'DESC')
						->get()
						->result_array();
	}
	
	/**
	 * User_getLike : Requête avec LIKE
	 *
	 * @param $field 	Champ
	 * @param $like 	Recherche
	 * @param $pos 		Position
	 * @return Résultat de la requête
	 *
	 */
	public function User_getLike($field, $like, $pos = 'both')
	{
		return $this->db->like($this->table . '_' . $field, $like, $pos)
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * User_count : Compte les utilisateurs
	 *
	 * @param $where 	Clause WHERE
	 * @return (int)
	 *
	 */
	public function User_count($where = array())
	{
		return $this->db->from($this->table)
						->where($where)
						->count_all_results();
	}

	/**
	 * User_getFromDefaultCustomerKey : Récupère les données d'un utilisateur selon son défaut customer
	 *
	 * @param $default_customer_key 	Clé du défaut customer
	 * @return array 					Résultat de la requête
	 *
	 */
	public function User_getFromDefaultCustomerKey($default_customer_key)
	{
		return $this->User_get(array($this->table . '_default_customer_key' => $default_customer_key));
	}

	/**
	 * User_getFromKey : Récupère les données d'un utilisateur à partir de sa clé
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @param array 		Résultat de la requête
	 *
	 */
	public function User_getFromKey($user_key)
	{
		return $this->User_get(array('user_key' => $user_key));
	}

	/**
	 * User_create : Créer un nouvel utilisateur dans la base de données.
	 *
	 * @param $login 		Login
	 * @param $password 	Mot de passe (non crypté)
	 * @param $email 		Adresse e-mail
	 * @param $address1 	Adresse 1
	 * @param $address2 	Adresse 2
	 * @param $postalcode 	Code postal
	 * @param $city 		Ville
	 * @param $country_id 	ID du pays
	 * @param $phone 		Numéro de téléphone
	 * @param $right 		Droits
	 * @return bool 		Résultat de la requête
	 *
	 */
	public function User_create($login, $password, $email, $address1, $address2, $postalcode, $city,
																			   $country_id, $phone, $right)
	{
		// Affectation des données aux champs de la table ´user´
		$this->db->set( $this->table . '_login', $login );
		$this->db->set( $this->table . '_password', do_hash($password) );
		$this->db->set( $this->table . '_email', $email );
		$this->db->set( $this->table . '_address1', $address1 );
		$this->db->set( $this->table . '_address2', $address2 );
		$this->db->set( $this->table . '_postalcode', $postalcode );
		$this->db->set( $this->table . '_city', $city );
		$this->db->set( $this->table . '_country_id', $country_id );
		$this->db->set( $this->table . '_phone', $phone );
		$this->db->set( $this->table . '_default_customer_key', 0 );
		$this->db->set( $this->table . '_right', $right );

		if ($right > 0) $actif = 1;
		else $actif = 0;
		$this->db->set( $this->table . '_actif', $actif );

		// Génération de la clé aléatoire
		do {
			$user_key = 'U' . random_string('alnum', 9);
		} while ($this->User_get(array('user_key' => $user_key)) != null);
		$this->db->set( $this->table . '_key', $user_key );

		// Insertion du nouvel utilisateur dans la table ´user´
		if ($this->db->insert( $this->table ))
			return $user_key;
		else
			return null;
	}

	/**
	 * User_update : Met à jour un utilisateur de la base de données
	 *
	 * @param $key 	 		Clé de l'utilisateur
	 * @param $login 		Login (null si ne pas modifier)
	 * @param $password 	Mot de passe (non crypté)
	 * @param $email 		Adresse e-mail
	 * @param $address1 	Adresse 1
	 * @param $address2 	Adresse 2
	 * @param $postalcode 	Code postal
	 * @param $city 		Ville
	 * @param $country_id 	ID du pays
	 * @param $phone 		Numéro de téléphone
	 * @param $right 		Droits de l'utilisateur
	 * @return bool 		Résultat de la requête
	 */
	public function User_update($key, $login, $password, $email, $address1, $address2, $postalcode, $city,
																			$country_id, $phone, $right)
	{
		// Affectation des données aux champs de la table ´user´
		if ($login != null)
			$this->db->set( $this->table . '_login', $login );
		if ($password != '')
			$this->db->set( $this->table . '_password', do_hash($password) );
		$this->db->set( $this->table . '_email', $email );
		$this->db->set( $this->table . '_address1', $address1 );
		$this->db->set( $this->table . '_address2', $address2 );
		$this->db->set( $this->table . '_postalcode', $postalcode );
		$this->db->set( $this->table . '_city', $city );
		$this->db->set( $this->table . '_country_id', $country_id );
		if ($phone != '')
			$this->db->set( $this->table . '_phone', $phone );
		else
			$this->db->set ($this->table . '_phone', null);
		if ($right != null)
			$this->db->set($this->table . '_right', $right);

		return $this->db->where( array($this->table . '_key' => $key) )
				 		->update( $this->table );
	}

	/**
	 * User_editDefaultCustomerId : Met à jour le ´default_customer_id´ d'un utilisateur
	 *
	 * @param $user_id 				ID de l'utilisateur
	 * @param $default_customer_id 	Nouveau défaut customer ID
	 * @return bool 				Résultat de la requête
	 *
	 */
	public function User_editDefaultCustomerKey($user_key, $default_customer_key)
	{
		return $this->db->set( $this->table . '_default_customer_key', $default_customer_key )
				 ->where( $this->table . '_key', $user_key )
				 ->update( $this->table );

	}

	/**
	 * User_delete : Supprime un utilisateur de la base de données
	 *
	 * @param $user_key 		Clé de l'utilisateur à supprimer
	 * @return bool 	Résultat de la requête
	 *
	 */
	public function User_delete($user_key)
	{
		// Suppression de l'utilisateur par son ´id´
		return $this->db->where( $this->table . '_key', $user_key)
						->delete( $this->table );
	}

	/**
	 * User_getForSignIn : Récupère un utilisateur selon son login ou son e-mail 
	 *
	 * @param $input 	Login ou adresse e-mail de l'utilisateur
	 * @return array 	Utilisateur (ou null si introuvable)
	 */
	public function User_getForSignIn($input)
	{
		// Recherche d'un utilisateur selon son ´login´ ou son ´email´
		$return = $this->db->select('*')
						->where( $this->table . '_login = "' . $input . '" OR ' .
								 $this->table . '_email = "' . $input . '" OR ' .
								 $this->table . '_key = "' . $input . '"')
						->from( $this->table )
						->limit(1)
						->get()
						->result_array();

		// Si l'utilisateur est trouvé, on retourne simplement le tableau de ses données
		if( !empty($return) )
			return $return[0];
		
		// Utilisateur non trouvé
		return null;
	}

	/**
	 * User_passwordVerification : Vérifie l'exactitude d'un mot de passe pour un utilisateur
	 *
	 * @param $login 	Login
	 * @param $password Mot de passe
	 * @return bool 	Concordance login / mot de passe
	 *
	 */
	public function User_passwordVerification($login, $password)
	{
		// Récupération de l'utilisateur
		$user = $this->User_getForSignIn($login);
		// Si celui-ci existe, vérification du mot de passe
		if( $user != null )
		{
			return ( $user[$this->table . '_password'] == do_hash($password) );
		}
		else
			return false;
	}

	/**
	 * User_setLastConnection : Met à jour le champ ´lastConnecion´ avec le timestamp courant
	 *
	 * @param $user_id 	ID de l'utilisateur à modifier
	 * @return bool 	Résultat de la requête
	 *
	 */
	public function User_setLastConnection($user_id)
	{
		return $this->db->set( $this->table . '_lastConnection', 'NOW()', false )
				 		->where( $this->table . '_id', $user_id )
						->update( $this->table );
	}

	/**
	 * User_setNewPassword : Met à jour le mot de passe d'un utilisateur
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @param $password 	Nouveau mot de passe en clair
	 *
	 */
	public function User_setNewPassword($user_key, $password)
	{
		return $this->db->set( $this->table . '_password', do_hash($password) )
				 		->where( $this->table . '_key', $user_key )
						->update( $this->table );
	}

	/**
	 * User_setActif : Met à jour le champ ´actif´
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @param $value 		Valeur à attribuer
	 * @return bool 		Résultat de la requête
	 *
	 */
	public function User_setActif($user_key, $value = 1)
	{
		if ($this->User_get (array($this->table . '_key' => $user_key)))
		{
			return $this->db->set( $this->table . '_actif', $value, false )
						->where( $this->table . '_key', $user_key)
						->update( $this->table );
		}
		return false;		
	}

	/**
	 * User_getMainName : Renvoi le nom complet de la personne associé par défaut au compte
	 *
	 * @param $user_key Clé du compte
	 * @return Nom complet de la personnel assignée par défaut au compte (customer ou doctor)
	 *
	 */
	public function User_getMainName($user_key)
	{
		$user = $this->User_getFromKey($user_key);
		if ($user != null)
		{
			$default = $user[0][$this->table . '_default_customer_key'];
			switch (str_split($default)[0])
			{
				case 'C':
					return $this->customer_model->Customer_getFullName($default);
				case 'D':
					return $this->doctor_model->Doctor_getShortName($default);
				default:
					return '<i>Profil inconnu.</i>';
			}
		}
		else
		{
			return '<i>Ce compte n\'existe plus.</i>';
		}
	}

	/**
	 * User_createPasswordReinitializationRequest : Créer une demande dans la table userPasswordRequest
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @param $hash 		Clé hash de la request
	 * @return 
	 *
	 */
	public function User_createPasswordReinitializationRequest($user_key, $hash)
	{
		$this->db->set($this->table . '_key', $user_key);
		$this->db->set($this->table . 'PasswordRequest_hash', $hash);
		return $this->db->insert($this->table . 'PasswordRequest');
	}

	/**
	 * User_getPasswordReinitializationRequestByHash : Récupère une demande de changement de mot de passe
	 *
	 * @param $hash 	Hash de la demande
	 * @return $hash et $user_key de la demande
	 *
	 */
	public function User_getPasswordReinitializationRequestByHash($hash)
	{
		return $this->db->where($this->table . 'PasswordRequest_hash', $hash)
						->from($this->table . 'PasswordRequest')
						->get()
						->result_array();
	}

	/**
	 * User_getPasswordReinitializationRequestByUserKey : Récupère une demande de changement de mot de passe
	 *
	 * @param $user_key 	Hash de la demande
	 * @return $hash et $user_key de la demande
	 *
	 */
	public function User_getPasswordReinitializationRequestByUserKey($user_key)
	{
		return $this->db->where($this->table . '_key', $user_key)
						->from($this->table . 'PasswordRequest')
						->get()
						->result_array();
	}

	/**
	 * User_deletePasswordReinitializationRequest : Supprime une demande de changement de mot de passe
	 *
	 * @param $hash 	Hash de la demande
	 * @return Résultat de la requête
	 *
	 */
	public function User_deletePasswordReinitializationRequest($hash)
	{
		return $this->db->where($this->table . 'PasswordRequest_hash', $hash)
						->delete($this->table . 'PasswordRequest');
	}
	
	/*
	 * User_search : Renvoi les utilisateurs correspondant à un filtre et un mot clé
	 *
	 * @param $s 	Mot clé
	 * @param $f 	Filtre
	 * @return Résultat de la requête
	 *
	 */
	public function User_search($s, $f)
	{
		switch ($f)
		{
			case 'login': return $this->User_getLike('login', $s);
			case 'email': return $this->User_getLike('email', $s);
			case 'phone': return $this->User_getLike('phone', $s);
			case 'titulaire':	$customerByFirstname = $this->customer_model->Customer_getLike('firstname', $s);
								$customerByLastname = $this->customer_model->Customer_getLike('lastname', $s);
								$doctorByFirstname = $this->doctor_model->Doctor_getLike('firstname', $s);
								$doctorByLastname = $this->doctor_model->Doctor_getLike('lastname', $s);
								$customers = array_merge($customerByFirstname, $customerByLastname);
								$doctors = array_merge($doctorByFirstname, $doctorByLastname);
								$ret = array();
								foreach($customers as $customer)
								{
									$user = $this->user_model->User_getFromKey($customer['customer_user_key']);
									if ($user != null)
										array_push($ret, $user[0]);
								}
								foreach($doctors as $doctor)
								{
									$user = $this->user_model->User_getFromDefaultCustomerKey($doctor['doctor_key']);
									if ($user != null)
										array_push($ret, $user[0]);
								}
								return $ret;
			default: return $this->User_getLike('login', $s);
		}
	}

}
// END User Model Class

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */