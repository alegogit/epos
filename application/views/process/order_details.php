<?php
  $i = 1;  
  foreach ($order_details as $row){ 
?>
    <tr>
      <td data-field="numb" style="text-align:right"><?=$i?></td>
      <td data-field="name"><?=$row->NAME?></td>
      <td data-field="qty" style="text-align:right"><?=$row->QUANTITY?></td>
      <td data-field="note"><?=($row->KITCHEN_NOTE=="")?"&nbsp;&nbsp;-":$row->KITCHEN_NOTE?></td>
      <td data-field="curr" style="text-align:right"><?=$cur?></td>
      <td data-field="prc" class="cure" style="text-align:right"><?=number_format((float)$row->PRICE, 2, '.', '')?></td>
      <td data-field="void" style="text-align:right"><?=$row->VOID?></td>
      <td data-field="vors"><?=(($row->VOID_REASON=="")||($row->VOID_REASON=="NULL"))?"&nbsp;&nbsp;-":$row->VOID_REASON?></td>
    </tr>
<?php 
    $i++; 
  }
?>        
<div id="cure" data-val="<?=$cur?>"></div>
<script src="<?=base_url()?>assets/js/autoNumeric.js"></script>
<script>
jQuery(function($) {
    var cure = '<?=$cur?>';
    switch(cure) {
      case "RS":                  
        $('.cure').autoNumeric('init', { dGroup: 2 });
        break;
      case "RP":   
        $('.cure').autoNumeric('init', { aSep: '.', dGroup: 3, aDec: ',', aPad: false });
        break;
      default: 
        $('.cure').autoNumeric('init');
        break;
    }     
  });   
</script>