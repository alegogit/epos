<?php
  $i = 1;  
  foreach ($order_details as $row){ 
?>
    <tr>
      <td style="text-align:right"><?=$i?></td>
      <td><?=$row->MENU_NAME?></td>
      <td><?=$row->CATEGORY_NAME?></td>   
      <td><?=($row->KITCHEN_NOTE=="")?"&nbsp;&nbsp;-":$row->KITCHEN_NOTE?></td>
      <td style="text-align:right"><?=$row->QUANTITY?></td>
      <td style="text-align:right"><?=$cur?></td>
      <td class="cure" style="text-align:right"><?=number_format((float)$row->PRICE, 2, '.', '')?></td>
      <td style="text-align:right"><?=$cur?></td>
      <td class="cure" style="text-align:right"><?=number_format((float)$row->TOTAL, 2, '.', '')?></td> 
      <td class="cure" style="text-align:right"><?=(($row->VOID==0)||($row->VOID=="NULL"))?"No":"Yes"?></td>
      <td ><?=(($row->VOID_REASON=="")||($row->VOID_REASON=="NULL"))?"&nbsp;&nbsp;-":$row->VOID_REASON?></td>
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
    //var cure = $("#cure").data("val");
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