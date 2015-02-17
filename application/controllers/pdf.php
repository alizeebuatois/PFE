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

		//$description = $this->instruction_model->Instruction_getFromKey($id);

		$description = "<div style=\"width:100%;\" align=\"center\">
            <table id='titretraitement' align=\"center\">
                <tr>
                    <td style=\"width: 100%; text-align: center;\">TRAITEMENT en cas de DIARRHÉE de l'ADULTE</td>

                </tr>
            </table>
        </div> 

        <div id=\"traitement\">
            <p>
                <ol >
                    <li>Réhydratation orale et régime anti-diarrhéique adapté (riz, bananes…)<br/>  <span> </span>
                        <ol style='list-style-image: url(./PDF/fleche.jpg);'><br/>    
                            <li>TIORFANOR &reg;<br/>1 comprimé  à la 1ère diarrhée, puis 1 comprimé matin et soir  si la diarrhée persiste. 
                            </li><br/>

                        </ol><br/>
                    </li>
                    <li><b>Si la diarrhée est grave</b> : d'emblée sévère (fièvre, sang ou glaire dans les selles, très liquide…) ou persistante au-delà de 24 heures avec plus de 4 selles par jour : <b>Consultation médicale sur place</b>
                    </li>
                </ol>
            </p>
        </div>";

		if ($customer_key == null){
			$customer_firstname = "test";
		}


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