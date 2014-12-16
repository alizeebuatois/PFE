<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if ( ! function_exists('generate_login'))
	{
		function generate_login($firstname, $lastname, $birthdate)
		{	
			$firstname = convert_accented_characters($firstname);
			$lastname = convert_accented_characters($lastname);

			$login = substr($firstname, 0, 3);	
			$login .= substr($lastname, 0, 3);

			$birthdate = explode('-', $birthdate);
			$login .= $birthdate[2] . $birthdate[1];

			/*$login = strtr($login,'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ',
								  'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');*/

			$login = strtolower($login);

			//$login = convert_accented_characters($login);


			// Chargement du modθle ΄user΄
			$CI =& get_instance();
			$CI->load->model('user_model');

			$i = 1;
			$retlogin = $login;
			while ($CI->user_model->User_get(array('user_login' => $retlogin)) != null)
			{
				$retlogin = $login . $i;
				$i++;
        	}

        	return $retlogin;
		}
	}

	// --------------------------------------------------------------------------------------------

	if ( ! function_exists('generate_doctor_login'))
	{
		function generate_doctor_login($firstname, $lastname)
		{	
			$login = mb_substr($firstname, 0, 1, 'utf-8');	
			$login .= mb_substr($lastname, 0, 10, 'utf-8');

			$login = strtr($login,'ΰαβγδηθικλμνξορςστυφωϊϋόύÿΐΑΒΓΔΗΘΙΚΛΜΝΞΟΡÒΣΤΥΦΩΪΫάέ',
								  'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY');

			$login = strtolower($login);

			// Chargement du modθle ΄user΄
			$CI =& get_instance();
			$CI->load->model('user_model');

			$i = 1;
			$retlogin = $login;
			while ($CI->user_model->User_get(array('user_login' => $retlogin)) != null)
			{
				$retlogin = $login . $i;
				$i++;
        	}

        	return $retlogin;
		}
	}

	// --------------------------------------------------------------------------------------------

/* End of file MY_string_helper.php */
/* Location: ./application/helpers/MY_string_helper.php */
?>