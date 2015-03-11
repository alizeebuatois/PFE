<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @author		Alizée Buatois
 */

// ------------------------------------------------------------------------------------------------

class Pdf extends CI_Controller {


function Age($date_naissance)
{

$birthdate = new DateTime($date_naissance);
$age = $birthdate->diff(new DateTime())->format('%y');

		if ($age > 1)
			$age = $age . ' ans';
		else 
			$age = $age . ' an';
	return $age;

}


	public function __construct()
	{
		parent::__construct();

		// Chargement des modèles
		$this->load->model('customer_model');
		$this->load->model('dparameters_model');
		$this->load->model('treatment_model');
		$this->load->model('doctor_model');
		$this->load->model('user_model');

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

		// Champs relatifs au médecin
		$doctor_key =$this->session->userdata('user_doctor_key');

		$doctor = $this->doctor_model->Doctor_getFromKey($doctor_key);
		$doctor = $doctor[0];

		$user = $this->user_model->User_getFromDefaultCustomerKey($doctor_key);
		$user = $user[0];

	
		$doctor_firstname=$this->doctor_model->Doctor_getFirstName($doctor_key);
		$doctor_lastname=$this->doctor_model->Doctor_getLastName($doctor_key);

		$doctor_fonction=$this->doctor_model->Doctor_getTitle($doctor_key);
		$doctor_adeli=$doctor['doctor_adeli'];
		$doctor_phone_number=$user['user_phone'];
		$doctor_fax=$doctor['doctor_fax'];
		$doctor_email=$user['user_email'];



		// Champs relatifs au patient
		$customer_key = $this->input->post('customer');
		$customer = $this->customer_model->Customer_getFromKey($customer_key);
		$customer = $customer[0];
		$customer_firstname = $customer['customer_firstname'];
		$customer_lastname = $customer['customer_lastname'];

		$customer_age = $this->Age($customer['customer_birthdate']);

		$customer_sex = $customer['customer_sex'];
		$customer_weight = $customer['customer_weight'] . ' kg';
		$customer_height = $customer['customer_height'] . ' cms';


		// Champs relatifs aux traitements
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
		include(FCPATH.'PDF/ordonnances/template.html');
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
			include(FCPATH.'PDF/trousses/trousse_'.$trousse.'.html');
			$content = ob_get_clean();
	    	//$content = file_get_contents(FCPATH.'PDF/test2.html');


	        $this->load->library('html2pdf', array('P','A4','fr'));
	        $this->html2pdf->WriteHTML($content);
	        $this->html2pdf->Output('document.pdf');

	}
}
/* End of file pdf.php */
/* Location: ./application/controllers/pdf.php */