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
			  <button style="margin-top:-5px;" type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#bookModal">
          <span class="glyphicon glyphicon-plus"></span> Add New Printer  
        </button>                                                                    
        <hr style="margin-top:5px;margin-bottom:10px" />
				<div class="panel panel-default">
					<div class="panel-heading">
            <b>Printer Setting</b>
            <!--<button class="btn btn-primary pull-right" style="display:inline-block">Add New Record</button>-->
          </div>
					<div class="panel-body">
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
                  <td style="">   <a href="#" id="username" data-type="text" data-placement="right" data-title="Enter username">superuser</a>
                    <span class="thedata<?=$row->ID?>"><?=$row->NAME?></span>
                    <input type="text" style="display:none;border:none" class="theedit<?=$row->ID?>" placeholder="<?=$row->NAME?>">
                  </td>
                  <td style="">
                    <span class="thedata<?=$row->ID?>"><?=$this->setting->get_restaurant_name($row->REST_ID)->REST_NAME?></span>
                    <select id = "myRestaurant" name="rest_id" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($restaurants as $rows){ ?>
                      <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$row->REST_ID)?'selected':''?> ><?=$rows->NAME?></option>
                      <?php } ?>
                    </select> 
                  </td>
                  <td style="">
                    <select id = "myConnectivity" name="conn_code" class="form-control" style="display:inline;border:none">
                      <?php foreach($connectivity as $rowc){ ?>
                      <option value = "<?=$rowc->CODE?>" <?= ($rowc->CODE==$row->PRINTER_CONNECTION)?'selected':''?> ><?=$rowc->VALUE?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td style=""><?=$row->PRINTER_IP_ADDRESS?></td>
                  <td style="">
                    <input type="text" style="border:none;width:35px" class="textedit" value="<?=$row->PRINTER_PORT?>">
                  </td>
                  <td style=""><?=$this->setting->get_username($row->CREATED_BY)->USERNAME?></td>
                  <td style=""><?=$row->CREATED_DATE?></td>
                  <td style=""><?=$this->setting->get_username($row->LAST_UPDATED_BY)->USERNAME?></td>
                  <td style=""><?=$row->LAST_UPDATED_DATE?></td>
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
$(document).ready(function() {
    //toggle `popup` / `inline` mode
    $.fn.editable.defaults.mode = 'inline';     
    
    //make username editable
    $('#username').editable();
    
    //make status editable
    $('#status').editable({
        type: 'select',
        title: 'Select status',
        placement: 'right',
        value: 2,
        source: [
            {value: 1, text: 'status 1'},
            {value: 2, text: 'status 2'},
            {value: 3, text: 'status 3'}
        ]
        /*
        //uncomment these lines to send data on server
        ,pk: 1
        ,url: '/post'
        */
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
