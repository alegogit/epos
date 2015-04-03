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
      
      function my_number_format($amount, $precision = 2,  $comma = '.', $limiter = ''){ 
        $amount = (float) $amount;
        $zero = round(0, $precision);
        if (round($amount, $precision) == $zero) {
            $amount = $zero;
        }
        if ($amount < 0) {
          //$amount = '('.number_format(abs($amount), $precision, $comma, $limiter).')';
          $amount = number_format(abs($amount), $precision, $comma, $limiter);
          $amount = (float)$amount * -1;
        } else {
          $amount = number_format($amount, $precision, $comma, $limiter);
        }
        return $amount;
      }
      
      function my_number_format0($amount, $precision = 2, $use_commas = true, $show_currency_symbol = false, $parentheses_for_negative_amounts = false){
        /*
        **    An improvement to number_format.  Mainly to get rid of the annoying behaviour of negative zero amounts.   
        */
        $amount = (float) $amount;
        // Get rid of negative zero
        $zero = round(0, $precision);
        if (round($amount, $precision) == $zero) {
            $amount = $zero;
        }
       
        if ($use_commas) {
            if ($parentheses_for_negative_amounts && ($amount < 0)) {
                $amount = '('.number_format(abs($amount), $precision).')';
            }
            else {
                $amount = number_format($amount, $precision);
            }
        }
        else {
            if ($parentheses_for_negative_amounts && ($amount < 0)) {
                $amount = '('.round(abs($amount), $precision).')';
            }
            else {
                $amount = round($amount, $precision);
            }
        }
       
        if ($show_currency_symbol) {
            $amount = '$'.$amount;  // Change this to use the organization's country's symbol in the future
        }
        return $amount;
      } 

  	}
?>