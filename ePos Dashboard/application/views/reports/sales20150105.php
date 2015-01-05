<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-primary" href="/reports/sales">&nbsp;&nbsp;Sales&nbsp;&nbsp;</a>
      <a role="button" class="btn btn-default" href="/reports/inventory">Inventory</a>         
    </div>                                                                       
    <hr style="margin-bottom:10px;margin-top:10px" />         
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('reports/sales',$attributes)
      ?>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            <input id="startdate" name="startdate" type="text" value="<?=$startdate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="Start Date">
          </div>                                                                                                                                                              
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">       
            <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            <input id="enddate" name="enddate" type="text" value="<?=$enddate?>" class="form-control datepicker" style="display:inline;padding-left:10px;padding-right:-20px" title="End Date">
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-cutlery"></span></div>
            <select id = "myRestaurant" name="rest_id" title="Restaurant Name" class="form-control" style="display:inline">
              <option value = "0">ALL Restaurants</option>
              <?php foreach($restaurants as $row){ ?>
              <option value = "<?=$row->REST_ID?>" <?= ($row->REST_ID==$rest_id)?'selected':''?> ><?=$row->NAME?></option>
              <?php } ?>
            </select>   
          </div>
        </div>
        <div class="form-group" style="margin-bottom:0px">
          <div class="input-group">
            <div class="input-group-addon"><span class="glyphicon glyphicon-file"></span></div>
            <select id = "repch" name="report_name" title="Choose Report" class="form-control" style="display:inline">
              <option value = "0">Choose Report</option>
              <option value = "Sales" <?=($report_name=='Sales')?'selected':''?>>Sales</option>
              <option value = "Void Items" <?=($report_name=='Void Items')?'selected':''?>>Void Items</option>
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
        
	  <div class="panel panel-default">
		    <div class="panel-heading">
          <b><?=$report_name?> Report</b>  
        </div>
	      <div class="panel-body table-responsive">
	       <?php if($report_name!="Sales"){?>   
	        <table id="report" class="table table-striped" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					  <thead>
						  <tr>
						    <th data-field="state" data-checkbox="true" >Void ID</th>
						    <th data-field="name" data-sortable="true">Menu Name</th>
						    <th data-field="rson"  data-sortable="true">Void Reason</th>
						    <th data-field="onum" data-sortable="true">Order Number</th>
						    <th data-field="strd" data-sortable="true">Started</th>
						    <th data-field="endd"  data-sortable="true">Ended</th>
						  </tr>
						</thead>
						<tbody>           
						  <?php $i = 0;  foreach ($void_items as $row){ ?>
						  <tr>
						    <td data-field="state" data-checkbox="true" ><?=$i?></td>
						    <td data-field="name" data-sortable="true"><?=$row->NAME?></td>
						    <td data-field="rson"  data-sortable="true"><?=$row->VOID_REASON?></td>
						    <td data-field="onum" data-sortable="true"><?=$row->ORDER_NUMBER?></td>
						    <td data-field="strd" data-sortable="true"><?=$row->STARTED?></td>
						    <td data-field="endd"  data-sortable="true"><?=$row->ENDED?></td>
						  </tr>
						  <?php $i++; } ?>
						</tbody>
					</table>
				<?php } else {?>  
	         <table id="report" class="table table-striped" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
					   <thead>
						  <tr>
						    <th data-field="state" data-checkbox="true">Order ID</th>
						    <th data-field="name" data-sortable="true">Order Number</th>
						    <th data-field="rest"  data-sortable="true">Table Number</th>
						    <th data-field="conn" data-sortable="true">Customer</th>
						    <th data-field="ip" data-sortable="true">Started</th>
						    <th data-field="port"  data-sortable="true">Ended</th>
						    <th data-field="crby" data-sortable="true">Num Of Guest</th>
						    <th data-field="crdt" data-sortable="true">Total</th>
						    <th data-field="crdt" data-sortable="true">Tip</th>
						    <th data-field="crdt" data-sortable="true">Discount</th>
						    <th data-field="upby"  data-sortable="true">Paid Amount</th>
						  </tr>
						</thead>
						<tbody>   
						  <?php $i = 0;  foreach ($sales_report as $row){ ?>
						  <tr>
						    <td data-field="state" data-checkbox="true" ><?=$row->ID?></td>
						    <td data-field="name" data-sortable="true" data-valign="center">
                  <a href="#" style="font-size:90%" class="label label-lg label-success modalTrigger" data-toggle="modal" data-target="#bookModal" data-id="<?=$row->ID?>" data-odn="<?=$row->ORDER_NUMBER?>">
                    <?=$row->ORDER_NUMBER?>
                  </a>  
                </td>
						    <td data-field="rest"  data-sortable="true"><?=$row->TABLE_NUMBER?></td>
						    <td data-field="conn" data-sortable="true"><?=$row->CUSTOMER_NAME?></td>
						    <td data-field="ip" data-sortable="true"><?=$row->STARTED?></td>
						    <td data-field="port"  data-sortable="true"><?=$row->ENDED?></td>
						    <td data-field="crby" data-sortable="true"><?=$row->NO_OF_GUEST?></td>
						    <td data-field="crdt" data-sortable="true"><?=$row->TOTAL?></td>
						    <td data-field="crdt" data-sortable="true"><?=$row->TIP?></td>
						    <td data-field="crdt" data-sortable="true"><?=$row->DISCOUNT?></td>
						    <td data-field="upby"  data-sortable="true"><?=$row->PAID_AMOUNT?></td>
						  </tr>
						  <?php $i++; } ?>
						</tbody>
					</table> 
				<?php } ?>
			  </div>
			</div>
		</div>
    <!-- FOOTER -->
    <hr class="featurette-divider" />
    
    <footer>
      <p class="pull-right">
        <a href="#">Back to top <span class="glyphicon glyphicon-circle-arrow-up"></span></a>
      </p>
	</footer>
  
  </div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<?php if($report_name=="Sales"){?>
<!-- Modal -->
<div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="ordnumb"></span> Order Detail List</h4>
      </div><!-- /.modal-header -->
      <div class="modal-body">    	 	 	 	 	
        <table data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="false" data-search="false" data-select-item-name="toolbar1" data-pagination="false" data-sort-name="name" data-sort-order="desc">
					  <thead>
						  <tr>
						    <th data-field="numb" data-checkbox="false">No</th>
						    <th data-field="name" data-sortable="false">Name</th>
						    <th data-field="rson" data-sortable="false">Quantity</th>
						    <th data-field="onum" data-sortable="false">Kitchen Note</th>
						    <th data-field="strd" data-sortable="false">Price</th>
						    <th data-field="endd" data-sortable="false">Void</th>
						    <th data-field="endd" data-sortable="false">Void Reason</th>
						  </tr>
						</thead>
						<tbody id="datarow">  
						</tbody>
					</table>
        </form>
      </div><!-- /.modal-body -->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal fade -->
<?php } ?>

<script type="text/javascript">      
  //datepickers    
  $("#startdate").datepicker({format: 'dd M yyyy'});
  $("#enddate").datepicker({format: 'dd M yyyy'});
  
  var gOrdDet = function gOrdDet(){
       $(".modalTrigger").click(function () { 
        var odnP = $(this).data('odn');   
        $(".modal-title #ordnumb").html(odnP);
        var varP = $(this).data('id');  
        var dataP = "varP="+varP;  
        $.ajax({
          type: "POST",
          url: "/process/orders",
          data: dataP,
          cache: false,
          success: function(result){
            $(".modal-body #datarow").html(result); 
            return false; 
          }
        }); 
       });
    }; 
  
  $(document).ready(function(){
    gOrdDet();  
    $('#report').bootstrapTable({
      onAll: function (name, args) {
        if (typeof gOrdDet == 'function') { 
          gOrdDet(); 
          console.log('inside fired');
        }
      }
    }).on('all.bs.table', function (e, name, args) { 
        if (typeof gOrdDet == 'function') { 
          gOrdDet();     
          console.log('triggered');
        }
      console.log('Event:', name, ', data:', args);
    }).trigger( "gOrdDet" ); 
  });
  
  $(function () { 
  });
  
</script>
