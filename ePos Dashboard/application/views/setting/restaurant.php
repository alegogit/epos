<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-primary" href="<?=base_url()?>setting/restaurant">Restaurant</a>                
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menu">Menu</a>             
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/tableorder">Table Order</a>        
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/users">Users</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/printer">Printer</a>       
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/devices">Devices</a>           
    </div>       
                                                                          
    <hr style="margin-bottom:10px" />
    
    <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading"><b>Restaurant Setting</b></div>
					<div class="panel-body">               
          <?php if ($role == 1) { ?>   					                    
			      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookModal">
              <span class="glyphicon glyphicon-plus"></span> Add New User
            </button>             
            <button type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span> Delete Selected restaurant(s)
            </button>
            <div style="margin-bottom:15px"></div>        
          <?php } ?> 
            <div class="table-responsive">
						  <table id="setting" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Name</th>
						        <th>Telephone</th>
						        <th>FAX</th>
						        <th>Address 1</th>
						        <th>Address 2</th>
						        <th>City</th>
						        <th>Postal Code</th>
						        <th>Country</th>
						        <th>Geo Location</th>
						        <th>Email Address</th>
						        <th>Currency</th>
						        <th>Service Charge</th>
						        <th>Order No. Start</th>
						        <th>Created By</th>
						        <th>Created Date</th>
						        <th>Updated By</th>
						        <th>Updated Date</th>
						    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0; $tab = 1; foreach ($restaurant as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->NAME?>">
                  <td class="">
                    <input type="checkbox" class="case" tabindex="-1">
                  </td>
                  <td style="">
                    <a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
                  </td>
                  <td style="">
                    <a id="TELEPHONE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->TELEPHONE?></a>
                  </td>
                  <td style="">
                    <a id="FAX-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->FAX?></a>
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
                  <td style="">
                    <a id="GEOLOC-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->GEOLOC?></a>
                  </td>
                  <td style="">
                    <a id="EMAIL_ADDRESS-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->EMAIL_ADDRESS?></a>
                  </td>
                  <td style="">
                    <a id="CURRENCY-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->CURRENCY_NAME?></a>
                  </td>
                  <td style="">
                    <a id="SERVICE_CHARGE-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->SERVICE_CHARGE?></a>
                  </td>
                  <td style="">
                    <a id="ORDER_NUMBER_START-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->ORDER_NUMBER_START?></a>
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
        <h4 class="modal-title" id="myModalLabel">Add New restaurant</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">  <div id="errmsg"></div>
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newuser', 'role' => 'form');
        echo form_open('setting/restaurant',$attributes)
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
            <select name="role" class="form-control">
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
  $edit_script .= "  var updateurl = '/process/restaurant?p=update';";
  foreach ($restaurant as $row){
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
  $edit_script .= "  $('#TELEPHONE-".$row->ID."').editable({
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
  $edit_script .= "  $('#FAX-".$row->ID."').editable({
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
  $edit_script .= "  $('#ADDRESS_LINE_1-".$row->ID."').editable({
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
  $edit_script .= "  $('#ADDRESS_LINE_2-".$row->ID."').editable({
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
  $edit_script .= "  $('#CITY-".$row->ID."').editable({
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
  $edit_script .= "  $('#POSTAL_CODE-".$row->ID."').editable({
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
  $edit_script .= "  $('#COUNTRY-".$row->ID."').editable({
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
  $edit_script .= "  $('#GEOLOC-".$row->ID."').editable({
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
  $edit_script .= "  $('#CURRENCY-".$row->ID."').editable({    
                        type: 'select',  
                        url: updateurl,
                        pk: ".$row->ID.", 
                        value: '".$row->CURRENCY."', 
                        source: [ ";
    $r = 1; 
    $t = count($currencies);                   
    foreach($currencies as $rowc){      
      $edit_script .= "  {value: '".$rowc->CODE."', text: '".$rowc->VALUE."'}";
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
  $edit_script .= "  $('#SERVICE_CHARGE-".$row->ID."').editable({
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
  
  //inititate datatable
  var table = $('#setting').DataTable({
    columnDefs: [
      { targets: 'no-sort', orderable: false }
    ],
    "order": [[ 17, "desc" ]]
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
            url: "/process/restaurant?p=delete",
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
        email: true,
        remote: "/process/restaurant?p=takene" 
      }, 
      username: {
        required: true,
        minlength: 5,
        remote: "/process/restaurant?p=takenu"
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
      email: {
        required: "Please enter email address.",
        remote: "Please enter another email"
      },
      username: {
        required: "Please enter username.",
        remote: "Please enter another username"
      },
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
