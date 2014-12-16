<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Autologin Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Autologin_Model extends CI_Model {

	protected $table = 'user_auto_login';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		// Chargement des helper
		$this->load->helper('security');
	}

	/**
	 * Autologin_set : Créer ou édite une entrée dans la table ´user_auto_login´
	 *
	 * @param $user_id 	ID de l'utilisateur
	 * @return $hash 	Hash généré (null si échec)
	 *
	 */
	public function Autologin_set($user_key)
	{
		// Génération du hash
		$hash = do_hash( random_string('alnum',15), 'md5' );

		// Affectation des champs
		$this->db->set( $this->table . '_user_key', $user_key );
		$this->db->set( $this->table . '_hash', $hash );
		$this->db->set( $this->table . '_creation', 'NOW()', false );

		// Test si une entrée existe déjà pour l'utilisateur
		$data = $this->db->where( array($this->table . '_user_key' => $user_key) )
						 ->from( $this->table )
						 ->get()
						 ->result_array();

		set_cookie( array(
			'name' => 'cvi_user_auto_login',
			'value' => $user_key . '/' . $hash,
			'expire' => '2681500', // 1 mois
			'path'   => '/'
			)
		);

		if( $data == null)
		{
			if( $this->db->insert( $this->table ) )
			{
				return true;
			}
		}
		// L'utilisateur a déjà une entrée, mise à jour de cette entrée dans user_auto_login
		else
		{
			if( $this->db->update( $this->table ) )
			{
				return true;
			}
		}
		
		// Echec
		return false;
	}

	/**
	 * Autologin_test : Teste si l'autologin fonctionne
	 * 					Le hash dans la base de données doit correspondre au hash du cookie
	 * 
	 * @param $user_id  ID de l'utilisateur
	 * @param $hash 	Hash à comparer
	 * @return bool 	Autologin accepté ou non
	 *
	 */
	public function Autologin_reset($user_key, $hash)
	{

		$data = $this->db->where( array($this->table . '_user_key' => $user_key) )
						->from( $this->table )
						->get()
						->result_array();

		if($data != null)
		{			
			$data = $data[0];
			if($data[$this->table . '_hash'] == $hash)
			{
				if( $this->Autologin_set($user_key) )
				{
					return true;
				}
			}
		}
		return false;
	}

	/**
	 * Autologin_del : Supprimer une entrée auto_login
	 *
	 * @param $user_id 	ID de l'utilisateur
	 * @return bool 	Résultat de la requête
	 *
	 */
	public function Autologin_del($user_key)
	{		
		return $this->db->where( $this->table . '_user_key', $user_key)
						->delete( $this->table );
	}
	
}
// END User Model Class

/* End of file autologin_model.php */
/* Location: ./application/models/autologin_model.php */