<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/restaurant">Restaurant</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menu">Menu</a>             
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
						        <th>Restaurant</th>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th>
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
                    <a id="PASSWORD-<?=$row->ID?>" class="edit" tabindex="0">******</a>
                 </td>
                  <td style="">
                    <a id="ROLE_ID-<?=$row->ID?>" class="edit" tabindex="0"><?=$this->setting->get_role_name($row->ROLE_ID)?></a>
                  </td>
                  <td style="">
                    <a id="REST_ID-<?=$row->ID?>" class="edit" tabindex="0"></a>
                  </td>
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
    <!-- FOOTER -->
    <hr class="featurette-divider" />
    
    <footer>
      <p class="pull-right">
        <a href="#">Back to top <span class="glyphicon glyphicon-circle-arrow-up"></span></a>
      </p>
	</footer>
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New users</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">  <div id="errmsg"></div>
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newuser', 'role' => 'form');
        echo form_open('setting/users',$attributes)
      ?>                    		
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" placeholder="" name="name" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="email">E-mail Address</label>
            <input type="text" class="form-control" id="email" placeholder="please fill in an e-mail format" pattern="^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" name="email" required>
            <span class="errmsg"></span>
          </div>
        </div><br />        		
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" placeholder="" name="username" required>
            <span class="errmsg"></span>
          </div>
        </div><br />     		
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" placeholder="minimum 6 chars" name="password" pattern=".{5,}" required>
            <span class="errmsg"></span>
          </div>
        </div><br />  
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="confirm">Confirm Password</label>
            <input type="password" class="form-control" id="confirm" placeholder="please retype password" name="confirm" pattern=".{5,}" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">
          <div class="input-group">       
            <label for="role">Role</label><br />  
            <select name="users_printer" class="form-control">
            <?php foreach($roles as $rowr){ ?>
              <option value="<?=$rowr->ID?>"><?=$rowr->NAME?></option>
            <?php } ?>
            </select>
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="rest_id">Restaurant</label><br /> 
            <select name="rest_id" class="form-control">
            <?php foreach($restaurants as $rows){ ?>
              <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$rest_id)?'selected':''?> ><?=$rows->NAME?></option>
            <?php } ?>
            </select>
          </div>
        </div><br />  
        <div class="form-group text-right" style="margin-bottom:10px">
          <div class="input-group">       
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </div><br /> 
        <?=form_close()?>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<?php  
  //editable script
  $i = 0;
  //$n = count($dtopcats);
  $edit_script = "<script>"; 
  $edit_script .= "$(document).ready(function(){";        
  $edit_script .= "  $.fn.editable.defaults.mode = 'inline';";
  $edit_script .= "  $.fn.editable.defaults.showbuttons = false;";
  $edit_script .= "  var updateurl = '/process/users?p=update';";
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
                    
  $edit_script .= "  $('#PASSWORD-".$row->ID."').editable({ 
                        url: updateurl,
                        mode: 'popup',
                        placement: 'right',
                        showbuttons: true,
                        pk: ".$row->ID.",
        tpl: '<div class=\"editable-address\"><label><span>Pass1: </span><input type=\"password\" name=\"pass1\" class=\"input-small\"></label></div><br>'+
             '<div class=\"editable-address\"><label><span>Pass2: </span><input type=\"password\" name=\"pass2\" class=\"input-small\"></label></div>',         
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
      $t++;
    }                      
  $edit_script .= "     ],
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                      } 
                    });";
                    
  $edit_script .= "  $('#REST_ID-".$row->ID."').editable({
                        type: 'checklist',  
                        mode: 'popup',
                        placement: 'right',
                        value: [";  
		$assigned = $this->setting->get_assigned_rest($row->ID);
    $a = 1;
    $b = count($assigned);                    
    foreach($assigned as $rowa){   
      $edit_script .= $rowa->REST_ID;
      $edit_script .= ($a<$b)?", ":"";
      $a++;
    }
  $edit_script .= "     ], 
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
                      });";
  }
  $edit_script .= "}); ";
	$edit_script .= '</script>';
  echo $edit_script;
?>
<script>   
$(document).ready(function()
{ 
  //make editable on focus  
  $('.edit').focus(function(e) {
    e.stopPropagation();
    $(this).editable('toggle');
  });
  
  var table = $('#setting').DataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 9, "desc" ]]
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
            url: "/process/users?p=delete",
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
  $("#newuser").validate({ 
    rules: {
      email: { 
        email: true 
      }, 
      password: { 
        minlength: 6 
      }, 
      confirm: { 
        equalTo: "#password",
        minlength: 6
      }       
    },
    messages:{ 
      name: "Please enter name.",
      username: "Please enter username.",
      confirm: { 
        equalTo:"the passwords aren't match"
      }
    },
    errorElement: "span",   
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    } 
  });
});
  
function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}  
</script>
