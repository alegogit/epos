<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  	class Currency { 
    	function format($num,$cur){ 
			if(mb_strtolower($cur) == mb_strtolower("RP")){
				$out = number_format($num, 0, '', '.');
			} elseif (mb_strtolower($cur) == mb_strtolower("€")){
				$out = number_format($num, 2, ',', '.');
			} else {
				$out = number_format($num, 2, '.', ',');
			}
			return $out;
    	}
		
    	function decimal($num,$cur){ 
			if(mb_strtolower($cur) == mb_strtolower("RP")){
				$out = number_format($num, 0, '', '');
			} else {
				$out = number_format($num, 2, '.', '');
			}
			return $out;
    	}
		
    	function jsformat($cur){ 
  			if(mb_strtolower($cur) == mb_strtolower("RP")){
  				$out = "currencyFormat(value)";
  			} else if(mb_strtolower($cur) == mb_strtolower("RS")){
  				$out = "currencyFormatRS(value)";
  			} else {
  				$out = "numberWithCommas(value)";
  			}
			return $out;
    	}
  	}
?>