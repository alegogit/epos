<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="?p=restaurant">Restaurant</a>
      <a role="button" class="btn btn-default" href="?p=tableorder">Table Order</a>               
      <a role="button" class="btn btn-default" href="?p=category">Category</a>               
      <a role="button" class="btn btn-default" href="?p=menu">Menu</a>                 
      <a role="button" class="btn btn-primary" href="?p=printer">Printer</a>               
      <a role="button" class="btn btn-default" href="?p=users">Users</a>           
      <a role="button" class="btn btn-default" href="?p=tax">Tax</a>               
      <a role="button" class="btn btn-default" href="?p=discounts">Discounts</a>               
      <a role="button" class="btn btn-default" href="?p=currency">Currency</a>         
    </div>                                                                              
    <hr style="margin-bottom:10px" />
    <?php //echo "<pre>" . var_dump($this->setting->get_username(1)) . "</pre>";?>
    <div class="row">
			<div class="col-lg-12">
			  <!--<button style="margin-top:-5px;" type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#bookModal">
          <span class="glyphicon glyphicon-plus"></span> Add New Printer  
        </button>                                                                    
        <hr style="margin-top:5px;margin-bottom:10px" />-->
				<div class="panel panel-default">
					<div class="panel-heading">
            <b>Printer Setting</b>  
            <!--<button class="btn btn-primary pull-right" style="display:inline-block">Add New Record</button>-->
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
						<table data-toggle="table" data-url=""  data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="state" data-checkbox="true" >Printer ID</th>
						        <th data-field="name" data-sortable="true">Printer Name</th>
						        <th data-field="rest"  data-sortable="true">Restaurant</th>
						        <th data-field="conn" data-sortable="true">Connectivity</th>
						        <th data-field="ip" data-sortable="true">IP Address</th>
						        <th data-field="port"  data-sortable="true">Port</th>
						        <th data-field="crby" data-sortable="true">Created By</th>
						        <th data-field="crdt" data-sortable="true">Created Date</th>
						        <th data-field="upby"  data-sortable="true">Updated By</th>
						        <th data-field="updt" data-sortable="true">Updated Date</th>
						    </tr>
						    </thead>
						    <tbody>                    
						    <?php $i = 0;  foreach ($printer_conf as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID?>">
                  <td class="bs-checkbox">
                    <input type="checkbox" name="toolbar<?=$i?>" data-index="<?=$row->ID?>">
                  </td>
                  <td style="">
                    <span class="thedata<?=$row->ID?>"><?=$row->NAME?></span>
                    <input id="name<?=$row->ID?>" type="text" style="display:none;border:none" class="form-control theedit<?=$row->ID?>" placeholder="<?=$row->NAME?>" value="<?=$row->NAME?>">
                  </td>
                  <td style="">
                    <span class="thedata<?=$row->ID?>"><?=$this->setting->get_restaurant_name($row->REST_ID)->REST_NAME?></span>
                    <select id="rest<?=$row->ID?>" name="rest_id" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($restaurants as $rows){ ?>
                      <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$row->REST_ID)?'selected':''?> ><?=$rows->NAME?></option>
                      <?php } ?>
                    </select> 
                  </td>
                  <td style="">  
                    <span class="thedata<?=$row->ID?>"><?=$this->setting->get_connectivity($row->PRINTER_CONNECTION)->VALUE?></span>
                    <select id="conn<?=$row->ID?>" name="conn_code" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($connectivity as $rowc){ ?>
                      <option value = "<?=$rowc->CODE?>" <?= ($rowc->CODE==$row->PRINTER_CONNECTION)?'selected':''?> ><?=$rowc->VALUE?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td style="">
                    <span class="thedata<?=$row->ID?>"><?=$row->PRINTER_IP_ADDRESS?></span>   
                    <input type="text" id="ip<?=$row->ID?>" name="ip" class="ipv4 form-control theedit<?=$row->ID?>" style="display:none;border:none" placeholder="<?=$row->PRINTER_IP_ADDRESS?>" value="<?=$row->PRINTER_IP_ADDRESS?>">
                  </td>
                  <td style="">       
                    <span class="thedata<?=$row->ID?>"><?=$row->PRINTER_PORT?></span> 
                    <input type="text" id="port<?=$row->ID?>" style="display:none;border:none;width:63px" class="form-control theedit<?=$row->ID?>" value="<?=$row->PRINTER_PORT?>">
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
        <form role="form">
          <div class="form-group">
            <label for="bookId">Booking ID -</label> <span class="text-disabled">A108</span>
          </div>

          <div class="form-group">
            <label for="inputCaption">Printer Name</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="" name="printer_name">
          </div>
          <div class="form-group">
            <label for="inputDate">Restaurant</label><br />                                       
            <div class="col-sm-6">
            <select name="timeFrom" class="btn btn-default">
              <option>TEST1</option>
              <option>TEST1</option>
              <option>TEST1</option>
            </select> 
            </div>
          </div><br />
          <div class="form-group">
            <label for="inputDate">Connectivity</label><br />                                       
            <div class="col-sm-6">
            <select name="timeFrom" class="btn btn-default">
              <option>WIFI</option>
              <option>WIFI</option>
              <option>WIFI</option>
            </select> 
            </div>
          </div><br />  
          <div class="form-group">
            <label for="inputCaption">IP Address</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="" name="IP1">
          </div>
          <div class="form-group">
            <label for="inputCaption">Port</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="" name="Port">
          </div>
          <div class="form-group text-right">
            <button type="submit" class="btn btn-success">Submit</button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->

<script>
$(document).ready(function()
{ 
  $(".datarow").click(function(){
    var idr = $(this).attr("id");
    $(".thedata"+idr).hide();
    $(".theedit"+idr).show();
  }).change(function(){ 
    var idr = $(this).attr("id"); 
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
          $("#updt"+idr).html(result);
        }
      }); 
    });
  }); 
});

  
  $(".edit_tr").click(function(){
    var ID=$(this).attr('id');
    $("#first_"+ID).hide();
    $("#last_"+ID).hide();
    $("#first_input_"+ID).show();
    $("#last_input_"+ID).show();
  }).change(function(){
    var ID=$(this).attr('id');
    var first=$("#first_input_"+ID).val();
    var last=$("#last_input_"+ID).val();
    var dataString = 'id='+ ID +'&firstname='+first+'&lastname='+last;
    $("#first_"+ID).html('<img src="load.gif" />'); // Loading image

    if(first.length>0&& last.length>0){
      $.ajax({
        type: "POST",
        url: "table_edit_ajax.php",
        data: dataString,
        cache: false,
        success: function(html){
          $("#first_"+ID).html(first);
          $("#last_"+ID).html(last);
        }
      });
    } else {
      alert('Enter something.');
    }
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
