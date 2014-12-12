<?php
    if($funP=="order_details"){     
      $i = 1;  
      foreach ($this->process->get_order_details($varP) as $row){ 
?>
        <tr>
      	 <td data-field="numb" data-checkbox="true" ><?=$i?></td>
      	 <td data-field="name" data-sortable="true"><?=$row->NAME?></td>
      	 <td data-field="rson"  data-sortable="true"><?=$row->QUANTITY?></td>
      	 <td data-field="onum" data-sortable="true"><?=$row->KITCHEN_NOTE?></td>
      	 <td data-field="strd" data-sortable="true"><?=$row->PRICE?></td>
      	 <td data-field="endd"  data-sortable="true"><?=$row->VOID?></td>
         <td data-field="endd"  data-sortable="true"><?=$row->VOID_REASON?></td>
      	</tr>
<?php 
        $i++; 
      } 
    } elseif ($funP=="update_printer"){
      //echo $varP;
      $parsed = explode(",",$varP);
      //echo "<pre>" . var_dump($parsed) . "</pre>";
      $output = $this->process->update_printer($parsed);
      echo $output;
    } else { 
      echo "no direct access";
    }
?> 