<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Partnership Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Partnership_Model extends CI_Model {

	protected $table = 'partnership';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		// Chargement du modèle ´user´
		$this->load->model('user_model');
	}

	/**
	 * Partnership_get : Récupère les informations de relation d'un ou deux users
	 *
	 * @param $where 		Clause WHERE
	 * @return array 		Résutlat de la requête
	 *
	 */
	public function Partnership_get($where)
	{
		return $this->db->where ($where)
					 	->from ($this->table)
					 	->get()
					 	->result_array();
	}

	/**
	 * Partnership_delete : Supprime une relation selon deux clés utilisateur
	 *
	 * @param $partnership_id 	ID de la relation
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Partnership_delete($user_key_a, $user_key_b)
	{
		return ($this->db->where(
			array($this->table . '_a_user_key' => $user_key_a,
				  $this->table . '_b_user_key' => $user_key_b)
			)
			->delete($this->table) && $this->db->where(
			array($this->table . '_a_user_key' => $user_key_b,
				  $this->table . '_b_user_key' => $user_key_a)
			)
			->delete($this->table));
	}

	/**
	 * Partnership_getPartnersKey : Renvoi les relations d'un utilisateur
	 *
	 * @param $user_key 	Clé de l'utilisateur
	 * @param $ack 			Statut des relations recherchées (true par défault)
	 * @return array 		Tableau des clé des utilisateurs associés
	 *
	 */
	public function Partnership_getFromUserKey($user_key, $ack = true)
	{
		// On récupère l'ensemble des entré correspondant à l'utilisateur en paramètre
		$data = $this->db->where($this->table . '_ack', $ack)
						 ->where($this->table . '_a_user_key', $user_key)
					   	 ->or_where($this->table . '_b_user_key', $user_key)
					   	 ->from($this->table)
						 ->get()
						 ->result_array();

		$ret = array();
		if ($data != null)
		{
			foreach($data as $partnership)
			{
				if ($partnership[$this->table . '_ack'] == $ack)
				{
					array_push($ret, $partnership);
				}
			}
			return $ret;
		}

		// On renvoie un tableau vide si l'utilisateur n'a aucun partenaire
		return array();		
	}

	/**
	 * Partnership_getPartnersKey : Renvoi les clé des partenaires d'un utilisateur
	 *
	 * @param $user_key 	Clé d'un utilisateur
	 * @param $ack 			Ack
	 * @return array()		Ensemble des clés des partenaires
	 *
	 */
	public function Partnership_getPartnersKey($user_key, $ack = true)
	{
		$listOfPartnersKey = array();

		// On récupère les relations
		$partnerships = $this->Partnership_getFromUserKey($user_key, $ack);
		foreach($partnerships as $partnership)
		{
			if ($partnership[$this->table . '_a_user_key'] == $user_key)
				array_push($listOfPartnersKey, $partnership[$this->table . '_b_user_key']);
			else if($partnership[$this->table . '_b_user_key'] == $user_key)
				array_push($listOfPartnersKey, $partnership[$this->table . '_a_user_key']);
		}
		// On renvoie la liste des clés
		return $listOfPartnersKey;
	}

	/**
	 * is_partnership_ack : Regarde si la relation est confirmée ou non
	 *
	 * @param $user_key_a 	Clé d'un utilisateur A
	 * @param $user_key_b 	Clé d'un utilisateur B
	 * @return bool
	 *
	 */
	public function is_partnership_ack($user_key_a, $user_key_b)
	{
		$where1 = array($this->table . '_a_user_key' => $user_key_a,
						$this->table . '_b_user_key' => $user_key_b);
		$where2 = array($this->table . '_b_user_key' => $user_key_a,
						$this->table . '_a_user_key' => $user_key_b);

		$data = $this->db->where ($where1)
						 ->or_where ($where2)
						 ->from ($this->table)
						 ->get()
						 ->result_array();

		if ($data != null)
		{
			return ($data[0][$this->table . '_ack'] == 1);
		}
		
		return 0;
	}

	/**
	 * Partnership_create : Créer une relation entre deux comptes
	 *
	 * @param $loginA 	Login ou adresse e-mail du compte A
	 * @param $loginB 	Login ou adresse e-mail du compte B
	 * @param $status 	Statut de la relation (confirmer = 1 ou non = 0)
	 * @return bool 	Résultat de la requête
	 *
	 */
	public function Partnership_create($loginA, $loginB, $creator_user_key, $ack = 0)
	{
		$accountA = $this->user_model->User_getForSignIn($loginA);
		$accountB = $this->user_model->User_getForSignIn($loginB);

		if ($accountA != null && $accountB != null)
		{
			$this->db->set ($this->table . '_a_user_key', $accountA['user_key']);
			$this->db->set ($this->table . '_b_user_key', $accountB['user_key']);
			$this->db->set ($this->table . '_creator_user_key', $creator_user_key);
			$this->db->set ($this->table . '_ack', $ack);
			$this->db->set ($this->table . '_creation', 'NOW()', false);

			return $this->db->insert ($this->table);
		}

		return false;
	}

	/**
	 * Partnership_setAck : Modifie la valeur ´partnership_ack´
	 *
	 * @param $partnership_a_user_key 	Clé de l'utilisateur
	 * @param $partnership_b_user_key 	Clé de l'utilisateur
	 * @param $status 			Valeur du statut
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Partnership_setAck($partnership_a_user_key, $partnership_b_user_key, $status = null)
	{
		if ($status === "ack") $ack = 1;
		else $ack = 0;
		return $this->db->set($this->table . '_ack', $ack)
						->where(array(
							$this->table . '_a_user_key' => $partnership_a_user_key,
							$this->table . '_b_user_key' => $partnership_b_user_key))
						->or_where(array(
							$this->table . '_b_user_key' => $partnership_a_user_key,
							$this->table . '_a_user_key' => $partnership_b_user_key))
						->update($this->table);
	}

}
// END Partnership Model Class

/* End of file partnership_model.php */
/* Location: ./application/models/partnership_model.php */