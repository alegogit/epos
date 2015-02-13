<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
                                       
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('sync',$attributes)
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
            <button type="submit" class="btn btn-success" style="display:inline">Filter</button>   
          </div>
        </div>
      <?=form_close()?>     
    </div>              
                                                     
    <hr style="margin-bottom:10px;margin-top:10px" />
    
    <div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading"><b>Sync History</b></div>
				<div class="panel-body"> 
            		<div class="table-responsive">
						<table id="sync" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th>Device</th>
						        <th>Last Sync</th>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th>
						    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0;  foreach ($synchist as $row){ ?>
                			<tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->NAME?>">
			                  	<td class="">
			                    	<a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
			                  	</td>
			                  	<td class="">
			                    	<a id="LASY_SYNC-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->LAST_SYNC?></a>
			                  	</td>
			                  	<td class=""><span id="crby<?=$row->ID?>"><?=$this->sync->get_username($row->CREATED_BY)->NAME?></span></td>
			                  	<td class=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
			                  	<td class=""><span id="upby<?=$row->ID?>"><?=$this->sync->get_username($row->LAST_UPDATED_BY)->NAME?></span></td>
			                  	<td class=""><span id="updt<?=$row->ID?>"><?=$row->LAST_UPDATED_DATE?></span></td>
			                </tr>
			                <?php $i++; } ?>
						    </tbody>
						</table>
					</div><!--/.table-responsive--> 
				</div><!--/.panel-body-->
			</div><!--/.panel-->
		</div><!--/.col-lg-12-->
	</div><!--/.row-->       
	                                
    <hr style="margin-bottom:10px;margin-top:10px" />
	
	<div class="row" style="padding-left: 15px">
		<a class="btn btn-lg btn-success" href=""><i class="fa fa-refresh"></i> Sync Now</a>
	</div>
	                                
    <hr style="margin-bottom:10px;margin-top:10px" />
  
</div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<div id="baseurl" data-url="<?=base_url()?>"></div>
<?php  
  	//editable script
  	$i = 0;
  	$edit_script = "<script>"; 
  	$edit_script .= "$(document).ready(function(){";
  	$edit_script .= "  $.fn.editable.defaults.mode = 'inline';";
  	$edit_script .= "  $.fn.editable.defaults.showbuttons = false;";
  	$edit_script .= "  var updateurl = '".base_url()."process/sync?p=update';";
  	foreach ($synchist as $row){
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
  		$edit_script .= "  $('#LAST_SYNC-".$row->ID."').editable({
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
  	var table = $('#sync').DataTable({
    	columnDefs: [
      		{ targets: 'no-sort', orderable: false }
    	],
    	"order": [[ 1, "asc" ]]
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
