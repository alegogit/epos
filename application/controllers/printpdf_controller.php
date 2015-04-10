<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Printpdf_controller extends CI_Controller
{
  function __construct(){
    parent::__construct();  
      
  }
    
  public function index(){ 
		$this->load->view('extracts/pdfgenerator');
  }
  
  public function tojpg(){
    echo "eek";
    $p = "D:\\artileri\\phantomjs\\bin\\phantomjs.exe"." ";
    $r = "D:\\artileri\\phantomjs\\bin\\rasterize.js"." ";
    $u = "http://localhost/epos/reports/salesview"." ";
    $o = "D:\\xampp\\htdocs\\epos\\assets\\img\\testsls1.jpg"." ";
    $c = "'1042px*595px'"; //landscape
    /*     
    $c = "'842px*595px'"; //potrait
    $c = "'595px*595px'"; //inv 
    */
    $c2 = "'A4'";
    $commando = $p.$r.$u.$o.$c;
    $getout = exec($commando,$out,$err);
    var_dump($out);	 
  }
  
  public function view(){ 
		$this->load->view('extracts/pdfbridge');  
  }
  
  public function topdf0(){ 
    $p = "D:\\artileri\\phantomjs\\bin\\phantomjs.exe"." ";
    $r = "D:\\artileri\\phantomjs\\bin\\rasterize.js"." ";
    $u2 = "http://localhost/epos/printpdf/view"." ";
    $o2 = "D:\\xampp\\htdocs\\epos\\assets\\img\\testsls1.pdf"." ";
    $c = "'1042px*595px'"; //landscape
    /*     
    $c = "'842px*595px'"; //potrait
    $c = "'595px*595px'"; //inv 
    */
    $c2 = "'A4'";
    $commando2 = $p.$r.$u2.$o2.$c;
    $getout2 = exec($commando2,$out2,$err2);
    var_dump($out2);	 
  }
  
  public function topdf(){ 
    $p = "D:\\artileri\\phantomjs\\bin\\phantomjs.exe"." ";
    $r = "D:\\artileri\\phantomjs\\bin\\html2pdf.js"." ";
    $u2 = "http://localhost/epos/reports/salesview"." ";
    $o2 = "D:\\xampp\\htdocs\\epos\\assets\\img\\testsls2.pdf"." ";
    $commando2 = $p.$r.$u2.$o2;
    $getout2 = exec($commando2,$out2,$err2);
    var_dump($out2);	 
  }
  
}
