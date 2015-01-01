<?php
  $i = 1;  
  foreach ($order_details as $row){ 
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
?> 