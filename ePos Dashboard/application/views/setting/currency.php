<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
  
    <div class="btn-group" role="group" aria-label="..." style="margin-top:10px;">
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/restaurant">Restaurant</a>
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/tableorder">Table Order</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/category">Category</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/menu">Menu</a>                 
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/printer">Printer</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/users">Users</a>           
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/tax">Tax</a>               
      <a role="button" class="btn btn-default" href="<?=base_url()?>setting/discounts">Discounts</a>               
      <a role="button" class="btn btn-primary" href="<?=base_url()?>setting/currency">Currency</a>           
    </div>           
                                                                       
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('setting/currency',$attributes)
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
					<div class="panel-heading">
            <b>Select Default Currency</b>  
          </div>
					<div class="panel-body">                
					  <div class="table-responsive">     
						  <table id="setting" class="table table-striped dt-right compact"> 
                <thead>
						    <tr class="tablehead text3D">
						        <th>Code</th>
						        <th>Symbol</th>
						        <th>Description</th>
						        <th>Default</th>
						      </tr>
						    </thead>
						    <tbody>                    
						    <?php $i = 0;  foreach ($currencies as $row){ ?>
                <tr data-index="<?=$i?>" class="datarow" id="<?=$i?>">
                  <td style="">
                    <?=$row->CODE?>
                  </td>
                  <td style="">
                    <b class="gold"><?=$row->VALUE?></b>
                  </td>
                  <td style="">
                    <?=$row->DESCRIPTION?>   
                  </td>
                  <td style="">          
                    <a role="button" class="btn-lg" href="#">
                      <i id="<?=$row->CODE?>" class="set-default fa <?=($row->CODE==$rest_dcurr)?'fa-check-circle':'fa-check-circle-o'?>" data-id="<?=$row->CODE?>" data-csym="<?=$row->VALUE?>" data-rid="<?=$rest_id?>" data-rnm="<?=$rest_name?>"></i>
                    </a>
                  </td>
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
<script>
  $(document).ready(function(){ 
    
    var table = $('#setting').DataTable({
      columnDefs: [
        { targets: 'no-sort', orderable: false }
      ],
      "order": [[ 3, "desc" ]]
    });
  
    $('.set-default').on("click", function(event){
      var currid = $(this).data('id');
      var csymbl = $(this).data('csym');
      var restid = $(this).data('rid');
      var rsname = $(this).data('rnm');
      var c = confirm('Set '+csymbl+ ' as default currency for '+rsname+'?');
      if(c){
        var dataP = "curr_cd="+currid+"&rest_id="+restid;
  			$.ajax({
          type: "POST",
          url: "/setting/currency",
          data: dataP,
          cache: false,
          success: function(data) {
            $('.fa-check-circle').removeClass('fa-check-circle').addClass('fa-check-circle-o');
            $('#'+currid).removeClass('fa-check-circle-o').addClass('fa-check-circle');
          }
        }); 
      }
    });
  });
</script>