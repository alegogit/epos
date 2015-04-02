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
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/printer">Printer</a>       
      <a role="button" class="btn btn-primary" href="<?=base_url()?>setting/terminal">Terminal</a>           
    </div>       
                                                                          
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('setting/terminal',$attributes)
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
                                                     
    <hr style="margin-bottom:10px;margin-top:10px" />
    
    <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Add/Edit Table Order</b></div>
				<div class="panel-body">                 					                    
			    	<button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
              			<span class="glyphicon glyphicon-plus"></span> Add New Terminal  
            		</button>             
            		<button type="button" class="btn btn-danger">
              			<span class="glyphicon glyphicon-remove"></span> Delete Selected Terminal(s)
            		</button>        
            	<div style="margin-bottom:15px"></div> 
            	<div class="table-responsive">
					<table id="setting" class="table table-striped dt-right compact">
						<thead>
							<tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Name</th>
						        <th>Type</th>
						        <th>Manufacturer</th>
						        <th>Model</th>
						        <th>MAC Address</th>
						        <th>Host/Client</th>
						        <th>Last Sync</th> 
                  <?php if ($role==1){ ?>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th> 
                  <?php } ?>
						    </tr>
						</thead>  
						<tbody>                    
						<?php $i = 0;  foreach ($terminal as $row){ ?>
              <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->MAKE.' '.$row->MODEL.' '.$row->TYPE?>">
			        	<td class="">
                  <input type="checkbox" class="case" tabindex="-1">
			          </td>
			          <td style="">
                  <a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
			          </td>
			          <td style="">
                  <a id="TYPE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->TYPE?></a>
			          </td>
			          <td style="">
                  <a id="MAKE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->MAKE?></a>
			          </td>
			          <td style="">
                  <a id="MODEL-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->MODEL?></a>
			          </td>
			          <td style="">
                  <a id="MAC_ADDRESS-<?=$row->ID?>" class="edit" data-inputclass="mac" tabindex="0"><?=$row->MAC_ADDRESS?></a>
			          </td>
			          <td style="">   
                    <a id="CONN_TYPE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->CONN_TYPE?><i></i></a>
			          </td>  
			          <td style="">
                  <?=$row->LAST_SYNC?>
			          </td>    
              <?php if ($role==1){ ?>
                <td style=""><span id="crby<?=$row->ID?>"><?=$this->setting->get_username($row->CREATED_BY)->NAME?></span></td>
			          <td style=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
			          <td style=""><span id="upby<?=$row->ID?>"><?=$this->setting->get_username($row->LAST_UPDATED_BY)->NAME?></span></td>
			          <td style=""><span id="updt<?=$row->ID?>"><?=$row->LAST_UPDATED_DATE?></span></td>  
              <?php } ?>
			        </tr>
			      <?php $i++; } ?>
						</tbody>
					</table>
        </div> 
			</div><!--/.panel-body-->
		</div><!--/.panel-->
	</div><!--/.col-lg-12-->
</div><!--/.row-->
		
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Terminal</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newdev', 'role' => 'form');
        echo form_open('setting/terminal',$attributes)
      ?>                    		
        <div class="form-group" style="margin-bottom:10px">  
          <label for="Name"></label>
          <div class="input-group">          
            <div class="input-group-addon"><span class="fa fa-tablet"></span></div>
            <input type="text" class="form-control" id="Name" placeholder="Name" name="terminal_name" required>
          </div>
        </div><br />         		
        <div class="form-group" style="margin-bottom:10px">  
          <label for="Type"></label>
          <div class="input-group">          
            <div class="input-group-addon"><span class="fa fa-tablet"></span></div>
            <input type="text" class="form-control" id="Type" placeholder="Type" name="terminal_type" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="Manufacturer"></label>
          <div class="input-group">       
            <div class="input-group-addon"><span class="fa fa-tablet"></span></div>
            <input type="text" class="form-control" id="Manufacturer" placeholder="Manufacturer" name="terminal_manufacturer" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">    
          <label for="Model"></label>
          <div class="input-group">    
            <div class="input-group-addon"><span class="fa fa-tablet"></span></div>
            <input type="text" class="form-control" id="Model" placeholder="Model" name="terminal_model" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">      
          <label for="terminal_mac"></label>
          <div class="input-group"> 
            <div class="input-group-addon"><span class="fa fa-gear"></span></div>
            <input type="text" class="form-control" id="terminal_mac" placeholder="MAC Address" name="terminal_mac" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="conn_type">Host/Client</label><br />  
          <div class="input-group">             
            <div class="input-group-addon"><span class="fa fa-gear"></span></div>
            <select id="conn_type" name="conn_type" class="form-control" style="width:168px" required>
            <?php foreach($conn_type as $rowc){ ?>
              <option value = "<?=$rowc->CODE?>"><?=$rowc->VALUE?></option>
            <?php } ?>
            </select>
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="devrest">Restaurant</label><br />  
          <div class="input-group">             
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <input type="text" class="form-control" id="devrest" placeholder="" name="rest_id" value="<?=$def_rest_name?>" disabled>
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
  $edit_script .= "  var updateurl = '".base_url()."process/terminal?p=update';";
  foreach ($terminal as $row){
  $edit_script .= "  $('#NAME-".$row->ID."').editable({
                        url: updateurl,
                        pk: ".$row->ID.", 
                        validate: function(v) {
                          if (!v) return 'don\'t leave it blank!';  
                          if (!isLimited(v,1,45)) return 'please fill in up to 45 chars!';
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
  $edit_script .= "  $('#TYPE-".$row->ID."').editable({
                        url: updateurl,
                        pk: ".$row->ID.", 
                        validate: function(v) {
                          if (!v) return 'don\'t leave it blank!';  
                          if (!isLimited(v,1,45)) return 'please fill in up to 45 chars!';
                        },
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                      } 
                    });
                        $('#TYPE-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
  $edit_script .= "  $('#MAKE-".$row->ID."').editable({
                        url: updateurl,
                        pk: ".$row->ID.", 
                        validate: function(v) {
                          if (!v) return 'don\'t leave it blank!';
                          if (!isLimited(v,1,45)) return 'please fill in up to 45 chars!';
                        },
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                      } 
                    });
                        $('#MAKE-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
  $edit_script .= "  $('#MODEL-".$row->ID."').editable({
                        url: updateurl,
                        pk: ".$row->ID.", 
                        validate: function(v) {
                          if (!v) return 'don\'t leave it blank!'; 
                          if (!isLimited(v,1,45)) return 'please fill in up to 45 chars!';  
                        },
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                      } 
                    });
                        $('#MODEL-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";
  $edit_script .= "   $('#MAC_ADDRESS-".$row->ID."').on('shown', function(e, editable) { 
                        $('.mac').inputmask({ 'mask': '**:**:**:**:**:**' });
                      });";
  $edit_script .= "  $('#MAC_ADDRESS-".$row->ID."').editable({
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
                        $('#MAC_ADDRESS-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";             
  $edit_script .= "  $('#CONN_TYPE-".$row->ID."').editable({    
                        type: 'select',
                        url: updateurl,
                        pk: ".$row->ID.", 
                        value: '".addslashes($row->CONN_TYPE)."', 
                        source: [ ";
    $u = 1; 
    $v = count($conn_type);                   
    foreach($conn_type as $rows){      
      $edit_script .= "  {value: '".addslashes($rows->CODE)."', text: '".addslashes($rows->VALUE)."'}";
      $edit_script .= ($u<$v)?", ":"";
      $v++;
    }                      
  $edit_script .= "     ],
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);   
                          $('#updt".$row->ID."').html(data[1]);  
                      } 
                    });
                        $('#CONN_TYPE-".$row->ID."').on('save', function(e) {  
                          return $(this).parents().nextAll(':has(.editable:visible):first').find('.editable:first').focus();
                        });";    
  }
  $edit_script .= "}); ";   
	$edit_script .= '</script>';
  echo $edit_script;
?>
<script>   
$(document).ready(function()
{  
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
            url: baseurl+"process/terminal?p=delete",
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
 	$("#terminal_mac").inputmask({ "mask": "**:**:**:**:**:**" });
  
  //autoresizing inputs
  $('#newdev input').autoResize(); 
});                                           


  
$(function(){
  	$("#newdev").validate({ 
    	rules: {
      		terminal_mac: { 
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
