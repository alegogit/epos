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
    <?php //echo "<pre>" . var_dump($this->setting->get_username(1)) . "</pre>";?>  
    <?=form_open('setting/printer')?> 
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
						  <table id="dtable" class="table table-condensed" data-toggle="table" data-url="" data-show-refresh="false" data-show-toggle="false" data-show-columns="true" data-search="true" data-pagination="true" data-sort-name="name" data-sort-order="desc">
						    <thead>
						    <tr>
						        <th data-field="state" data-checkbox="true"></th>
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
                <tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->NAME?>">
                  <td>
                    <input type="checkbox">
                  </td>
                  <td style="">
                    <span id="ename<?=$row->ID?>" class="thedata<?=$row->ID?>"><?=$row->NAME?></span>
                    <input id="name<?=$row->ID?>" type="text" style="display:none;border:none" class="form-control theedit<?=$row->ID?>" placeholder="<?=$row->NAME?>" value="<?=$row->NAME?>">
                  </td>
                  <td style="">
                    <span id="erest<?=$row->ID?>" class="thedata<?=$row->ID?>"><?=$this->printer->get_restaurant_name($row->REST_ID)->REST_NAME?></span>
                    <select id="rest<?=$row->ID?>" name="rest_id" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($restaurants as $rows){ ?>
                      <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$row->REST_ID)?'selected':''?> ><?=$rows->NAME?></option>
                      <?php } ?>
                    </select> 
                  </td>
                  <td style="">  
                    <span id="econn<?=$row->ID?>" class="thedata<?=$row->ID?>"><?=$this->printer->get_connectivity($row->PRINTER_CONNECTION)->VALUE?></span>
                    <select id="conn<?=$row->ID?>" name="conn_code" class="form-control theedit<?=$row->ID?>" style="display:none;border:none">
                      <?php foreach($connectivity as $rowc){ ?>
                      <option value = "<?=$rowc->CODE?>" <?= ($rowc->CODE==$row->PRINTER_CONNECTION)?'selected':''?> ><?=$rowc->VALUE?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td style="">
                    <span id="eip<?=$row->ID?>" class="thedata<?=$row->ID?>"><?=$row->PRINTER_IP_ADDRESS?></span>   
                    <input type="text" id="ip<?=$row->ID?>" name="ip" class="ipv4 form-control theedit<?=$row->ID?>" style="display:none;border:none" placeholder="<?=$row->PRINTER_IP_ADDRESS?>" value="<?=$row->PRINTER_IP_ADDRESS?>">
                  </td>
                  <td style="">       
                    <span id="eport<?=$row->ID?>" class="thedata<?=$row->ID?>"><?=$row->PRINTER_PORT?></span> 
                    <input type="text" id="port<?=$row->ID?>" style="display:none;border:none;width:63px" class="form-control theedit<?=$row->ID?>" value="<?=$row->PRINTER_PORT?>">
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
        <form role="form" method="post" action="">
          <div class="form-group">
            <label for="inputCaption">Printer Name</label>
            <input type="text" class="form-control" id="inputCaption" placeholder="" name="printer_name">
          </div>
          <div class="form-group">
            <label for="inputDate">Restaurant</label><br />                                       
            <div class="col-sm-6">
            <select name="rest_id" class="form-control">
            <?php foreach($restaurants as $rows){ ?>
              <option value = "<?=$rows->REST_ID?>" <?= ($rows->REST_ID==$rest_id)?'selected':''?> ><?=$rows->NAME?></option>
            <?php } ?>
            </select> 
            </div>
          </div><br />
          <div class="form-group">
            <label for="inputDate">Connectivity</label><br />                                       
            <div class="col-sm-6">
            <select name="conn_code" class="form-control">
            <?php foreach($connectivity as $rowc){ ?>
              <option value="<?=$rowc->CODE?>"><?=$rowc->VALUE?></option>
            <?php } ?>
            </select>
            </div>
          </div><br />  
          <div class="form-group">
            <label for="inputCaption">IP Address</label>
            <input type="text" class="form-control ipv4" id="inputCaption" placeholder="" name="IP_address">
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
  			}
  	  });
  		  if(!sel) alert('No data selected');	
  	}
  	return false;
  }); 
  
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
