<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ( ! function_exists('full_date'))
	{
		function full_date($date, $display_hours = true)
		{	
			// Si la date n'a pas le bon format, on la modifie
			if (preg_match("$\d{2}/\d{2}/\d{4}$", $date))
			{
				$date = str_replace('/', '-', $date);
				$date = reverse_date($date);
			}

			$date = new DateTime($date);

			$jours = array ('0' => 'Dimanche', '1' => 'Lundi', '2' => 'Mardi', '3' => 'Mercredi', 
					'4' => 'Jeudi', '5' => 'Vendredi', '6' => 'Samedi');
			$mois = array ('1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', 
					'5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août', 
					'9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre');

			$jour = $jours[$date->format('w')];			
			$mois = $mois[$date->format('n')];

			if ($display_hours)
				return $jour . ' ' . $date->format('d') . ' ' . $mois . ' ' . 
											$date->format('Y') . ' à ' . $date->format('H:i:s');
			else
				return $jour . ' ' . $date->format('d') . ' ' . $mois . ' ' . $date->format('Y');
		}
	}

	// --------------------------------------------------------------------------------------------

	if ( ! function_exists('display_date'))
	{
		function display_date($date)
		{	
			$date = new DateTime($date);

			$mois = array ('1' => 'Janvier', '2' => 'Février', '3' => 'Mars', '4' => 'Avril', 
					'5' => 'Mai', '6' => 'Juin', '7' => 'Juillet', '8' => 'Août',
					'9' => 'Septembre', '10' => 'Octobre', '11' => 'Novembre', '12' => 'Décembre');

			$mois = $mois[$date->format('n')];

			return $date->format('d') . ' ' . $mois . ' ' . $date->format('Y');
		}
	}

	// --------------------------------------------------------------------------------------------

	if ( ! function_exists('reverse_date'))
	{
		function reverse_date($date)
		{	
			if ($date == '') return '';

			$date = explode('-', $date);
			return $date[2] . '-' . $date[1] . '-' . $date[0];
		}
	}

	// --------------------------------------------------------------------------------------------

	function not_null($var)
	{
		if ($var == '0') return false;
		else return true;
	}

	// --------------------------------------------------------------------------------------------

/* End of file MY_text_helper.php */
/* Location: ./application/helpers/MY_text_helper.php */
?>