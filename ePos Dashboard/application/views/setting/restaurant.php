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
              <span class="glyphicon glyphicon-plus"></span> Add New Restaurant
            </button>             
            <button type="button" class="btn btn-danger">
              <span class="glyphicon glyphicon-remove"></span> Delete Selected Restaurant(s)
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
						        <!--<th>Geo Location</th>-->
						        <th>Email Address</th>
						        <th>Currency</th>
						        <th>Service Charge</th>
						        <!--<th>Order No. Start</th>-->
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
                    <?php if ($role==1){ ?>
                    <a id="NAME__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
                    <?php } else { ?>                                                        
                    <span id="NAME__<?=$row->ID?>" tabindex="0"><?=$row->NAME?></span>
                    <?php } ?>
                  </td>
                  <td style="">
                    <a id="TELEPHONE__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->TELEPHONE?></a>
                  </td>
                  <td style="">
                    <a id="FAX__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->FAX?></a>
                  </td>
                  <td style="">
                    <a id="ADDRESS_LINE_1__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->ADDRESS_LINE_1?></a>
                  </td>
                  <td style="">
                    <a id="ADDRESS_LINE_2__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->ADDRESS_LINE_2?></a>
                  </td>             
                  <td style="">
                    <a id="CITY__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->CITY?></a>
                  </td>
                  <td style="">
                    <a id="POSTAL_CODE__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->POSTAL_CODE?></a>
                  </td>
                  <td style="">
                    <a id="COUNTRY__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->COUNTRY?></a>
                  </td>
                  <!--<td style="">
                    <a id="GEOLOC__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->GEOLOC?></a>
                  </td>-->
                  <td style="">
                    <a id="EMAIL_ADDRESS__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->EMAIL_ADDRESS?></a>
                  </td>
                  <td style="">
                    <a id="CURRENCY__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->CURRENCY_NAME?></a>
                  </td>
                  <td style="">
                    <a id="SERVICE_CHARGE__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->SERVICE_CHARGE?></a>
                  </td>
                  <!--<td style="">
                    <a id="ORDER_NUMBER_START__<?=$row->ID?>" class="edit" tabindex="0"><?=$row->ORDER_NUMBER_START?></a>
                  </td>-->
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

<?php if ($role == 1) { ?>
<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Add New Restaurant</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">  <div id="errmsg"></div>
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newresto', 'role' => 'form');
        echo form_open('setting/restaurant',$attributes)
      ?>                    		
        <div class="form-group" style="margin-bottom:10px">                                         
          <label for="name"></label><br>
          <div class="input-group">       
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <input type="text" class="form-control" id="name" placeholder="Restaurant Name" name="name" required>                                                                                                          
            <span class="errmsg"></span> 
          </div>  
        </div><br />           
        <div class="form-group" style="margin-bottom:10px">
          <label for="telephone"></label><br> 
          <div class="input-group">              
            <div class="input-group-addon"><span class="glyphicon glyphicon-phone-alt"></span></div>
            <input type="text" class="form-control" id="telephone" placeholder="Telephone" name="telephone" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">     
          <label for="FAX"></label><br>
          <div class="input-group">                                                                        
            <div class="input-group-addon"><span class="fa fa-fax"></span></div>
            <input type="text" class="form-control" id="FAX" placeholder="FAX" name="FAX" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="address1"></label><br>
          <div class="input-group">                                                                                                
            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
            <input type="text" class="form-control" id="address1" placeholder="Address Line 1" name="address1" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="address2"></label><br>
          <div class="input-group">                                                                                                
            <div class="input-group-addon"><span class="glyphicon glyphicon-home"></span></div>
            <input type="text" class="form-control" id="address2" placeholder="Address Line 2" name="address2" required>
            <span class="errmsg"></span>
          </div>
        </div><br />	
        <div class="form-group" style="margin-bottom:10px">
          <label for="city"></label><br>
          <div class="input-group">                                                                                                
            <div class="input-group-addon"><span class="fa fa-building"></span></div>
            <input type="text" class="form-control" id="city" placeholder="City" name="city" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="postalcode"></label><br>                         
          <div class="input-group">                                                          
            <div class="input-group-addon"><span class="fa fa-envelope"></span></div>
            <input type="text" class="form-control" id="postalcode" placeholder="Postal Code" name="postalcode" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px">
          <label for="country"></label><br>                                      
          <div class="input-group">                                     
            <div class="input-group-addon"><span class="fa fa-flag"></span></div>
            <input type="text" class="form-control" id="country" placeholder="Country" name="country" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="geoloc"></label><br>                             
          <div class="input-group">                           
            <div class="input-group-addon"><span class="fa fa-globe"></span></div>
            <input type="text" class="form-control" id="geoloc" placeholder="Geo Location" name="geoloc" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="email"></label><br>                   
          <div class="input-group">                                              
            <div class="input-group-addon"><span class="fa fa-envelope-o"></span></div>
            <input type="text" class="form-control" id="email" placeholder="E-mail Address" pattern="__([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$" name="email" required>
            <span class="errmsg"></span>
          </div>
        </div><br />
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="currency"></label><br>                                     
          <div class="input-group">                                        
            <div class="input-group-addon"><span class="fa fa-money"></span></div>
            <select name="currency" id="currency" class="form-control" title="Select Default Currency">
            <?php foreach($currencies as $rowc){ ?>
              <option value="<?=$rowc->CODE?>"><?=$rowc->VALUE?></option>
            <?php } ?>
            </select>
            <span class="errmsg"></span>
          </div>
        </div><br />        		
        <div class="form-group" style="margin-bottom:10px"> 
          <label for="service"></label><br>
          <div class="input-group">                            
            <div class="input-group-addon"><span class="fa fa-star"></span></div>
            <input type="text" class="form-control" id="service" placeholder="Service Charge" name="service" required>
            <span class="errmsg"></span>
          </div>
        </div><br />     				
        <!--<div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="orderns">Order No. Start</label>
            <input type="text" class="form-control" id="orderns" placeholder="" name="orderns" required>
            <span class="errmsg"></span>
          </div>
        </div><br />-->     		
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
<?php } ?>

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
  if($role==1){
  $edit_script .= "  $('#NAME__".$row->ID."').editable({
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
  }
  $edit_script .= "  $('#TELEPHONE__".$row->ID."').editable({
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
  $edit_script .= "  $('#FAX__".$row->ID."').editable({
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
  $edit_script .= "  $('#ADDRESS_LINE_1__".$row->ID."').editable({
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
  $edit_script .= "  $('#ADDRESS_LINE_2__".$row->ID."').editable({
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
  $edit_script .= "  $('#CITY__".$row->ID."').editable({
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
  $edit_script .= "  $('#POSTAL_CODE__".$row->ID."').editable({
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
  $edit_script .= "  $('#COUNTRY__".$row->ID."').editable({
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
  /*
  $edit_script .= "  $('#GEOLOC__".$row->ID."').editable({
                        url: updateurl,
                        pk: ".$row->ID.", 
                        activate: 'focus',
                        validate: function(v) {
                          if (!v) return 'don\'t leave it blank!';  
                          if (!isGeoLoc(v)) return 'please fill in a Geo Location format!';
                        },
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                      } 
                    });";
  */
  $edit_script .= "  $('#EMAIL_ADDRESS__".$row->ID."').editable({
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
  $edit_script .= "  $('#CURRENCY__".$row->ID."').editable({    
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
  $edit_script .= "  $('#SERVICE_CHARGE__".$row->ID."').editable({
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
    "order": [[ 15, "desc" ]]
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
  $("#newresto").validate({ 
    rules: {
      email: { 
        email: true,
        remote: "/process/restaurant?p=takene" 
      }, 
      name: {
        required: true,
        minlength: 3,
        remote: "/process/restaurant?p=takenu"
      },
      telephone: { 
        minlength: 6 
      }, 
      FAX: {       
        minlength: 6
      },       
      service: {       
        number: true
      }       
    },
    messages:{ 
      name: {
        required: "Please enter restaurant name.",
        remote: "Please enter another restaurant name"   
      },
      email: {
        required: "Please enter email address.",
        remote: "Please enter another email"   
      }
    },
    errorElement: "span",   
    errorPlacement: function(error, element) {
      error.insertAfter(element);
    } 
  });
});
  
function isEmail(email) {
  var regex = /__([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}  

function isGeoLoc(geoloc) {
  var regex = /^(-?\d{1,2}\.\d{6}),(-?\d{1,3}\.\d{6})$/;
  return regex.test(geoloc);
}  

</script>
