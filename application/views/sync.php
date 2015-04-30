<div id="page-content-wrapper">
<!-- Page Content -->
  <div class="container-fluid" style="font-size:90%;">
                                       
    <hr style="margin-bottom:10px" />
    
    <div class="row" style="padding-left: 15px">  
      <?php
        $attributes = array('class' => 'form-inline', 'id' => 'filter', 'role' => 'form');
        echo form_open('sync',$attributes)
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
				<div class="panel-heading"><b>Sync History</b></div>
				<div class="panel-body"> 
            		<div class="table-responsive">
						<table id="sync" class="table table-striped dt-right compact">
						    <thead>
						    <tr class="tablehead text3D">
						        <th class="no-sort"><input type="checkbox" id="checkall" value="Check All"></th>
						        <th>Device</th>
						        <th>Last Sync</th>  
                  <?php if ($role==1){ ?>
						        <th data-field="crby" data-sortable="false">Created By</th>
						        <th data-field="crdt" data-sortable="false">Created Date</th>
						        <th data-field="upby"  data-sortable="false">Updated By</th>
						        <th data-field="updt" data-sortable="false">Updated Date</th> 
                  <?php } ?>
						    </tr>
						    </thead>  
						    <tbody>                    
						    <?php $i = 0;  foreach ($synchist as $row){ ?>
                			<tr data-index="<?=$i?>" class="datarow" id="<?=$row->ID.'_'.$row->PLAY_SERVICE_ID?>"> 
          			        	<td class="">
                            <input type="checkbox" class="case" tabindex="-1">
          			          </td>
			                  	<td class="">
			                    	<a id="NAME-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->NAME?></a>
			                  	</td>
			                  	<td class="">
			                    	<a id="LAST_SYNC-<?=$row->ID?>" class="edit" tabindex="0"><?=$row->LAST_SYNC?></a>
			                  	</td> 
                  <?php if ($role==1){ ?>
			                  	<td class=""><span id="crby<?=$row->ID?>"><?=$this->sync->get_username($row->CREATED_BY)->NAME?></span></td>
			                  	<td class=""><span id="crdt<?=$row->ID?>"><?=$row->CREATED_DATE?></span></td>
			                  	<td class=""><span id="upby<?=$row->ID?>"><?=$this->sync->get_username($row->LAST_UPDATED_BY)->NAME?></span></td>
			                  	<td class=""><span id="updt<?=$row->ID?>"><?=$row->LAST_UPDATED_DATE?></span></td>
                  <?php } ?>
			                </tr>
			                <?php $i++; } ?>
						    </tbody>
						</table>
					</div><!--/.table-responsive--> 
				</div><!--/.panel-body-->
			</div><!--/.panel-->
		</div><!--/.col-lg-12-->
	</div><!--/.row-->       
	                                
    <hr style="margin-bottom:10px;margin-top:10px" />
	
	<div class="row" style="padding-left: 15px">
		<a id="syncer" class="btn btn-lg btn-success" href="#syncer"><i class="fa fa-refresh"></i> Sync Now</a>
	</div>
	
	<div id="gcmresp" class="alert alert-info alert-dismissable" style="margin-top:10px;display:none;"> 
    <a class="panel-close close" data-dismiss="alert">x</a>
    <span id="syncout"></span>
	</div>
  
  <hr style="margin-bottom:10px;margin-top:10px" />
  
</div><!-- /.container-fluid -->
</div><!-- /#page-content-wrapper -->

<div id="baseurl" data-url="<?=base_url()?>"></div>
<div id="restid" data-id="<?=$rest_id?>"></div>
<script>   
$(document).ready(function(){     
	var baseurl = $("#baseurl").data('url'); 
	var restid = $("#restid").data('id');   
  
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
  
  //sync
  $("#syncerly").click(function(){
    var dataP = "restid="+restid;
    $.ajax({
      type: "POST",
      url: baseurl+"sync/exec",
	  data: dataP,
      cache: false,
      success: function(result){
        $("#gcmresp").show(); 
        if(result.trim()!=''){    
          $("#syncout").html(startTyping(result,35, "syncout")); 
        } else {    
          $("#syncout").html('eek');
        }   
      }
    });   
  });
  	
  //typer
  //startTyping(text, 50, "syncout");
  	
  	//inititate datatable
  	var table = $('#sync').DataTable({
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
  	$('#syncer').on("click", function(event){
  		var sel = false;	
  		var ch = $('#sync').find('tbody input[type=checkbox]');
    	var dt = '';	
  		ch.each(function(){  
      		if($(this).is(':checked')) { 
        		var idf = $(this).parents('tr').attr('id');
        		var idm = idf.substring(idf.indexOf('_')+1,idf.length);
            if(idm!=""){    
  		  		  dt = dt+' '+idm+',';
            }
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
          			var dataP = "restid="+restid+"&idf="+idf;
  					$.ajax({
            			type: "POST",
            			url: baseurl+"sync/exec",
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


function type()
{
  if (document.getElementById)
  {
    var dest=document.getElementById(destination);
    if (dest)
    {
      dest.innerHTML=text.substr(0, currentChar);
      if (currentChar<text.length){  
        currentChar++
      } 
      if (currentChar>text.length)
      {
        currentChar=1;
        setTimeout("type()", 5000);
      }
      else
      {
        setTimeout("type()", delay);
      }
    }
  }
}

function startTyping(textParam, delayParam, destinationParam)
{
  text=textParam;
  delay=delayParam;
  currentChar=1;
  destination=destinationParam;
  type();
}
                                     

</script> 