<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
                                       
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('customers',$attributes)
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
					<div class="panel-heading"><b>Customers</b></div>
					<div class="panel-body">                 					                    
			      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
              <span class="glyphicon glyphicon-plus"></span> Add New Customers
            </button>             
            <button type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span> Delete Selected Customer(s)
            </button>        
            <div style="margin-bottom:15px"></div> 
            <div class="table-responsive" style="overflow:scroll;">
						  <table id="customers" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Customer Name</th>
						        <th>Email Address</th>
						        <th>Telephone</th>
						        <th>Address Line 1</th>
						        <th>Address Line 2</th>
						        <th>City</th>
						        <th>Postal Code</th>
						        <th>Country</th>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th>
						    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0;  foreach ($customers as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->NAME?>">
                  <td class="">
                    <input type="checkbox" class="case" tabindex="-1">
                  </td>
                  <td style="">
                    <a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
                  </td>
                  <td style="">
                    <a id="EMAIL_ADDRESS-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->EMAIL_ADDRESS?></a>
                  </td>
                  <td style="">
                    <a id="TELEPHONE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->TELEPHONE?></a>
                  </td>
                  <td style="">
                    <a id="ADDRESS_LINE_1-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->ADDRESS_LINE_1?></a>
                  </td>
                  <td style="">
                    <a id="ADDRESS_LINE_2-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->ADDRESS_LINE_2?></a>
                  </td>
                  <td style="">
                    <a id="CITY-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->CITY?></a>
                  </td>
                  <td style="">
                    <a id="POSTAL_CODE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->POSTAL_CODE?></a>
                  </td>
                  <td style="">
                    <a id="COUNTRY-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->COUNTRY?></a>
                  </td>
                  <td style=""><span id="crby<?=$row->ID?>"><?=$this->customers->get_name($row->CREATED_BY)->NAME?></span></td>
                  <td style=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
                  <td style=""><span id="upby<?=$row->ID?>"><?=$this->customers->get_name($row->LAST_UPDATED_BY)->NAME?></span></td>
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
        <h4 class="modal-title" id="myModalLabel">Add New Customer</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newcust', 'role' => 'form');
        echo form_open('customers',$attributes)
      ?>  
	  	<div class="responsive col-md-6">                  		
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="name"></label> 
	          <div class="input-group">      
	            <div class="input-group-addon"><span class="fa fa-credit-card"></span></div> 
	            <input type="text" class="form-control" id="name" placeholder="Customer Name" name="name" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="email"></label> 
	          <div class="input-group">                                              
	            <div class="input-group-addon"><span class="fa fa-envelope-o"></span></div>
	            <input type="text" class="form-control" id="email" placeholder="Email Address" name="email" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="phone"></label> 
	          <div class="input-group">                              
	            <div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div>    
	            <input type="text" class="form-control" id="phone" placeholder="Phone Number" name="phone" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px"> 
	          <label for="resto">Select Restaurant</label><br /> 
	          <div class="input-group">       
	            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
	            <select id="resto" name="rest_id" class="form-control">
	            <?php foreach($restaurants as $rows){ ?>
	              <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$rest_id)?'selected':''?> ><?=$rows->NAME?></option>
	            <?php } ?>
	            </select>
	          </div>
	        </div><br />
	  	</div> 
	  	<div class="responsive col-md-6">
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="address1"></label> 
	          <div class="input-group">                                                                                                  
	            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
	            <input type="text" class="form-control" id="address1" placeholder="Address Line 1" name="address1" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="address2"></label> 
	          <div class="input-group">                                                                                               
	            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>   
	            <input type="text" class="form-control" id="address2" placeholder="Address Line 2" name="address2" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="city"></label> 
	          <div class="input-group">                                                                                     
	            <div class="input-group-addon"><span class="fa fa-building"></span></div>
	            <input type="text" class="form-control" id="city" placeholder="City" name="city" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="postal"></label> 
	          <div class="input-group">                                                  
	            <div class="input-group-addon"><span class="fa fa-envelope"></span></div> 
	            <input type="text" class="form-control" id="postal" placeholder="Postal Code" name="postal" required>
	          </div>
	        </div><br />
	        <div class="form-group" style="margin-bottom:10px">
	          <label for="country"></label> 
	          <div class="input-group">                              
	            <div class="input-group-addon"><span class="fa fa-flag"></span></div>  
	            <input type="text" class="form-control" id="country" placeholder="Country" name="country" required>
	          </div>
	        </div><br />
	  	</div>  
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
	$edit_script .= "  var updateurl = '".base_url()."process/customers?p=update';";
	$edit_script .= "  $.fn.editable.defaults.mode = 'inline';";
  	$edit_script .= "  $.fn.editable.defaults.showbuttons = false;";
	foreach ($customers as $row){
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
		$edit_script .= "  $('#TELEPHONE-".$row->ID."').editable({
		                        url: updateurl,
		                        pk: ".$row->ID.", 
		                        validate: function(v) {
		                          	if (!v) return 'don\'t leave it blank!';  
                          			if (!isPhone(v)) return 'please fill in a Phone Number format!';
		                        },
		                        success: function(result){  
		                          	var data = result.split(',');
		                          	$('#upby".$row->ID."').html(data[0]);
		                          	$('#updt".$row->ID."').html(data[1]); 
		                      	} 
		                    });";
		$edit_script .= "  $('#ADDRESS_LINE_1-".$row->ID."').editable({
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
		$edit_script .= "  $('#ADDRESS_LINE_2-".$row->ID."').editable({
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
		$edit_script .= "  $('#CITY-".$row->ID."').editable({
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
		$edit_script .= "  $('#POSTAL_CODE-".$row->ID."').editable({
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
		$edit_script .= "  $('#COUNTRY-".$row->ID."').editable({
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
		$edit_script .= "  $('#EMAIL_ADDRESS-".$row->ID."').editable({
		                        url: updateurl,
		                        pk: ".$row->ID.", 
		                        validate: function(v) {
		                          	if (!v) return 'don\'t leave it blank!';
                          			if (!isEmail(v)) return 'please fill in an e-Mail format!';
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
  	var table = $('#customers').DataTable({
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
  		var ch = $('#customers').find('tbody input[type=checkbox]');
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
            			url: baseurl+"process/customers?p=delete",
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
  	//pass validation
  	$("#newcust").validate({ 
	    rules: {
	      email: { 
	        email: true
	      }, 
	      name: {
	        required: true,
	        minlength: 3
	      },
	      phone: { 
	        phone: true 
	      }      
	    },
	    messages:{
	      email: {
	        required: "Please enter email address."
	      },
	      phone: {
	        phone: "Please fill in a Phone Number format" 
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

jQuery.validator.addMethod("phone", function(value, element) {
  return this.optional(element) || /(\D*\d){8}/.test(value);
}, "Please fill in a Phone Number format");
  
function isEmail(email) {
  var regex = /([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}  

function isPhone(phone) {
  var regex = /(\D*\d){8}/;
  return regex.test(phone);
}    
</script>
