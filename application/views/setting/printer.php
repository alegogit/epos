<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/restaurant">Restaurant</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menu">Menu</a>                             
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menuinventory">Menu - Inventory</a>        
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/tableorder">Table Order</a>        
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/users">Users</a>               
      <a role="button" class="btn btn-primary" href="<?=base_url()?>setting/printer">Printer</a>       
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/devices">Devices</a>      
    </div>                    
                                                                          
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('setting/printer',$attributes)
      ?>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <select id = "myRestaurant" name="rest_id" title="Restaurant Name" class="form-control" style="display:inline">
              <option value = "0">Select Restaurant</option>
              <?php foreach($restaurants as $row){ ?>
              <option value = "<?=$row->REST_ID?>" <?= ($row->REST_ID==$rest_id)?'selected':''?> ><?=$row->NAME?></option>
              <?php } ?>
            </select>   
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <input type="submit" class="btn btn-success" style="display:inline" value="Filter" name="filter">
          </div>
        </div>
      <?=form_close()?>     
    </div>              
                                                    
    <hr style="margin-bottom:10px" />
                                             
    <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">
            <b>Printer Setting</b>  
          </div>
					<div class="panel-body">                   
			      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
              <span class="glyphicon glyphicon-plus"></span> Add New Printer  
            </button>             
            <button type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span> Delete Selected Printer  
            </button>        
            <button type="button" class="btn btn-warning subch" style="display:none">
              <span class="glyphicon glyphicon-edit"></span> Submit Changes  
            </button>   
            <div style="margin-bottom:15px"></div> 
					  <div class="table-responsive">     
						  <table id="setting" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Printer Name</th>
						        <th>MAC Address</th>
						        <th>Connectivity</th>
						        <th>IP Address</th>
						        <th>Port</th>
						        <th>Created By</th>
						        <th>Created Date</th>
						        <th>Updated By</th>
						        <th>Updated Date</th>
						    </tr>
						    </thead>
						    <tbody>                    
						    <?php $i = 0;  foreach ($printer_conf as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->NAME?>">
                  <td>
                    <input type="checkbox" class="case" tabindex="-1">
                  </td>
                  <td style="">
                    <a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
                  </td>
                  <td style="">
                    <a id="PRINTER_MAC_ADDRESS-<?=$row->ID?>" data-inputclass="mac" data-type="text" class="edit" tabindex="0"><?=$row->PRINTER_MAC_ADDRESS?></a>   
                  </td>
                  <td style="">  
                    <a id="PRINTER_CONNECTION-<?=$row->ID?>" class="edit" tabindex="0"><?=$this->printer->get_connectivity($row->PRINTER_CONNECTION)->VALUE?></a>
                    <select id="conn<?=$row->ID?>" name="conn_code" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($connectivity as $rowc){ ?>
                      <option value = "<?=$rowc->CODE?>" <?= ($rowc->CODE==$row->PRINTER_CONNECTION)?'selected':''?> ><?=$rowc->VALUE?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td style="">
                    <a id="PRINTER_IP_ADDRESS-<?=$row->ID?>" data-inputclass="ipv4" data-type="text" class="edit" tabindex="0"><?=$row->PRINTER_IP_ADDRESS?></a>   
                  </td>
                  <td style="">       
                    <a id="PRINTER_PORT-<?=$row->ID?>" data-inputclass="mw90" class="edit" tabindex="0"><?=$row->PRINTER_PORT?></a> 
                  </td>
                  <td style=""><span id="crby<?=$row->ID?>"><?=$this->printer->get_username($row->CREATED_BY)->NAME?></span></td>
                  <td style=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
                  <td style=""><span id="upby<?=$row->ID?>"><?=$this->printer->get_username($row->LAST_UPDATED_BY)->NAME?></span></td>
                  <td style=""><span id="updt<?=$row->ID?>"><?=$row->LAST_UPDATED_DATE?></span></td>
                </tr>
                <?php $i++; } ?>
						    </tbody>
						  </table>
						</div>
					</div> 
				</div>
			</div>
		</div><!--/.row-->
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Printer</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newprinter', 'role' => 'form');
        echo form_open('setting/printer',$attributes)
      ?>
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="printer_name"></label>
          <div class="input-group">       
            <div class="input-group-addon"><span class="fa fa-print"></span></div>
            <input type="text" class="form-control" id="printer_name" placeholder="Printer Name" name="printer_name" required>
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px">   
          <label for="MAC_address"></label>
          <div class="input-group">    
            <div class="input-group-addon"><span class="fa fa-gear"></span></div>
            <input type="text" class="form-control mac" id="MAC_address" placeholder="MAC Address" name="MAC_address" required>
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px">
          <label for="conn_code">Connectivity</label><br /> 
          <div class="input-group">        
            <div class="input-group-addon"><span class="fa fa-wifi"></span></div>
            <select id="conn_code" name="conn_code" class="form-control" required>
            <?php foreach($connectivity as $rowc){ ?>
              <option value="<?=$rowc->CODE?>"><?=$rowc->VALUE?></option>
            <?php } ?>
            </select>
          </div>
        </div><br />   
        <div class="form-group" style="margin-bottom:10px">   
          <label for="IP_address"></label>
          <div class="input-group">    
            <div class="input-group-addon"><span class="fa fa-wifi"></span></div>
            <input type="text" class="form-control ipv4" id="IP_address" placeholder="IP Address" name="IP_address" required>
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="Port"></label>  
          <div class="input-group">         
            <div class="input-group-addon"><span class="fa fa-wifi"></span></div>
            <input type="text" class="form-control" id="Port" placeholder="Port" name="Port" required>
          </div>
        </div><br />    
        <div class="form-group" style="margin-bottom:10px">       
          <label for="rest_id">Restaurant</label><br /> 
          <div class="input-group"> 
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <select id="rest_id" name="rest_id" class="form-control" disabled>
            <?php foreach($restaurants as $rows){ ?>
              <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$rest_id)?'selected':''?> ><?=$rows->NAME?></option>
            <?php } ?>
            </select>
          </div>
        </div><br />   
        <div class="form-group text-right" style="margin-bottom:10px">
          <div class="input-group">       
            <button type="submit" class="btn btn-success">Submit</button>&nbsp;
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div><br /> 
        <?=form_close()?>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<div id="baseurl" data-url="<?=base_url()?>"></div>

<?php  
	//editable script
	$i = 0;
	$edit_script = "<script>"; 
	$edit_script .= "$(document).ready(function(){";
	$edit_script .= "  $.fn.editable.defaults.mode = 'inline';";
	$edit_script .= "  $.fn.editable.defaults.showbuttons = false;";
  	$edit_script .= "  var updateurl = '".base_url()."process/printer?p=update';";
	foreach ($printer_conf as $row){
		$edit_script .= "  $('#NAME-".$row->ID."').editable({
								url: updateurl,
		                        pk: ".$row->ID.", 
		                        validate: function(v) {
		                          if (!v) return 'don\'t leave it blank!';  
                              if (!isLimited(v,1,100)) return 'please fill in up to 100 chars!';
		                        },
		                        success: function(result){  
		                          var data = result.split(',');
		                          $('#upby".$row->ID."').html(data[0]);
		                          $('#updt".$row->ID."').html(data[1]); 
		                      } 
		                    });
                        $('#NAME-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
  		$edit_script .= "   $('#PRINTER_MAC_ADDRESS-".$row->ID."').on('shown', function(e, editable) { 
                        		$('.mac').inputmask({ 'mask': '**:**:**:**:**:**' });
                      		});";
  		$edit_script .= "  $('#PRINTER_MAC_ADDRESS-".$row->ID."').editable({
		                        url: updateurl,
		                        pk: ".$row->ID.", 
		                        validate: function(v) {
		                          if (!v) return 'don\'t leave it blank!';
		                          if (isValidMacAddress(v)==false) return 'please fill in a correct MAC Address format!';
		                        },
		                        success: function(result){  
		                          var data = result.split(',');
		                          $('#upby".$row->ID."').html(data[0]);
		                          $('#updt".$row->ID."').html(data[1]); 
		                      } 
		                    });
                        $('#PRINTER_MAC_ADDRESS-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
	  	$edit_script .= "  $('#REST_ID-".$row->ID."').editable({
		                        type: 'select',  
		                        value: ".$row->REST_ID.", 
		                        source: [ ";
	    $j = 1;
	    $n = count($restaurants);
	    foreach($restaurants as $rows){
	      	$edit_script .= "  {value: ".$rows->REST_ID.", text: '".$rows->NAME."'}";
	      	$edit_script .= ($j<$n)?", ":"";
	      	$j++;
	    	}
	  	$edit_script .= "    ],
		                        url: updateurl,
		                        pk: ".$row->ID.",
		                        success: function(result){  
		                          	var data = result.split(',');
		                          	$('#upby".$row->ID."').html(data[0]);
		                          	$('#updt".$row->ID."').html(data[1]); 
		                        }  
						          });
                        $('#REST_ID-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
	  	$edit_script .= "  $('#PRINTER_CONNECTION-".$row->ID."').editable({
		                        type: 'select',  
		                        value: '".addslashes($row->PRINTER_CONNECTION)."', 
		                        source: [ ";
	    $k = 1;
	    $q = count($connectivity);
	    foreach($connectivity as $rowc){
	      	$edit_script .= "  {value: '".addslashes($rowc->CODE)."', text: '".addslashes($rowc->VALUE)."'}";
	      	$edit_script .= ($k<$q)?", ":"";
	      	$k++;
	    }
	  	$edit_script .= "    ],
		                        url: updateurl,
		                        pk: ".$row->ID.",
		                        success: function(result){  
		                        	var data = result.split(',');
		                          	$('#upby".$row->ID."').html(data[0]);
		                          	$('#updt".$row->ID."').html(data[1]); 
		                        }  
							         });
                        $('#PRINTER_CONNECTION-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
	  $edit_script .= "   $('#PRINTER_IP_ADDRESS-".$row->ID."').on('shown', function(e, editable) { 
	                        	$('.ipv4').inputmask({
									mask: 'i[i[i]].i[i[i]].i[i[i]].i[i[i]]',
									definitions: {
										i: {
											validator: function(chrs, maskset, pos) {
											return pos - 1 > -1 && '.' != maskset.buffer[pos - 1] ? (chrs = maskset.buffer[pos - 1] + chrs,
											chrs = pos - 2 > -1 && '.' != maskset.buffer[pos - 2] ? maskset.buffer[pos - 2] + chrs : '0' + chrs) : chrs = '00' + chrs,
											new RegExp('25[0-5]|2[0-4][0-9]|[01][0-9][0-9]').test(chrs);
										},
											cardinality: 1
										}
									}
								});
	                      	});";
	  $edit_script .= "  $('#PRINTER_IP_ADDRESS-".$row->ID."').editable({
		                        url: updateurl,
		                        pk: ".$row->ID.",    
		                        validate: function(v) { 
		                          	if (!v) return 'don\'t leave it blank!';
                                if (!isLimited(v,7,15)) return 'please fill in 7-15 chars!';
		                        },
		                        success: function(result){  
		                          	var data = result.split(',');
		                          	$('#upby".$row->ID."').html(data[0]);
		                          	$('#updt".$row->ID."').html(data[1]); 
		                        }  
		                    });";
	  $edit_script .= "  $('#PRINTER_PORT-".$row->ID."').editable({
		                        url: updateurl,
		                        pk: ".$row->ID.",       
		                        validate: function(v) {  
		                          	if (!v) return 'don\'t leave it blank!';
                          			if (isNaN(v)) return 'please fill in a number format!';
		                        },
		                        success: function(result){  
		                          	var data = result.split(',');
		                          	$('#upby".$row->ID."').html(data[0]);
		                          	$('#updt".$row->ID."').html(data[1]); 
		                        } 
	                      });
                        $('#PRINTER_PORT-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
	}
	$edit_script .= "}); ";
	$edit_script .= '</script>';
	echo $edit_script;
?>

<script>     
$(document).ready(function(){
	var baseurl = $("#baseurl").data('url');
  
  	//make editable on focus  
  	$('.edit').focus(function(e) {
    	e.stopPropagation();
    	$(this).editable('toggle');
  	});
  
  	//inititate datatable
  	var table = $('#setting').DataTable({
    	columnDefs: [
      		{ targets: 'no-sort', orderable: false }
    	],
    	"order": [[ 1, "asc" ]],
      "dom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',
      pageLength: 25,
      "aLengthMenu": [[10, 25, 100, -1], [10, 25, 100, "All"]],
      "bAutoWidth": false
  	});
  
  	//check all
  	$("#checkall").click(function(){
    	$('.case').prop('checked',this.checked);
  	});
  	$(".case").click(function(){
    	if($(".case").length==$(".case:checked").length){
      		$("#selectall").prop("checked","checked");
    	}else{
      		$("#selectall").removeAttr("checked");
    	}
  	});
   
  	//function to delete selected row
  	$('.btn-danger').on("click", function(event){
  		var sel = false;	
  		var ch = $('#setting').find('tbody input[type=checkbox]');
    	var dt = '';	
  		ch.each(function(){  
      		if($(this).is(':checked')) { 
        		var idf = $(this).parents('tr').attr('id');
        		var idm = idf.substring(idf.indexOf('_')+1,idf.length);
  		  		dt = dt+' '+idm+',';
      		}    
    	}); 
    	if(dt==''){
      		var c = false;
    	} else {  	
  	  		var c = confirm('Continue delete \n'+dt.substring(1,dt.length-1)+'?');
    	}
  		if(c) {
  	  		ch.each(function(){
  		 		var $this = $(this);
  				if($this.is(':checked')) {
  					sel = true;	//set to true if there is/are selected row
          			var idf = $(this).parents('tr').attr('id');
          			var dataP = "idf="+idf;
  					$.ajax({
			            type: "POST",
			            url: baseurl+"process/printer?p=delete",
			            data: dataP,
			            cache: false,
			            success: function(result){ 
              				if(result.trim()!='OK'){    
                				alert(result); 
              				} else {    
        						    $this.parents('tr').fadeOut(function(){
                          $this.remove(); //remove row when animation is finished
        						    });
                        var page = window.location.href;
                        window.location.assign(page);          
              				}    
			            }
			        });   
  				}
  	  		});
  		  	if(!sel) alert('No data selected');	
  		}
  		return false;
  	}); 
  
  	//masking
 	$("#MAC_address").inputmask({ "mask": "**:**:**:**:**:**" });
 	$(".ipv4").inputmask({
		mask: "i[i[i]].i[i[i]].i[i[i]].i[i[i]]",
		definitions: {
			i: {
				validator: function(chrs, maskset, pos) {
				return pos - 1 > -1 && "." != maskset.buffer[pos - 1] ? (chrs = maskset.buffer[pos - 1] + chrs,
				chrs = pos - 2 > -1 && "." != maskset.buffer[pos - 2] ? maskset.buffer[pos - 2] + chrs : "0" + chrs) : chrs = "00" + chrs,
				new RegExp("25[0-5]|2[0-4][0-9]|[01][0-9][0-9]").test(chrs);
			},
				cardinality: 1
			}
		}
	});
  
});
  
$(function(){
  	$("#newprinter").validate({ 
    	rules: {
      		Port: { 
        		number: true 
      		},
      		MAC_address: { 
        		macadd: true 
      		}
		}
  	});
});         

$.validator.setDefaults({
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});

jQuery.validator.addMethod("macadd", function(value, element) {
  return this.optional(element) || /^([0-9a-fA-F]{2}[:]){5}([0-9a-fA-F]{2})$/.test(value);
}, "Please fill in a Mac Address format");

function isValidMacAddress(macAdd){
  //var RegExPattern = /^([0-9a-fA-F]{2}[:-]){5}([0-9a-fA-F]{2})$/;
  var RegExPattern = /^([0-9a-fA-F]{2}[:]){5}([0-9a-fA-F]{2})$/;
  if (!(macAdd.match(RegExPattern)) || macAdd.length != 17){
   return false;
  } else {
   return true;
  }
}                 
                     
function isLimited(input,init,limit) {
  var regex = new RegExp("^.{" + init + "," + limit + "}$");
  return regex.test(input);
} 
</script>
