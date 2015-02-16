<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/restaurant">Restaurant</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menu">Menu</a>                         
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menuinventory">Menu - Inventory</a>            
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/tableorder">Table Order</a>        
      <a role="button" class="btn btn-primary" href="<?=base_url()?>setting/users">Users</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/printer">Printer</a>       
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/devices">Devices</a>           
    </div>       
                                                                          
    <hr style="margin-bottom:10px" />
    
    <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Users Setting</b></div>
					<div class="panel-body">                 					                    
			      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
              <span class="glyphicon glyphicon-plus"></span> Add New User
            </button>             
            <button type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span> Delete Selected users(s)
            </button>        
            <div style="margin-bottom:15px"></div> 
            <div class="table-responsive">
						  <table id="setting" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Name</th>
						        <th>E-mail Address</th>
						        <th>Username</th>
						        <th>Password</th>
						        <th>Role</th>
						        <th>Assigned Restaurant(s)</th>
						        <th>Default Restaurant</th>
						        <th>Last Login</th>
						        <th>Created By</th>
						        <th>Created Date</th>
						        <th>Updated By</th>
						        <th>Updated Date</th>
						    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0; $tab = 1; foreach ($users as $row){ ?>
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
                    <a id="USERNAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->USERNAME?></a>
                  </td>
                  <td style="">
                    <a id="PASSWORD-<?=$row->ID?>" class="epop" tabindex="-1" data-toggle="modal" data-target="#passModal" data-uid="<?=$row->ID?>" data-unm="<?=$row->USERNAME?>" style="font-size:70%">
                      <i class="fa fa-circle"></i>
                      <i class="fa fa-circle"></i>
                      <i class="fa fa-circle"></i>
                      <i class="fa fa-circle"></i>
                      <i class="fa fa-circle"></i>
                      <i class="fa fa-circle"></i>
                    </a>
                 </td>
                  <td style="">
                    <a id="ROLE_ID-<?=$row->ID?>" class="edit" tabindex="0"><?=$this->setting->get_role_name($row->ROLE_ID)?></a>
                  </td>
                  <td style="">
				  	<?php
							$assigned = $this->setting->get_assigned_rest($row->ID);
						    $a = 1;
						    $b = count($assigned);
							$assval = "[";         
							$asstxt = "";                    
						    foreach($assigned as $rowa){   
						      	$assval .= $rowa->REST_ID;
						      	$assval .= ($a<$b)?",":"";   
						      	$asstxt .= $rowa->NAME;
						      	$asstxt .= ($a<$b)?", ":"";
						      	$a++;
						    }         
							$assval .= "]";
					?>
                    <a id="ASS_REST-<?=$row->ID?>" class="epop" tabindex="-1" data-toggle="modal" data-target="#restModal" data-uid="<?=$row->ID?>" data-unm="<?=$row->USERNAME?>" data-def="<?=$assval?>" style="">
						<?=($asstxt!="")?$asstxt:"click to assign restaurant(s)"?>
					</a>
                  </td>
                  <td style="">
                    <a id="DEF_REST-<?=$row->ID?>" class="edit" tabindex="0"><?=$this->setting->get_default_rest($row->ID)->REST_NAME?></a>
                  </td>
                  <td style=""><span id="last<?=$row->ID?>"><?=$row->LAST_LOGIN?></span></td>
                  <td style=""><span id="crby<?=$row->ID?>"><?=$this->setting->get_username($row->CREATED_BY)->USERNAME?></span></td>
                  <td style=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
                  <td style=""><span id="upby<?=$row->ID?>"><?=$this->setting->get_username($row->LAST_UPDATED_BY)->USERNAME?></span></td>
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
        <h4 class="modal-title" id="myModalLabel">Add New User</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newuser', 'role' => 'form');
        echo form_open('setting/users',$attributes)
      ?>
      <div class="row">  
        <div class="col-md-6">                  		
          <div class="form-group" style="margin-bottom:10px">   
            <label for="name"></label>
            <div class="input-group">                     
              <div class="input-group-addon"><span class="fa fa-meh-o"></span></div>
              <input type="text" class="form-control" id="name" placeholder="Name" name="name" required>
              <span class="errmsg"></span>
            </div>
          </div><br />
          <div class="form-group" style="margin-bottom:10px">    
            <label for="email"></label>
            <div class="input-group">                                           
              <div class="input-group-addon"><span class="fa fa-envelope"></span></div> 
              <input type="text" class="form-control" id="email" placeholder="E-mail Address" pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" name="email" required>
              <span class="errmsg"></span>
            </div>
          </div><br />        		
          <div class="form-group" style="margin-bottom:10px">       
            <label for="username"></label>
            <div class="input-group">     
              <div class="input-group-addon"><span class="fa fa-user"></span></div>                            
              <input type="text" class="form-control" id="username" placeholder="Username" name="username" required>
              <span class="errmsg"></span>
            </div>
          </div><br>     
          <div class="form-group" style="margin-bottom:10px">
            <label for="role"></label>
            <div class="input-group"> 
              <div class="input-group-addon"><span class="fa fa-hand-o-right"></span></div>        
              <select name="role" id="role" class="form-control" data-width="168px" data-size="5">
                <option value="">Select Role</option>
              <?php foreach($roles as $rowr){ ?>
                <option value="<?=$rowr->ID?>"><?=$rowr->NAME?></option>
              <?php } ?>
              </select>
            </div>
          </div> 
        </div>
        <div class="col-md-6">     		
          <div class="form-group" style="margin-bottom:10px"> 
            <label for="password"></label>
            <div class="input-group">                 
              <div class="input-group-addon"><span class="fa fa-lock"></span></div>  
              <input type="password" class="form-control" id="password" placeholder="Password" name="password" pattern=".{6,}" required>
              <span class="errmsg"></span>
            </div>
          </div><br />  
          <div class="form-group" style="margin-bottom:10px"> 
            <label for="confirm"></label>
            <div class="input-group">                  
              <div class="input-group-addon"><span class="fa fa-lock"></span></div> 
              <input type="password" class="form-control" id="confirm" placeholder="Confirm Password" name="confirm" pattern=".{6,}" required>
              <span class="errmsg"></span>
            </div>
          </div><br />    
          <div class="form-group" style="margin-bottom:10px">    
            <label for="rest_id">Default Restaurant</label><br> 
            <div class="input-group">  
              <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>  
              <select id="rest_id" name="rest_id" class="form-control selectpicker show-tick" data-size="5" data-width="168px" data-live-search="true">
              <?php foreach($restaurants as $rows){ ?>
                <option value = "<?=$rows->REST_ID?>"><?=$rows->NAME?></option>
              <?php } ?>
              </select>
            </div>
          </div>
        </div><br>
      </div>
      <div class="row">
        <div class="pull-right" style="margin-right:30px"> 
        <div class="form-group" style="margin-bottom:10px">
          <div class="input-group">       
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div>
        </div>
      </div> 
      <?=form_close()?>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->

<!-- Modal2 -->
<div class="modal fade" id="passModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit <span id="moduser"></span>'s Password</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">  <div id="errmsg"></div>
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'editpass', 'role' => 'form');
        echo form_open('setting/users',$attributes)
      ?>                    		
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="pass1">New Password</label><br>
          <div class="input-group">                
            <div class="input-group-addon"><span class="fa fa-lock"></span></div>                 
            <input type="password" class="form-control" id="pass1" placeholder="minimum 6 chars" name="pass1" pattern=".{5,}" required>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="pass2">Retype Password</label><br>  
          <div class="input-group">              
            <div class="input-group-addon"><span class="fa fa-lock"></span></div>
            <input type="password" class="form-control" id="pass2" placeholder="minimum 6 chars" name="pass2" pattern=".{5,}" required><span class="errmsg"></span>
          </div>
        </div><br />        		
        <div class="form-group text-right" style="margin-bottom:10px">
          <div class="input-group">  
            <input type="hidden" name="uid" id="uid">      
            <input type="submit" name="cps" class="btn btn-success" value="Submit">&nbsp;
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div><br /> 
        <?=form_close()?>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->

<!-- Modal3 -->
<div class="modal fade" id="restModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Assign Restaurant to <span id="moduser"></span></h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">  <div id="errmsg"></div>
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'assrest', 'role' => 'form');
        echo form_open('setting/users',$attributes);
      ?>            
        <div class="form-group" style="margin-bottom:10px"> 
         	<label for="asgrest"></label><br>
        	<div class="input-group">  
        		<div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>  
            	<select id="asgrest" name="asgrest[]" class="form-control selectpicker show-tick" data-size="5" data-width="168px" data-live-search="true" required multiple>
              	<?php foreach($restaurants as $rows){ ?>
                	<option value = "<?=$rows->REST_ID?>"><?=$rows->NAME?></option>
              	<?php } ?>
              	</select>
            </div>
		</div><br/>
        <div class="form-group text-right" style="margin-bottom:10px">
          <div class="input-group">  
            <input type="hidden" name="uid" id="auid">     
            <input type="submit" name="ars" class="btn btn-success" value="Submit">&nbsp;
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
  	$edit_script .= "  var updateurl = '".base_url()."process/users?p=update';";
  	foreach ($users as $row){
  		$edit_script .= "  $('#NAME-".$row->ID."').editable({
        					url: updateurl,
                        	pk: ".$row->ID.", 
                        	activate: 'focus',
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
  		$edit_script .= "  $('#USERNAME-".$row->ID."').editable({
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
                    
  		$edit_script .= "  $('#ROLE_ID-".$row->ID."').editable({    
	                        type: 'select',  
	                        url: updateurl,
	                        pk: ".$row->ID.", 
	                        value: ".$row->ROLE_ID.", 
	                        source: [ ";
	    $r = 1; 
	    $t = count($roles);                   
	    foreach($roles as $rowr){      
	      	$edit_script .= "  {value: ".$rowr->ID.", text: '".$rowr->NAME."'}";
	      	$edit_script .= ($r<$t)?", ":"";
	      	$r++;
	    }                      
	  	$edit_script .= "     ],
	                    	success: function(result){  
	                          	var data = result.split(',');
	                          	$('#upby".$row->ID."').html(data[0]);
	                          	$('#updt".$row->ID."').html(data[1]); 
	                      	} 
	                    });";
  		$def_rest = (!$this->setting->get_default_rest($row->ID)->REST_ID)?0:$this->setting->get_default_rest($row->ID)->REST_ID;						  
  		$edit_script .= "  $('#DEF_REST-".$row->ID."').editable({
                        type: 'select', 
						value: ".$def_rest.",
                        inputClass: 'selectpicker show-tick',
                        source: [";
		$assigned = $this->setting->get_assigned_rest($row->ID);
		$a = 1;
		$b = count($assigned);
		foreach($assigned as $rowa){   
			$edit_script .= "  {value: ".$rowa->REST_ID.", text: '".$rowa->NAME."'}";
      		$edit_script .= ($a<$b)?", ":"";
      		$a++;
    	}
  		$edit_script .= "    ],
                        url: updateurl,
                        pk: ".$row->ID.",
                        success: function(result){  
                          	var data = result.split(',');
                          	$('#upby".$row->ID."').html(data[0]);
                          	$('#updt".$row->ID."').html(data[1]); 
                        }  
                     });";
  	}
  	$edit_script .= '});</script>';
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
     
  	$(".epop").click(function () { 
    	var uidP = $(this).data('uid'); 
    	var unmP = $(this).data('unm'); 
    	var defP = $(this).data('def');   
    	$(".modal-title #moduser").html(unmP);   
    	$("#uid").val(uidP);
    	$("#auid").val(uidP);
		if(defP) $('.selectpicker').selectpicker('val', defP); console.log(defP);
  	});
  
  	//inititate datatable
  	var table = $('#setting').DataTable({
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
            			url: baseurl+"process/users?p=delete",
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
  	$("#newuser").validate({ 
    	rules: {
      		email: { 
        		email: true,
        		remote: baseurl+"process/users?p=takene" 
      		}, 
	      	username: {
	        	required: true,
	        	minlength: 5,
	        	remote: baseurl+"process/users?p=takenu"
	      	},
	      	password: { 
	        	minlength: 6 
	      	}, 
	      	confirm: { 
	        	equalTo: "#password",
	        	minlength: 6
	      	},
	      	role: {
	        	required: true
	      	}       
    	},
	    messages:{ 
	      	name: "Please enter name.",
	      	email: {
	        	required: "Please enter email address.",
	        	remote: "Please enter another email"
	      	},
	      	username: {
	        	required: "Please enter username.",
	        	remote: "Please enter another username"
	      	},
	      	confirm: { 
	        	equalTo:"The passwords don’t match"
	      	}
	    }
  });
  
  $("#editpass").validate({ 
    rules: {
      pass1: { 
        minlength: 6 
      }, 
      pass2: { 
        equalTo: "#pass1",
        minlength: 6
      }       
    },
    messages:{ 
      pass2: { 
        equalTo:"The passwords don’t match"
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

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}  
</script>
