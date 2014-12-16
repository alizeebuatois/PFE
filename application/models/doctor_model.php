<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * Doctor Model Class
 *
 * @author		Clément Tessier
 */

// ------------------------------------------------------------------------------------------------

class Doctor_Model extends CI_Model {

	protected $table = 'doctor';

	/**
	 * Constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Doctor_get
	 *
	 * @param $where 	Clause WHERE facultative
	 * @param Résultat de la requête
	 *
	 */
	public function Doctor_get($where = array())
	{
		return $this->db->where($where)
						->from($this->table)
						->get()
						->result_array();
	}
	
	/**
	 * Doctor_getLike : Requête avec Like
	 *
	 * @param $field 	Champ
	 * @param $like 	Recherche
	 * @param $pos		Position
	 * @return Résultat de la requête
	 *
	 */
	public function Doctor_getLike($field, $like, $pos = 'both')
	{
		return $this->db->like($this->table . '_' . $field, $like, $pos)
						->from($this->table)
						->get()
						->result_array();
	}

	/**
	 * Doctor_getFromKey
	 *
	 * @param $doctor_key 	Clé du doctor
	 * @return Résultat de la requête
	 *
	 */
	public function Doctor_getFromKey($doctor_key)
	{
		return $this->Doctor_get(array($this->table . '_key' => $doctor_key));
	}

	/**
	 * Doctor_create : Ajoute un doctor à la base de données.
	 *
	 * @param $title 			Civilité
	 * @param $firstname 		Prénom
	 * @param $lastname 		Nom de famille
	 * @param $birthdate 		Date de naissance
	 * @param $birthcity 		Ville de naissance
	 * @param $birth_country_id Pays de naissance
	 * @param $type 			Type (médecin, infirmière, etc.)
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Doctor_create($title, $firstname, $lastname, $birthdate, $birthcity, 
																		  $birth_country_id, $type)
	{
		// Affectation des données aux champs de la table ´user´
		$this->db->set( $this->table . '_title', $title );
		$this->db->set( $this->table . '_firstname', $firstname );
		$this->db->set( $this->table . '_lastname', $lastname );
		if (!empty($birthdate))
			$this->db->set( $this->table . '_birthdate', $birthdate );
		if (!empty($birthcity))
			$this->db->set( $this->table . '_birthcity', $birthcity );
		if ($birth_country_id > 0)
			$this->db->set( $this->table . '_birth_country_id', $birth_country_id );
		$this->db->set( $this->table . '_type', $type );
		$this->db->set( $this->table . '_creation', 'NOW()', false );

		// Génération de la clé aléatoire
		do {
			$doctor_key = 'D' . random_string('alnum', 9);
		} while ($this->Doctor_get(array($this->table . '_key' => $doctor_key)) != null);
		$this->db->set( $this->table . '_key', $doctor_key );

		// Insertion du nouvel utilisateur dans la table ´user´
		if($this->db->insert( $this->table ))
			return $doctor_key;
		else
			return null;
	}

	/**
	 * Doctor_update : Modifie les informations personnelles d'un doctor
	 *
	 * @param $doctor_key 		Clé du doctor à modifier
	 * @param $title 			Civilité
	 * @param $firstname 		Prénom
	 * @param $lastname 		Nom de famille
	 * @param $birthdate 		Date de naissance
	 * @param $birthcity 		Ville de naissance
	 * @param $birth_country_id Pays de naissance
	 * @param $type 			Type (médecin, infirmière, etc.)
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Doctor_update($doctor_key, $title, $firstname, $lastname, $birthdate, $birthcity,
																	$birth_country_id, $type)
	{
		$this->db->set( $this->table . '_title', $title );
		$this->db->set( $this->table . '_firstname', $firstname );
		$this->db->set( $this->table . '_lastname', $lastname );
		if (!empty($birthdate))
			$this->db->set( $this->table . '_birthdate', $birthdate );
		if (!empty($birthcity))
			$this->db->set( $this->table . '_birthcity', $birthcity );
		if ($birth_country_id > 0)
			$this->db->set( $this->table . '_birth_country_id', $birth_country_id );

		$this->db->set( $this->table . '_type', $type );

		return $this->db->where($this->table . '_key', $doctor_key)
						->update($this->table);
	}

	/**
	 * Doctor_updateTimetable : Modifie la timetable d'un doctor
	 *
	 * @param $doctor_key 		Clé du doctor à modifier
	 * @param $timetable 		Timetable (JSON)
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Doctor_updateTimetable($doctor_key, $timetable)
	{
		$this->db->set($this->table . '_timetable', $timetable);

		return $this->db->where($this->table . '_key', $doctor_key)
						->update($this->table);
	}


	/**
	 * Doctor_delete : Supprime un doctor de la base de données
	 *
	 * @param $doctor_key		Clé du doctor à supprimer
	 * @return bool 			Résultat de la requête
	 *
	 */
	public function Doctor_delete($doctor_key)
	{
		return $this->db->where( $this->table . '_key', $doctor_key)
						->delete( $this->table );
	}

	/**
	 * Doctor_getFullName : Renvoi le nom complet
	 *
	 * @param $doctor_key 	Clé
	 * @return Nom complet
	 *
	 */
	public function Doctor_getFullName($doctor_key)
	{
		$doctor = $this->Doctor_get(array($this->table . '_key' => $doctor_key));

		if ($doctor != null)
		{
			return $doctor[0][$this->table . '_title'] . ' ' .
					strtoupper($doctor[0][$this->table . '_lastname']) . ' ' .
					$doctor[0][$this->table . '_firstname'];
		}
		else
		{
			return '<span style="color:red">&times;</span>';
		}
	}

	/**
	 * Doctor_getShortName : Renvoi le nom court
	 *
	 * @param $doctor_key 	Clé
	 * @return Nom court
	 *
	 */
	public function Doctor_getShortName($doctor_key)
	{
		$doctor = $this->Doctor_get(array($this->table . '_key' => $doctor_key));

		if ($doctor != null)
		{
			return substr($doctor[0][$this->table . '_firstname'], 0, 1) . '. ' . 
					$doctor[0][$this->table . '_lastname'];
		}
		else
		{
			return '<span style="color:red">&times;</span>';
		}
	}

	/**
	 * Doctor_getInitials : Renvoi les initiales du doctor
	 *
	 * @param $doctor_key 	Clé
	 * @return initiales
	 *
	 */
	public function Doctor_getInitials($doctor_key)
	{
		$doctor = $this->Doctor_get(array($this->table . '_key' => $doctor_key));

		if ($doctor != null)
		{
			return substr($doctor[0][$this->table . '_firstname'], 0, 1) . '.' . 
					substr($doctor[0][$this->table . '_lastname'], 0, 1) . '.';
		}
		else
		{
			return '<span style="color:red">&times;</span>';
		}
	}

	/**
	 * Doctor_getOpeningHour : renvoi l'heure d'ouverture du centre selon les timetable
	 *
	 * @param $date 	Jour
	 * @param $option 	AM ou PM
	 * @return Heure d'ouverture à la date $date matin ou après-midi
	 *
	 */
	public function Doctor_getOpeningHour($date, $option = 'am')
	{
		$minDateTime = null;
		$day = $date->format('N') - 1; // on récupère le numéro du jour
		$currentTime = clone $date;
		
		$doctors = $this->Doctor_get();
		foreach($doctors as $doctor) // on parcours les présences du personnel de soin
		{
			// Si l'horaire existe, on compare au plus petit déjà trouvé
			$timetable = json_decode($doctor[$this->table . '_timetable'], true);
			if (($time = $timetable[$day][$option][0]) != '')
			{
				$splittedTime = explode(':', $time);
				$currentTime->setTime($splittedTime[0], $splittedTime[1]);

				if ($minDateTime == null)
				{
					$minDateTime = clone $currentTime;
				}
				else if ($currentTime < $minDateTime) // on met à jour si currentTime est plus tôt
				{
					$minDateTime = clone $currentTime;
				}
			}
		}
		return $minDateTime;
	}

	/**
	 * Doctor_getClosingHour : renvoi l'heure de fermeture du centre selon les timetable
	 *
	 * @param $date 	Jour
	 * @param $option 	AM ou PM
	 * @return Heure de fermeture à la date $date matin ou après-midi
	 *
	 */
	public function Doctor_getClosingHour($date, $option = 'am')
	{
		$maxDateTime = null;
		$day = $date->format('N') - 1; // on récupère l'indice du jour
		$currentTime = clone $date;
		
		$doctors = $this->Doctor_get();
		foreach($doctors as $doctor) // on parcours les présences du personnel de soin
		{
			// Si l'horaire existe, on compare au plus petit déjà trouvé
			$timetable = json_decode($doctor[$this->table . '_timetable'], true);
			if (($time = $timetable[$day][$option][1]) != '')
			{
				$splittedTime = explode(':', $time);
				$currentTime->setTime($splittedTime[0], $splittedTime[1]);

				if ($maxDateTime == null)
				{
					$maxDateTime = clone $currentTime;
				}
				else if ($currentTime > $maxDateTime) // on met à jour si currentTime est plus tôt
				{
					$maxDateTime = clone $currentTime;
				}
			}
		}
		return $maxDateTime;
	}

	/**
	 * Doctor_getAvailableDoctors : Renvoi la liste des doctors disponibles à une date donnée
	 *
	 * @param $start 	Date de début du rendez-vous
	 * @param $end 		Date de fin du rendez-vous
	 * @param $doctor_type 	Type de doctor requis
	 * @return array 	Liste des clés des doctors disponibles
	 *
	 */
	public function Doctor_getAvailableDoctors($start, $end, $doctor_type = 1)
	{
		$ret = array();

		// Indice du jour
		$day = $start->format('N') - 1;

		// Doctors candidats
		$doctors = $this->Doctor_get(
			array($this->table . '_type' => $doctor_type)
		);

		// On cherche ceux qui sont disponibles
		foreach($doctors as $doctor)
		{
			$timetable = json_decode($doctor[$this->table . '_timetable'],true);
			if ($timetable != null)
			{
				// On récupère les horaires de présence du doctor
				$requiredDay = $timetable[$day];

				// Recherche pour le matin
				if (($arriving = $requiredDay['am'][0]) != '' && ($leaving = $requiredDay['am'][1]) != '')
				{
					// Création des date d'arrivé et de départ ce jour là
					$arriving = explode(':', $arriving);
					$leaving = explode(':', $leaving);
					$arrivingDate = clone $start;
					$leavingDate = clone $start;
					$arrivingDate->setTime($arriving[0], $arriving[1], 0);
					$leavingDate->setTime($leaving[0], $leaving[1], 0);

					// On compare
					if ($arrivingDate < $start && $leavingDate > $end)
					{
						array_push($ret, $doctor[$this->table . '_key']);
					}
				}

				// Recherche pour l'après-midi
				if (($arriving = $requiredDay['pm'][0]) != '' && ($leaving = $requiredDay['pm'][1]) != '')
				{
					// Création des date d'arrivé et de départ ce jour là
					$arriving = explode(':', $arriving);
					$leaving = explode(':', $leaving);
					$arrivingDate = clone $start;
					$leavingDate = clone $start;
					$arrivingDate->setTime($arriving[0], $arriving[1], 0);
					$leavingDate->setTime($leaving[0], $leaving[1], 0);

					// On compare
					if ($arrivingDate < $start && $leavingDate > $end)
					{
						array_push($ret, $doctor[$this->table . '_key']);
					}
				}

			}
		}

		// On renvoie le tableau des doctor disponible ou nul si aucun
		return ((count($ret) > 0) ? $ret : null);
	}

	/**
	 * getNbOpeningMinutesOfTheDay : Renvoie le nombre de minutes d'ouverture pendant la journée
	 */
	public function Doctor_getNbOpeningMinutesOfTheDay($day)
	{
		$count = 0;

		// Indice du jour
		$i = $day->format('N') - 1;

		// On parcours les doctors
		$doctors = $this->Doctor_get();
		foreach ($doctors as $doctor)
		{
			$prev = $count;
			$timetable = json_decode($doctor[$this->table . '_timetable'], true);
			// matin
			if (!empty($timetable[$i]['am']))
			{
				$start = new DateTime($timetable[$i]['am'][0]);
				$end = new DateTime($timetable[$i]['am'][1]);
				$count += $start->diff($end)->format('%H')*60;
				$count += $start->diff($end)->format('%i');
			}
			// après-midi
			if (!empty($timetable[$i]['pm']))
			{
				$start = new DateTime($timetable[$i]['pm'][0]);
				$end = new DateTime($timetable[$i]['pm'][1]);
				$count += $start->diff($end)->format('%H')*60;
				$count += $start->diff($end)->format('%i');
			}			
		}
		return $count;
	}
	
}
// END Doctor Model Class

/* End of file doctor_model.php */
/* Location: ./application/models/doctor_model.php */