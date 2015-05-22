<?php 
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  	class Timemachine { 
    
    	function daterange_thisweek($dateformat="Y-m-d"){ 
        $monday = strtotime('last monday');
        $monday = date('w', $monday)==date('w') ? $monday+7*86400 : $monday;
        $sunday = strtotime(date($dateformat,$monday)." +6 days");
        $this_week_sd = date($dateformat,$monday);
        $this_week_ed = date($dateformat,$sunday);
        $out = $this_week_sd." - ".$this_week_ed;
  			return $out;
    	}
      
    	function daterange_ofweek($defdate,$dateformat="Y-m-d",$startday="sunday",$endday="saturday"){         
        $ts = strtotime($defdate);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last '.$startday, $ts);
        $end = date($dateformat, strtotime('next '.$endday, $start));
        $start = date($dateformat, $start);
        $out = $start." - ".$end;        
  			return $out;
    	}
      
  	}
?>