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
		$this->load->model('customer_model');
		$this->load->model('dparameters_model');
		$this->load->model('treatment_model');

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


	public function generateOrdo()

	{
		// Variables php utilisées dans le template
		$telephone_hopital = $this->dparameters_model->Dparameters_getHospitalPhoneNumber();
		$finess_hopital = $this->dparameters_model->Dparameters_getHospitalFiness();
		$telephone_centre = $this->dparameters_model->Dparameters_getCenterPhoneNumber();
		$fax_centre = $this->dparameters_model->Dparameters_getCenterFax();
		$chef_service = $this->dparameters_model->Dparameters_getHeadService();
		$adeli_chef_service = $this->dparameters_model->Dparameters_getAdeliHeadService();
		$medecins = $this->dparameters_model->Dparameters_getDoctors();


		$customer_key = $this->input->post('customer');

		$customer = $this->customer_model->Customer_getFromKey($customer_key);
		$customer = $customer[0];
		$customer_firstname = $customer['customer_firstname'];
		$customer_lastname = $customer['customer_lastname'];
		$customer_age = $customer['customer_age'];
		$customer_sex = $customer['customer_sex'];

		$descriptions = array();
		$titles = array();

		$treatmentIds = $this->input->post('treatmentIds');
		//var_dump($treatmentIds);

				for($i = 0; $i < count($treatmentIds); $i++){

					$description = $this->treatment_model->Treatment_getDescriptionById($treatmentIds[$i]);
					$title = $this->treatment_model->Treatment_getTitleById($treatmentIds[$i]);
					array_push($descriptions, $description);
					array_push($titles, $title);	
				}

		// lit le fichier html pr les ordonnances et interprète le php contenu
		ob_start();
		include(FCPATH.'PDF/treatment/template.html');
		$content = ob_get_clean();
    	//$content = file_get_contents(FCPATH.'PDF/test2.html');


        $this->load->library('html2pdf', array('P','A4','fr'));
        $this->html2pdf->WriteHTML($content);
        $this->html2pdf->Output('document.pdf');
	}

	public function generateFacture()

	{
		
		// Variables php utilisées dans le template
		$telephone_hopital = $this->dparameters_model->Dparameters_getHospitalPhoneNumber();
		$finess_hopital = $this->dparameters_model->Dparameters_getHospitalFiness();
		$telephone_centre = $this->dparameters_model->Dparameters_getCenterPhoneNumber();
		$fax_centre = $this->dparameters_model->Dparameters_getCenterFax();
		$chef_service = $this->dparameters_model->Dparameters_getHeadService();
		$adeli_chef_service = $this->dparameters_model->Dparameters_getAdeliHeadService();
		$medecins = $this->dparameters_model->Dparameters_getDoctors();

		// lit le fichier html pr les ordonnances et interprète le php contenu
		ob_start();
		include(FCPATH.'PDF/factures/template.html');
		$content = ob_get_clean();
    	//$content = file_get_contents(FCPATH.'PDF/test2.html');


        $this->load->library('html2pdf', array('P','A4','fr'));
        $this->html2pdf->WriteHTML($content);
        $this->html2pdf->Output('document.pdf');
	}

	public function generateTrousse()

	{

		// Variables php utilisées dans le template
		$telephone_hopital = $this->dparameters_model->Dparameters_getHospitalPhoneNumber();
		$finess_hopital = $this->dparameters_model->Dparameters_getHospitalFiness();
		$telephone_centre = $this->dparameters_model->Dparameters_getCenterPhoneNumber();
		$fax_centre = $this->dparameters_model->Dparameters_getCenterFax();
		$chef_service = $this->dparameters_model->Dparameters_getHeadService();
		$adeli_chef_service = $this->dparameters_model->Dparameters_getAdeliHeadService();
		$medecins = $this->dparameters_model->Dparameters_getDoctors();

		$trousse = $this->input->post('trousse');

			// lit le fichier html pr les ordonnances et interprète le php contenu
			ob_start();
			include(FCPATH.'PDF/trousse/trousse_'.$trousse.'.html');
			$content = ob_get_clean();
	    	//$content = file_get_contents(FCPATH.'PDF/test2.html');


	        $this->load->library('html2pdf', array('P','A4','fr'));
	        $this->html2pdf->WriteHTML($content);
	        $this->html2pdf->Output('document.pdf');

	}
}
/* End of file pdf.php */
/* Location: ./application/controllers/pdf.php */