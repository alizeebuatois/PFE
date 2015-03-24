<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Treatment Model Class
 *
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Treatment_Model extends CI_Model {

	protected $table = 'treatment';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Récupère la totalité des traitements du CVI
	 *
	 * @return Tableau des éléments de la table `treatment`
	 *
	 */
	public function Treatment_getAll($order='treatment_id',$where = array())
	{
		return $this->db->select('*')
						->where( $where )
						->from( $this->table )
						->order_by($order)
						->get()
						->result_array();		
	}

	/**
	 * Ajoute un traitement en base de données
	 *
	 * @param 
	 *
	 */
	public function Treatment_add($treatment_name, $treatment_title, $treatment_description)
	{

				//echo 'description = '.$treatment_description;
		$this->db->set( $this->table . '_name', $treatment_name );
		$this->db->set( $this->table . '_title', $treatment_title );
		$this->db->set( $this->table . '_description', $treatment_description );
		return $this->db->insert($this->table);
	}

	/**
	 * Supprime un traitement en base de données
	 *
	 * @param $id identifiant du traitement à supprimer
	 *
	 */
	public function Treatment_delete($id)
	{

	return $this->db->where( $this->table . '_id', $id)
					->delete( $this->table );
	}

	public function checkIdIfExist($id)
	{

	$treatment = $this->db->select($this->table . '_id')
						->where($this->table . '_id', $id)
						->from($this->table)
						->get()
						->result_array();

	return (count($treatment) > 0);
	}

	/**
	 * Modifie/Met à jour un traitement en base de données
	 *
	 * @param $id identifiant du traitement à modifier
	 *
	 */
	public function Treatment_updateAll($json)
	{
		$donnees = json_decode($json);
		$return = null;

		for($i=0 ; $i<count($donnees) ; $i++)
		{

			$treatment_name = $donnees[$i]->name;
			$treatment_title = $donnees[$i]->title;
			$treatment_description = $donnees[$i]->description;

				//echo 'description = '.$treatment_description;

			// si ce traitement existait déjà
			if ($this->checkIdIfExist($donnees[$i]->treatment_id)){

				$treatment_id = $donnees[$i]->treatment_id;

				// on met à jour le traitement en question dans la table
				$this->db->set( $this->table . '_name', $treatment_name );
				$this->db->set( $this->table . '_title', $treatment_title );
				$this->db->set( $this->table . '_description', $treatment_description );
				$this->db->where($this->table . '_id', $treatment_id);

				$return = $this->db->update($this->table);
			}

			// si on vient seulement de le créer
			else{
				$return = $this->Treatment_add($treatment_name, $treatment_title, $treatment_description);

			}	
		}

		return $return;

	}

	public function Treatment_getTitle($name)
	{
		$title = $this->db->select($this->table . '_title')
						->where($this->table . '_name', $name)
						->from($this->table)
						->get()
						->result_array();
		return $title[0][$this->table . '_title'];

	}

		public function Treatment_getTitleById($id)
	{
		$title = $this->db->select($this->table . '_title')
						->where($this->table . '_id', $id)
						->from($this->table)
						->get()
						->result_array();
		return $title[0][$this->table . '_title'];

	}

		public function Treatment_getDescription($name)
	{
		$title = $this->db->select($this->table . '_description')
						->where($this->table . '_name', $name)
						->from($this->table)
						->get()
						->result_array();
		return $title[0][$this->table . '_description'];

	}

		public function Treatment_getDescriptionById($id)
	{
		$title = $this->db->select($this->table . '_description')
						->where($this->table . '_id', $id)
						->from($this->table)
						->get()
						->result_array();
		return $title[0][$this->table . '_description'];

	}

		public function Treatment_getNameById($id)
	{
		$title = $this->db->select($this->table . '_name')
						->where($this->table . '_id', $id)
						->from($this->table)
						->get()
						->result_array();
		return $title[0][$this->table . '_name'];

	}

}

	
// END Treatment Model Class

/* End of file treatment_model.php */
/* Location: ./application/models/treatment_model.php */