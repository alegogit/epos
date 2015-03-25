<?php 
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  require_once APPPATH."/third_party/mpdf60/mpdf.php"; 
  class Topdf extends Mpdf { 
    public function __construct() { 
        parent::__construct(); 
    } 
  }
?>