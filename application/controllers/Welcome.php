<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Welcome extends CI_Controller {
 
  /**
    * Get All Data from this method.
    *
    * @return Response
   */

  function __construct()
  {
    parent::__construct();
    //cargar modelo indicado
  
    $this->load->library('pdf');
    require_once APPPATH . 'libraries/dompdf/vendor/autoload.php'; // Carga Dompdf
    $this->load->library('libraries/dompdf/pdf.php');


  }


  

   public function index()
   {

    

     $this->load->view('viewAcuseEnvioPDF');


     $this->pdf = new \Dompdf\Dompdf();
      
      $nomArch = 'NomArchPorDefinir';
      $html = $this->output->get_output();
        // Load pdf library
        $this->load->library('pdf');
        // Load HTML content
        $this->pdf->loadHtml($html);
        // (Optional) Setup the paper size and orientation
        $this->pdf->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $this->pdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->pdf->stream($nomArch, array("Attachment"=>0));

    
   }
 
  
 
}