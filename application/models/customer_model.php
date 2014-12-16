<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Customer Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Customer_Model extends CI_Model {

	protected $table = 'customer';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Customer_get : Récupère les données d'un client selon les conditions en paramètre
	 *
	 * @param $where 	Condition WHERE
	 * @return array 	Résultat de la requête
	 *
	 */
	public function Customer_get($where = array())
	{
		return $this->db->where($where)
						->from($this->table)
						->order_by($this->table . '_id', 'DESC')
						->get()
						->result_array();
	}
	
	/**
	 * Customer_getLike : Requête avec Like
	 *
	 * @param $field 	Champ
	 * @param $like 	Recherche
	 * @param $pos		Position
	 * @return Résultat de la requête
	 *
	 */
	public function Customer_getLike($field, $like, $pos = 'both')
	{
		return $this->db->like($this->table . '_' . $field, $like, $pos)
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * Customer_getFromKey : Récupère les données d'un client depuis sa clé
	 *
	 * @param $customer_key 	Clé du client
	 * @return array 			Résultat de la requête
	 *
	 */
	public function Customer_getFromKey($customer_key)
	{
		return $this->Customer_get(array('customer_key' => $customer_key));
	}

	/**
	 * Customer_getFromUserKey : Récupère les clients d'un utilisateur
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @return array 			Résultat de la requête
	 *
	 */
	public function Customer_getFromUserKey($user_key)
	{
		return $this->Customer_get(array($this->table . '_user_key' => $user_key));
	}

	/**
	 * Customer_getFullName : Renvoie le nom complet d'un client via sa clé
	 *
	 * @param $customer_key 	Clé du client
	 * @return string 			Nom complet du client
	 *
	 */
	public function Customer_getFullName($customer_key)
	{
		$customer = $this->Customer_getFromKey($customer_key);
		if ($customer != null)
		{
			$customer = $customer[0];
			return $customer['customer_title'] . ' ' . strtoupper($customer['customer_lastname']) . ' ' . $customer['customer_firstname'];
		}
		else
			return '<span style="color:red">&times</span>';
	}

	/**
	 * Customer_getAllFamily : Renvoi un tableau des membres d'une même famille
	 *						   PARTNERSHIP INCLUE
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @return array 		Tableau des membres d'une même famille
	 *
	 */
	public function Customer_getAllFamily($user_key)
	{
		// Chargement du modèle `partnership`
		$this->load->model('partnership_model');

		// Récupération des profils du compte courant
		$ownfamily = $this->Customer_get(array($this->table . '_user_key' => $user_key));

		// Récupération des profils du compte associé
		$partnerships = $this->partnership_model->Partnership_getFromUserKey($user_key);
		$partnerfamily = array();
		foreach($partnerships as $partnership)
		{
			$customersToAdd = null;
			if ($partnership['partnership_a_user_key'] == $user_key)
				$partner_key = $partnership['partnership_b_user_key'];
			if ($partnership['partnership_b_user_key'] == $user_key)
				$partner_key = $partnership['partnership_a_user_key'];

			$customersToAdd = $this->customer_model->Customer_getFromUserKey($partner_key);

			if ($customersToAdd != null)
			{
				foreach($customersToAdd as $customer)
					array_push($partnerfamily, $customer);
			}
		}		

		return array_merge($ownfamily, $partnerfamily);
	}

	/**
	 * Customer_create : Créer un client dans la base de données.
	 *
	 * @param $title 			Civilité
	 * @param $firstname 		Prénom
	 * @param $lastname 		Nom de famille
	 * @param $birthdate 		Date de naissance
	 * @param $birthcity 		Ville de naissance
	 * @param $birth_country_id ID du pays de naissance 
	 * @param $sex 				Sexe (M ou F)
	 * @param $numsecu 			Numéro de sécurité social
	 * @param $bloodgroup		Groupe sanguin
	 * @param $doctor_id		ID du médecin traîtant
	 * @param $user_key			Clé de l'utilisateur associé
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Customer_create($title, $firstname, $lastname, $birthdate, $age, $birthcity, 
		 						 $birth_country_id, $weight, $sex, $user_key, $numsecu = null, $bloodgroup = null, 
		 						 $doctor_id = null) 
	{
		// Affectation des données aux champs de la table ´customer´
		$this->db->set( $this->table . '_title', $title );
		$this->db->set( $this->table . '_firstname', $firstname );
		$this->db->set( $this->table . '_lastname', $lastname );
		$this->db->set( $this->table . '_birthdate', $birthdate );
		$this->db->set( $this->table . '_age', $age );
		$this->db->set( $this->table . '_birthcity', $birthcity );
		$this->db->set( $this->table . '_birth_country_id', $birth_country_id );
		$this->db->set( $this->table . '_weight', $weight );
		$this->db->set( $this->table . '_sex', $sex );
		$this->db->set( $this->table . '_numsecu', $numsecu );
		$this->db->set( $this->table . '_bloodgroup', strtoupper($bloodgroup) );
		$this->db->set( $this->table . '_doctor_id', $doctor_id );
		$this->db->set( $this->table . '_medicalInfo_id', null );
		$this->db->set( $this->table . '_medicalRecord_id', null );
		$this->db->set( $this->table . '_user_key', $user_key );

		// Génération de la clé aléatoire
		do {
			$customer_key = 'C' . random_string('alnum', 9);
		} while ($this->Customer_get(array('customer_key' => $customer_key)) != null);
		$this->db->set( $this->table . '_key', $customer_key );

		// Insertion du nouvel utilisateur dans la table ´customer´
		if( $this->db->insert( $this->table ) )
		{
			// Retourne la clé du nouveau client 
			$data = $this->Customer_get( array ( $this->table . '_user_key' => $user_key) );
			return $data[0]['customer_key'];
		}

		return null;
	}

	/**
	 * Customer_update : Modifie les données d'un client dans la base de donnée
	 *
	 * @param $customer_key 	Clé du client à modifier
	 * @param $title 			Civilité
	 * @param $firstname 		Prénom
	 * @param $lastname 		Nom de famille
	 * @param $birthdate 		Date de naissance
	 * @param $birthcity 		Ville de naissance
	 * @param $birth_country_id ID du pays de naissance 
	 * @param $sex 				Sexe (M ou F)
	 * @param $numsecu 			Numéro de sécurité social
	 * @param $bloodgroup		Groupe sanguin
	 * @param $doctor_id		ID du médecin traîtant
	 * @return bool 			Résultat de la requête 
	 *
	 */
	public function Customer_update($customer_key, $title, $firstname, $lastname, $birthdate, $age, $birthcity, $birth_country_id, $weight,
												$sex, $numsecu = null, $bloodgroup = null, $doctor_id = null)
	{
		// Affectation des données aux champs de la table ´customer´
		$this->db->set ($this->table . '_title', $title);
		$this->db->set ($this->table . '_firstname', $firstname);
		$this->db->set ($this->table . '_lastname', $lastname);
		$this->db->set ($this->table . '_birthdate',  $birthdate);
		$this->db->set ($this->table . '_age',  $age);

		if (!empty($birthcity))
			$this->db->set ($this->table . '_birthcity', $birthcity);
		else
			$this->db->set ($this->table . '_birthcity', null);

		if ($birth_country_id != 0)
			$this->db->set ($this->table . '_birth_country_id', $birth_country_id);
		else
			$this->db->set ($this->table . '_birth_country_id', null);

		if ($birth_country_id != 0)
			$this->db->set ($this->table . '_weight', $weight);
		else
			$this->db->set ($this->table . '_weight', null);

		$this->db->set ($this->table . '_sex', $sex);
		
		if (!empty($numsecu))
			$this->db->set ($this->table . '_numsecu', $numsecu);
		else
			$this->db->set ($this->table . '_numsecu', null);
		if (!empty($bloodgroup))
			$this->db->set ($this->table . '_bloodgroup', strtoupper($bloodgroup));
		else
			$this->db->set ($this->table . '_bloodgroup', null);
		if (!empty($doctor_id))
			$this->db->set ($this->table . '_doctor_id', $doctor_id);
		else
			$this->db->set ($this->table . '_doctor_id', null);

		// Mise à jour de la table
		return $this->db->where(array($this->table . '_key' => $customer_key))
						->update($this->table);

	}

	/**
	 * Customer_delete : Supprime un client de la base de données
	 *
	 * @param $id 		ID du client à supprimer
	 * @return bool 	Résultat de la requête
	 *
	 */
	public function Customer_delete($id)
	{
		return $this->db->where( $this->table . '_id', $id)
						->delete( $this->table );
	}

	/**
	 * Customer_updateMedicalInfo_id : Met à jour l'id des infos médicales d'un client
	 */
	public function Customer_updateMedicalInfo_id($customer_key, $medicalInfo_id)
	{
		$this->db->set($this->table . '_medicalInfo_id', $medicalInfo_id);
		return $this->db->where($this->table . '_key', $customer_key)
						->update($this->table);
	}

	/**
	 * Customer_updateMedicalRecord_id : Met à jour l'id du dossier médical d'un client
	 */
	public function Customer_updateMedicalRecord_id($customer_key, $medicalRecord_id)
	{
		$this->db->set($this->table . '_medicalRecord_id', $medicalRecord_id);
		return $this->db->where($this->table . '_key', $customer_key)
						->update($this->table);
	}

	/**
	 * Customer_isChild : Renvoi true si le client est un enfant
	 *
	 * @param $customer_key 	Clé du client
	 * @return true or false si le client est un enfant
	 *
	 */
	public function Customer_isChild($customer_key)
	{
		
		$customer = $this->Customer_getFromKey($customer_key);
		if ($customer != null)
		{
			$birthdate = new DateTime($customer[0][$this->table . '_birthdate']);
			if ($birthdate->diff(new DateTime('now'))->format('%y') < 10)
				return true;
		}
		return false;
	}

	/**
	 * Customer_exists : Renvoi true ou false si le client existe
	 *
	 * @param $customer_key 	Clé du client
	 * @param $user_key 		Clé facultatif de l'utilisateur
	 * @return true or false
	 *
	 */
	public function Customer_exists($customer_key, $user_key = '')
	{
		$customer = $this->Customer_getFromKey($customer_key);
		if ($customer != null)
		{
			$customer = $customer[0];
			if ($user_key != '')
			{	
				if ($customer[$this->table .'_user_key'] == $user_key)
				{
					return true;
				}
				else
				{
					// on vérifie s'il existe par le biais d'un partnership
					$this->load->model('partnership_model');
					$partnerships = $this->partnership_model->Partnership_getFromUserKey($user_key);
					foreach($partnerships as $partnership)
					{
						if ($partnership['partnership_a_user_key'] == $customer[$this->table .'_user_key'] ||
							$partnership['partnership_b_user_key'] == $customer[$this->table .'_user_key'])

							return true;
					}
				}
			}
			else
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * Customer_hasDisease : Renvoi tue si le client est atteint de maladies
	 *
	 * @param $customer_key 	Clé du client
	 * @param $fields 			Tableau indiquant les champs à regarder
	 * @return true or false selon que le client a des maladies ou non
	 *
	 */
	public function Customer_hasDisease($customer_key, $fields)
	{
		// Données du client
		$customer = $this->Customer_getFromKey($customer_key);
		if ($customer != null)
		{
			// Données médicales du client
			$this->load->model('medicalInfo_model');
			$medical_info = $this->medicalInfo_model->MedicalInfo_getFromId($customer[0][$this->table . '_medicalInfo_id']);
			if ($medical_info == null)
				return false;
			// On regarde les champs
			foreach($fields as $field)
			{
				$medicalinfo_field = $medical_info['medicalInfo_' . $field];
				// Si le champ est différent de null et non vide, y'a une maladie...
				if ($medicalinfo_field != null && !empty($medicalinfo_field))
					return true;
			}
		}
		return false;
	}
	
	/*
	 * Customer_search : Renvoi les clients correspondant à un filtre et un mot clé
	 *
	 * @param $s 	Mot clé
	 * @param $f 	Filtre
	 * @return Résultat de la requête
	 *
	 */
	public function Customer_search($s, $f)
	{
		switch ($f)
		{	
			case 'fullname' : $split = explode(' ', $s);
							  $matchesLastname = array();
							  $matchesFirstname = array();
							  $ret = array();
							  foreach ($split as $s)
							  {
							  	  $matchesLastname = array_merge($matchesLastname, $this->Customer_getLike('lastname', $s));
							 	  $matchesFirstname = array_merge($matchesFirstname, $this->Customer_getLike('firstname', $s));
							  }
							  foreach ($matchesLastname as $match)
							  {
								  if (in_array($match, $matchesFirstname))
								  	array_push($ret, $match);
							  }
							  foreach ($matchesFirstname as $match)
							  {
								  if (in_array($match, $matchesLastname) && !in_array($match, $ret))
								  	array_push($ret, $match);
							  }
							  return $ret;
			case 'lastname' : return $this->Customer_getLike('lastname', $s);
			case 'firstname' : return $this->Customer_getLike('firstname', $s);
			case 'birthcity' : return $this->Customer_getLike('birthcity', $s);
			case 'bloodgroup' : return $this->Customer_getLike('bloodgroup', $s);
			default: return $this->Customer_getLike('lastname', $s);
		}
	}
	
}
// END Customer Model Class

/* End of file customer_model.php */
/* Location: ./application/models/customer_model.php */