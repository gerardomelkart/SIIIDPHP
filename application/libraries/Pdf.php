<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
// reference the Dompdf namespace
use Dompdf\Dompdf;
require_once APPPATH . 'libraries/dompdf/vendor/autoload.php'; // Carga Dompdf

class Pdf
{
    public function __construct(){
         $this->dompdf = new \Dompdf\Dompdf();
        // include autoloader
        require_once dirname(__FILE__).'/dompdf/autoload.inc.php';
        // instantiate and use the dompdf class
        $pdf = new DOMPDF();
        $CI =& get_instance();
        $CI->dompdf = $pdf;
    }
}
?>