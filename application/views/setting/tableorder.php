<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/restaurant">Restaurant</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menu">Menu</a>                            
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menuinventory">Menu - Inventory</a>         
      <a role="button" class="btn btn-primary" href="<?=base_url()?>setting/tableorder">Table Order</a>        
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/users">Users</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/printer">Printer</a>       
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/devices">Devices</a>           
    </div>       
                                                                          
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('setting/tableorder',$attributes)
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
              			<span class="glyphicon glyphicon-plus"></span> Add New Table Order  
            		</button>             
            		<button type="button" class="btn btn-danger">
              			<span class="glyphicon glyphicon-remove"></span> Delete Selected Table Order
            		</button>        
            		<div style="margin-bottom:15px"></div> 
            		<div class="table-responsive">
						<table id="setting" class="table table-striped dt-right compact">
						    <thead>
						    	<tr class="tablehead text3D">
						        	<th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
							        <th class="cin">Table Number</th>
							        <th class="cin">Position</th>
							        <th>Created By</th>
							        <th>Created Date</th>
							        <th>Updated By</th>
							        <th>Updated Date</th>
							    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0;  foreach ($tableorder as $row){ ?>
				                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->TABLE_NUMBER?>">
				                  	<td class="">
				                    	<input type="checkbox" class="case" tabindex="-1">
				                  	</td>
				                  	<td class="cin" style="">
				                    	<a id="TABLE_NUMBER-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->TABLE_NUMBER?></a>
				                  	</td>
				                  	<td class="cin" style="">
				                    	<a id="POSITION-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->POSITION?></a>
				                  	</td>
				                  	<td style=""><span id="crby<?=$row->ID?>"><?=$this->setting->get_username($row->CREATED_BY)->NAME?></span></td>
				                  	<td style=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
				                  	<td style=""><span id="upby<?=$row->ID?>"><?=$this->setting->get_username($row->LAST_UPDATED_BY)->NAME?></span></td>
				                  	<td style=""><span id="updt<?=$row->ID?>"><?=$row->LAST_UPDATED_DATE?></span></td>
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
        <h4 class="modal-title" id="myModalLabel">Add New Table Order</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newtabo', 'role' => 'form');
        echo form_open('setting/tableorder',$attributes)
      ?>
        <div class="form-group" style="margin-bottom:10px">    
          <label for="tableorder_name"></label> 
          <div class="input-group">  
            <div class="input-group-addon"><span class="fa fa-square-o"></span></div> 
            <input type="text" class="form-control" id="tableorder_name" placeholder="Table Number" name="tableorder_name" pattern="\d*" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">       
          <label for="tableorder_position"></label>
          <div class="input-group"> 
            <div class="input-group-addon"><span class="fa fa-plus-square-o"></span></div>
            <input type="text" class="form-control" id="tableorder_position" placeholder="Position" name="tableorder_position" pattern="\d*" required>
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
<div id="restid" data-val="<?=$rest_id?>"></div>

<?php  
  	//editable script
  	$i = 0;
  	$edit_script = "<script>"; 
  	$edit_script .= "$(document).ready(function(){";
  	$edit_script .= "  $.fn.editable.defaults.mode = 'inline';";
	$edit_script .= "  $.fn.editable.defaults.showbuttons = false;";
  	$edit_script .= "  var updateurl = '".base_url()."process/tableorder?p=update';";
  	foreach ($tableorder as $row){
  		$edit_script .= "  $('#TABLE_NUMBER-".$row->ID."').editable({
	                        url: updateurl,
	                        pk: ".$row->ID.", 
	                        validate: function(v) {
	                          if (!v) return 'don\'t leave it blank!';   
	                          if (isNaN(v)) return 'please fill in a number format!';
	                          if (isTaken(v)) return 'please fill another Table Number!'; 
	                        },
	                        success: function(result){  
	                          var data = result.split(',');
	                          $('#upby".$row->ID."').html(data[0]);
	                          $('#updt".$row->ID."').html(data[1]); 
	                      } 
	                    });";
	  	$edit_script .= "  $('#POSITION-".$row->ID."').editable({
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
	  
	//initiate datatable
	var table = $('#setting').DataTable({
    	columnDefs: [
      		{ targets: 'no-sort', orderable: false }
    	],
    	"order": [[ 1, "asc" ]],
      pageLength: 15,
      "aLengthMenu": [[15, 35, 100, -1], [15, 35, 100, "All"]],
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
	            		url: baseurl+"process/tableorder?p=delete",
	            		data: dataP,
	            		cache: false,
	            		success: function(result){ 
	              			if(result.trim()!='OK'){    
	                			alert(result); 
	              			} else {    
	        					$this.parents('tr').fadeOut(function(){
	        						$this.remove(); //remove row when animation is finished
	        					});     
	              			}   
	            		}
	          		});   
	  			}
	  	  	});
	  		if(!sel) alert('No data selected');	
		}
	  	return false;
	}); 
});

$(function(){
	var baseurl = $("#baseurl").data('url'); 
	var restid = $("#restid").data('val');
	$("#newtabo").validate({
    rules: {   
      tableorder_name: { 
        number: true,
        remote: baseurl+"process/tableorder?p=takent&r="+restid  
      },
			tableorder_position: {
        number: true
			} 
	  },
	  messages:{
      tableorder_name: {
        remote: "Please enter another Table Number"
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

function isTaken(tbl) {  
  var regex = /^(<?php $l = 1; $n = count($tableorder); $tblnum = ""; foreach ($tableorder as $row){ $tblnum .= $row->TABLE_NUMBER; $tblnum .= ($l<$n)?"|":""; $l++; } echo $tblnum; ?>)$/;
  return regex.test(tbl);
}  
</script>    