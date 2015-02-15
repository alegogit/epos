<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
                                       
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('inventory',$attributes)
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
            <input type="submit" class="btn btn-success" style="display:inline" name="filter" value="Filter">
          </div>
        </div>
      <?=form_close()?>     
    </div>              
                                                     
    <hr style="margin-bottom:10px;margin-top:10px" />
    
    <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Inventory</b></div>
					<div class="panel-body">                 					                    
			      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
              <span class="glyphicon glyphicon-plus"></span> Add New Inventory
            </button>             
            <button type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span> Delete Selected Inventory(ies)
            </button>        
            <div style="margin-bottom:15px"></div> 
            <div class="table-responsive">
						  <table id="inventory" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Inventory Name</th>
						        <th class="cin">QTY</th>
						        <th>Metric</th>
						        <th class="cin">Min QTY</th>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th>
						    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0;  foreach ($inventory as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow <?=$this->inventory->set_class($row->QUANTITY,$row->MIN_QUANTITY)?>" id="<?=$row->ID.'_'.$row->NAME?>">
                  <td class="">
                    <input type="checkbox" class="case" tabindex="-1">
                  </td>
                  <td class="">
                    <a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
                  </td>
                  <td class="cin">
                    <a id="QUANTITY-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->QUANTITY?></a>
                  </td>
                  <td class="">
                    <a id="METRIC-<?=$row->ID?>" class="edit" tabindex="0"><?=$this->inventory->get_metric_name($row->METRIC)->VALUE?></a>
                  </td>
                  <td class="cin">
                    <a id="MIN_QUANTITY-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->MIN_QUANTITY?></a>
                  </td>
                  <td class=""><span id="crby<?=$row->ID?>"><?=$this->inventory->get_username($row->CREATED_BY)->USERNAME?></span></td>
                  <td class=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
                  <td class=""><span id="upby<?=$row->ID?>"><?=$this->inventory->get_username($row->LAST_UPDATED_BY)->USERNAME?></span></td>
                  <td class=""><span id="updt<?=$row->ID?>"><?=$row->LAST_UPDATED_DATE?></span></td>
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
        <h4 class="modal-title" id="myModalLabel">Add New Inventory</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newinv', 'role' => 'form');
        echo form_open('inventory',$attributes)
      ?>                    		
        <div class="form-group" style="margin-bottom:10px">    
          <label for="name"></label> 
          <div class="input-group">  
            <div class="input-group-addon"><span class="fa fa-cubes"></span></div> 
            <input type="text" class="form-control" id="name" placeholder="Inventory Name" name="name" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">   
          <label for="qty"></label> 
          <div class="input-group">    
            <div class="input-group-addon"><span class="fa fa-cubes"></span></div>
            <input type="text" class="form-control" id="qty" placeholder="Quantity" name="qty" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">
          <label for="minq"></label> 
          <div class="input-group">       
            <div class="input-group-addon"><span class="fa fa-cubes"></span></div>
            <input type="text" class="form-control" id="minq" placeholder="Minimum Quantity" name="minq" pattern="" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">
          <label for="metric"></label> 
          <div class="input-group">       
            <div class="input-group-addon"><span class="fa fa-cubes"></span></div>
            <select id="metric" name="metric" class="form-control" required>
              <option value = "">Select Metric</option>
            <?php foreach($metrics as $rowm){ ?>
              <option value = "<?=$rowm->CODE?>"><?=$rowm->VALUE?></option>
            <?php } ?>
            </select>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">
          <label for="rest_id">Restaurant</label><br />  
          <div class="input-group">       
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <select id="rest_id" name="rest_id" class="form-control" required>
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
  	$edit_script .= "  var updateurl = '".base_url()."process/inventory?p=update';";
  	foreach ($inventory as $row){
  		$edit_script .= "  $('#NAME-".$row->ID."').editable({
		                        url: updateurl,
		                        pk: ".$row->ID.", 
		                        validate: function(v) {
		                          if (!v) return 'don\'t leave it blank!';
		                        },
		                        success: function(result){  
		                          var data = result.split(',');
		                          $('#upby".$row->ID."').html(data[0]);
		                          $('#updt".$row->ID."').html(data[1]); 
		                      } 
		                    });";
  		$edit_script .= "  $('#QUANTITY-".$row->ID."').editable({
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
  		$edit_script .= "  $('#METRIC-".$row->ID."').editable({    
                        		type: 'select',  
                        		url: updateurl,
                        		pk: ".$row->ID.", 
                        		value: '".$row->METRIC."', 
                        		source: [ ";
    	$m = 1; 
    	$t = count($metrics);                   
    	foreach($metrics as $rowm){      
      		$edit_script .= "  {value: '".$rowm->CODE."', text: '".$rowm->VALUE."'}";
      		$edit_script .= ($m<$t)?", ":"";
      		$m++;
    	}                      
  		$edit_script .= "     ],
                        		success: function(result){  
                          			var data = result.split(',');
                          			$('#upby".$row->ID."').html(data[0]);
                          			$('#updt".$row->ID."').html(data[1]); 
                      			} 
                    		});";							
  		$edit_script .= "  $('#MIN_QUANTITY-".$row->ID."').editable({
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
  
  	//inititate datatable
  	var table = $('#inventory').DataTable({
    	columnDefs: [
      		{ targets: 'no-sort', orderable: false }
    	],
    	"order": [[ 1, "asc" ]],
      pageLength: 15,    
      "aLengthMenu": [[15, 35, 100, -1], [15, 35, 100, "All"]]
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
  		var ch = $('#inventory').find('tbody input[type=checkbox]');
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
            			url: baseurl+"process/inventory?p=delete",
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
});                                           
  
  
$(function(){
  //pass validation
  $("#newinv").validate({ 
    rules: {
      qty: { 
        number: true 
      },      
      minq: {       
        number: true
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
  
</script>
