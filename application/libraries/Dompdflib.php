<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once("/dompdf-0.6.1/dompdf_config.inc.php");
 
class Dompdflib extends Dompdf{     
    public function __construct() { 
        parent::__construct(); 
    } 
    
    public function eek(){
      return "eek";
    }
    
    function createpdf($html, $filename='', $stream=TRUE){  
      $this->load_html($html);
      $this->render();
      if ($stream) {
        $this->stream($filename.".pdf");
      } else {
        return $this->output();
      }
    }
 
}  
/* End of file Dompdf.php */
/* Location: ./application/libraries/Dompdf.php */