<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Pdf extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		//$this->load->model('');

		// 
		// Il est dans tous les cas nécessaire d'être connecté et d'avoir les accès pour accéder à cette classe
		if (!$this->session->userdata('connected') || $this->session->userdata('user_right') < 3)
		{
			show_404();
		}		
	}

	/**
	 * Index
	 */
	public function index()
	{
		$this->config->set_item('user-nav-selected-menu', 1); // on highlight le premier element du menu
		
		// Affichage de la vue
		$this->layout->show('backend/pdf');
	}


	public function generate()

	{
		// Variables php utilisées dans le template
		$telephone_hopital = "02 47 47 47 47";
		$finess_hopital = "37 0 000 481";
		$telephone_centre = "02.47.47.38.49";
		$fax_centre = "02.47.47.97.10";
		$chef_service = "Professeur Louis BERNARD";
		$adeli_chef_service = "371055591";
		$medecins = "Pr J. CHANDENIER, Dr G. GRAS,  Dr L. GUILLON , Dr A. HAMED , Dr Z. MAAKAROUN-VERMESSE,  Dr A. POULIQUEN,";


		// lit le fichier html pr les ordonnances et interprète le php contenu
		ob_start();
		include(FCPATH.'PDF/diarrhee_adulte.html');
		$content = ob_get_clean();
    	//$content = file_get_contents(FCPATH.'PDF/test2.html');


        $this->load->library('html2pdf', array('P','A4','fr'));
        $this->html2pdf->WriteHTML($content);
        $this->html2pdf->Output('ordonnance.pdf');

	}

}
/* End of file pdf.php */
/* Location: ./application/controllers/pdf.php */