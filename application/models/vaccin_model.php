<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Vaccins Model Class
 *
 * @author		Clément Tessier
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Vaccin_Model extends CI_Model {

	protected $table = 'vaccin';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des vaccins du CVI
	 *
	 * @return Tableau des éléments de la table `vaccin`
	 *
	 */
	public function Vaccin_getAll($where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->get()
						->result_array();
	}


	/**
	 * Récupère la totalité des vaccins du CVI avec en premier champ
	 *
	 * @return Tableau des éléments de la table `vaccin`
	 *
	 */

	public function Vaccin_getAllWithGeneralVaccin()
	{

		 $sql =   'SELECT gv.generalVaccin_id, gv.generalVaccin_label,  v.vaccin_id, v.vaccin_label, v.vaccin_price
		 		   FROM vaccin v JOIN vaccinGeneralVaccin vv ON v.vaccin_id = vv.vaccin_id
						 		 JOIN generalVaccin gv ON vv.generalVaccin_id = gv.generalVaccin_id';

		// generalVaccin_id
		// generalVaccin_label
		// vaccin_id
		// vaccin_label
		// vaccin_price

		 $query = $this->db->query($sql)->result_array();
		 return $query;
	}


	/**
	 * Récupère le label d'un vaccin donné par son ID
	 *
	 * @param $vaccin_id 	ID du vaccin
	 * @return Label du vaccin donné par son ID
	 *
	 */
	public function Vaccin_getLabelById($vaccin_id)
	{
		$vaccin = $this->db->select($this->table . '_label')
							->where($this->table . '_id', $vaccin_id)
							->from($this->table)
							->get()
							->result_array();
		return $vaccin[0][$this->table . '_label'];
	}


	/**
	 * Récupère l'ID d'un vaccin donné par son nom
	 *
	 * @param $vaccin_id 	ID du vaccin
	 * @return ID duu vaccin donné par son label
	 *
	 */
	public function Vaccin_getIdByLabel($vaccin_label)
	{

		$vaccin = $this->db->select($this->table . '_id')
							->where($this->table . '_label', $vaccin_label)
							->from($this->table)
							->get()
							->result_array();

		if(count($vaccin) == 1){
			return $vaccin[0][$this->table . '_id'];
		}
		else{
			return "-1";
		}
	}


	/**
	 * Ajoute un vaccin en base de données
	 *
	 * @param 
	 *
	 */
	public function Vaccin_add($vaccin_label, $vaccin_price, $generalVaccin_id)
	{
		$this->db->set( $this->table . '_label', $vaccin_label );
		$this->db->set( $this->table . '_price', $vaccin_price );
		// On n'ajoute pas $generalVaccin_id car c'est seulement dans la table de jointure

		if ($this->db->insert($this->table))
		{
			$vaccin_id = $this->db->insert_id();  // id du vaccin qui vient d'être ajouté

			// On associe au generalVaccin
			$this->db->set($this->table . '_id', $vaccin_id);
			$this->db->set('generalVaccin_id', $generalVaccin_id);
			$this->db->insert($this->table . 'GeneralVaccin');
			
		}

	return $vaccin_id;

	}

	/**
	 * Ajoute un vaccin en base de données
	 *
	 * @param $id identifiant du vaccin à supprimer
	 *
	 */
	public function Vaccin_delete($id)
	{
		// on supprime aussi dans la table de jointure

		/* DELETE FROM vaccinGeneralVaccin where vaccin_id = $id */
		
		$this->db->where($this->table . '_id', $id)
				 ->delete($this->table . 'GeneralVaccin');

	return $this->db->where( $this->table . '_id', $id)
					->delete( $this->table );
	}

	public function checkIdIfExist($id)
	{

	$vaccin = $this->db->select($this->table . '_id')
						->where($this->table . '_id', $id)
						->from($this->table)
						->get()
						->result_array();

	return (count($vaccin) > 0);
	}

	/**
	 * Modifie/Met à jour un vaccin en base de données
	 *
	 * @param $id identifiant du vaccin à modifier
	 *
	 */
	public function Vaccin_updateAll($json)
	{
		$donnees = json_decode($json);
		//var_dump($donnees);
		$return = null;

		for($i=0 ; $i<count($donnees) ; $i++)
		{

			$generalVaccin_id = $donnees[$i]->id;
			$vaccin_label = $donnees[$i]->nom;
			$vaccin_price = $donnees[$i]->price;

			// si ce vaccin existait déjà
			if ($this->checkIdIfExist($donnees[$i]->vaccin_id)){

				$vaccin_id = $donnees[$i]->vaccin_id;

				// on met à jour aussi dans la table de jointure
				$this->db->set( "general".ucfirst($this->table) . '_id', $generalVaccin_id );
				$this->db->where($this->table . '_id', $vaccin_id);
				$this->db->update($this->table . 'GeneralVaccin');

				// on met à jour le vaccin en question dans la table
				$this->db->set( $this->table . '_label', $vaccin_label );
				$this->db->set( $this->table . '_price', $vaccin_price );
				$this->db->where($this->table . '_id', $vaccin_id);
				$return = $this->db->update($this->table);
			}

			// si on vient seulement de le créer
			else{

				$return = $this->Vaccin_add($vaccin_label, $vaccin_price, $generalVaccin_id);

			}	
		}

		return $return;

		}

	}

	
// END Vaccin Model Class

/* End of file vaccin_model.php */
/* Location: ./application/models/vaccin_model.php */