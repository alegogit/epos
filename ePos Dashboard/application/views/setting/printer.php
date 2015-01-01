<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="/setting/restaurant">Restaurant</a>
      <a role="button" class="btn btn-default" href="/setting/tableorder">Table Order</a>               
      <a role="button" class="btn btn-default" href="/setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="/setting/menu">Menu</a>                 
      <a role="button" class="btn btn-primary" href="/setting/printer">Printer</a>               
      <a role="button" class="btn btn-default" href="/setting/users">Users</a>           
      <a role="button" class="btn btn-default" href="/setting/tax">Tax</a>               
      <a role="button" class="btn btn-default" href="/setting/discounts">Discounts</a>               
      <a role="button" class="btn btn-default" href="/setting/currency">Currency</a>      
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
					  <div class="table-responsive">     
						  <table id="dtable" class="table table-condensed" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="updt" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="state" data-checkbox="true"></th>
						        <th data-field="name" data-sortable="false">Printer Name</th>
						        <th data-field="rest"  data-sortable="false">Restaurant</th>
						        <th data-field="conn" data-sortable="false">Connectivity</th>
						        <th data-field="ip" data-sortable="false">IP Address</th>
						        <th data-field="port"  data-sortable="false">Port</th>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th>
						    </tr>
						    </thead>
						    <tbody>                    
						    <?php $i = 0;  foreach ($printer_conf as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->NAME?>">
                  <td>
                    <input type="checkbox">
                  </td>
                  <td style="">
                    <a id="NAME-<?=$row->ID?>" class=""><?=$row->NAME?></a>
                  </td>
                  <td style="">
                    <a id="REST_ID-<?=$row->ID?>" class=""><?=$this->printer->get_restaurant_name($row->REST_ID)->REST_NAME?></a>
                  </td>
                  <td style="">  
                    <a id="PRINTER_CONNECTION-<?=$row->ID?>" class=""><?=$this->printer->get_connectivity($row->PRINTER_CONNECTION)->VALUE?></a>
                    <select id="conn<?=$row->ID?>" name="conn_code" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($connectivity as $rowc){ ?>
                      <option value = "<?=$rowc->CODE?>" <?= ($rowc->CODE==$row->PRINTER_CONNECTION)?'selected':''?> ><?=$rowc->VALUE?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td style="">
                    <a id="PRINTER_IP_ADDRESS-<?=$row->ID?>" data-inputclass="ipv4" data-type="text"><?=$row->PRINTER_IP_ADDRESS?></a>   
                  </td>
                  <td style="">       
                    <a id="PRINTER_PORT-<?=$row->ID?>" class=""><?=$row->PRINTER_PORT?></a> 
                  </td>
                  <td style=""><span id="crby<?=$row->ID?>"><?=$this->printer->get_username($row->CREATED_BY)->USERNAME?></span></td>
                  <td style=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
                  <td style=""><span id="upby<?=$row->ID?>"><?=$this->printer->get_username($row->LAST_UPDATED_BY)->USERNAME?></span></td>
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
        <h4 class="modal-title" id="myModalLabel">Add New Printer</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'newprinter', 'role' => 'form');
        echo form_open('setting/printer',$attributes)
      ?>
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="inputCaption">Printer Name</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="" name="printer_name">
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px"> 
          <div class="input-group">       
            <label for="inputDate">Restaurant</label><br /> 
            <select name="rest_id" class="form-control">
            <?php foreach($restaurants as $rows){ ?>
              <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$rest_id)?'selected':''?> ><?=$rows->NAME?></option>
            <?php } ?>
            </select>
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px">
          <div class="input-group">       
            <label for="inputDate">Connectivity</label><br />  
            <select name="conn_code" class="form-control">
            <?php foreach($connectivity as $rowc){ ?>
              <option value="<?=$rowc->CODE?>"><?=$rowc->VALUE?></option>
            <?php } ?>
            </select>
          </div>
        </div><br />   
        <div class="form-group" style="margin-bottom:10px">
          <div class="input-group">       
            <label for="inputCaption">IP Address</label>
            <input type="text" class="form-control ipv4" id="inputCaption" placeholder="" name="IP_address">
          </div>
        </div><br /> 
        <div class="form-group" style="margin-bottom:10px">  
          <div class="input-group">       
            <label for="inputCaption">Port</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="" name="Port">
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
  foreach ($printer_conf as $row){
  $edit_script .= "  $('#NAME-".$row->ID."').editable({
                        url: '/process/printer?p=update',
                        pk: ".$row->ID.",
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                      } 
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
                        url: '/process/printer?p=update',
                        pk: ".$row->ID.",
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                        }  
                      });";
  $edit_script .= "  $('#PRINTER_CONNECTION-".$row->ID."').editable({
                        type: 'select',  
                        value: '".$row->PRINTER_CONNECTION."', 
                        source: [ ";
    $k = 1;
    $q = count($connectivity);
    foreach($connectivity as $rowc){
      $edit_script .= "  {value: '".$rowc->CODE."', text: '".$rowc->VALUE."'}";
      $edit_script .= ($k<$q)?", ":"";
      $k++;
    }
  $edit_script .= "    ],
                        url: '/process/printer?p=update',
                        pk: ".$row->ID.",
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                        }  
                      });";
  $edit_script .= "  $('#PRINTER_IP_ADDRESS-".$row->ID."').editable({
                        display: function() {
                          $('ipv4').ipAddress();
                        },
                        url: '/process/printer?p=update',
                        pk: ".$row->ID.",
                        success: function(result){  
                          var data = result.split(',');
                          $('#upby".$row->ID."').html(data[0]);
                          $('#updt".$row->ID."').html(data[1]); 
                        }  
                      }).addClass('ipv4');";
  $edit_script .= "  $('#PRINTER_PORT-".$row->ID."').editable({
                        url: '/process/printer?p=update',
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
  //function to delete selected row
  $('.btn-danger').on("click", function(event){
  	var sel = false;	
  	var ch = $('#dtable').find('tbody input[type=checkbox]');
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
  				$this.parents('tr').fadeOut(function(){
  					$this.remove(); //remove row when animation is finished
  				});     
          var idf = $(this).parents('tr').attr('id');
          var dataP = "idf="+idf;
  				$.ajax({
            type: "POST",
            url: "/process/printer?p=delete",
            data: dataP,
            cache: false,
            success: function(result){  
            }
          });   
  			}
  	  });
  		  if(!sel) alert('No data selected');	
  	}
  	return false;
  }); 
  
  
  /*
  $(".datarow").click(function(){
    var idf = $(this).attr("id");  
    var idr = idf.substring(0,idf.indexOf('_'));
    $(".thedata"+idr).hide();
    $(".theedit"+idr).show();
  }).change(function(){ 
    var idf = $(this).attr("id");   
    var idr = idf.substring(0,idf.indexOf('_'));
    var name = $("#name"+idr).val(); 
    var rest = $("#rest"+idr).val();
    var conn = $("#conn"+idr).val();
    var ip = $("#ip"+idr).val();
    var port = $("#port"+idr).val();
    var upby = $("#upby"+idr);
    var updt = $("#updt"+idr);    
    var todt = new Date();
    var dataP = "varP="+idr+","+name+","+rest+","+conn+","+ip+","+port+"&funP=update_printer"; 
    $(".subch").show();
    $(".subch").click(function(){ 
      $.ajax({
        type: "POST",
        url: "process.html",
        data: dataP,
        cache: false,
        success: function(result){    
          $(".thedata"+idr).toggle();
          $(".theedit"+idr).toggle();
          var data = result.split(',');
          $("#ename"+idr).html(data[1]);
          $("#erest"+idr).html(data[2]);
          $("#econn"+idr).html(data[3]);
          $("#eip"+idr).html(data[4]);
          $("#eport"+idr).html(data[5]);
          $("#upby"+idr).html(data[6]);
          $("#updt"+idr).html(data[7]); 
        }
      });   
      $(".subch").hide();
      return false;
    });
  }); 
  */
  
});
  
  // Edit input box click action
  $(".editbox").mouseup(function(){
    return false
  });
  // Outside click action
  $(document).mouseup(function(){
    $(".editbox").hide();
    $(".text").show();
  });
</script>
