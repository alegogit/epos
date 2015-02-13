<div id="page-content-wrapper">
<!-- Page Content -->
	<div class="container-fluid" style="font-size:90%;">
  		<h1 class="page-header"><span class="fa fa-user"></span> My Pr</b><span class="fa fa-meh-o" style="font-size:70%;font-weight:bold;"></span>file</h1>
  		<div class="row">
		<?php
			$attributes = array('class' => 'form-horizontal', 'id' => 'profile', 'role' => 'form', 'enctype' => 'multipart/form-data');
			echo form_open('profile',$attributes)
		?>
    		<!-- left column -->
    		<div class="col-md-4 col-sm-6 col-xs-12">
      			<div class="text-center">
					<div class="fileinput fileinput-new" data-provides="fileinput">
						<div class="fileinput-new">
		    				<img src="<?=$profpic?>" class="avatar img-circle img-thumbnail" alt="avatar" style="width: 210px; height: 210px;">
		  				</div><br/>
		  				<div class="fileinput-preview fileinput-exists avatar img-circle img-thumbnail thumbnail" style="max-width: 210px; max-height: 210px; border-radius: 50% !important; padding: 4px !important"></div>
		  				<div class="fileinput-error alert-danger" style="width: 210px; height: 210px; border-radius: 50% !important; padding: 4px !important; display:none;"></div>
		  				<div>
		    				<span class="btn btn-default btn-file">
								<span class="fileinput-new">Change Profile Photo</span><span class="fileinput-exists">Change</span>  
                <input name="MAX_FILE_SIZE" value="307200" type="hidden">
								<input type="file" accept="image/jpeg" name="photo" id="myFile">
							</span>
		    				<a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
		  				</div><br/>
	      				<div class="alert alert-info alert-dismissable" style="max-width: 250px;">
	        				<a class="panel-close close" data-dismiss="alert">×</a> 
	        				<i class="fa fa-info-circle"></i>
	        				Max <strong>300 kb</strong> image file.
	      				</div>
					</div>
      			</div>
    		</div>
    		<!-- edit form column -->
    		<div class="col-md-8 col-sm-6 col-xs-12 personal-info">
      			<div class="alert alert-info alert-dismissable">
        			<a class="panel-close close" data-dismiss="alert">×</a> 
        			<i class="fa fa-coffee"></i>
        			This is an <strong>.alert</strong>. Use this to show important messages to the user. 
      			</div>
      			<h3>Personal info</h3>
        		<div class="form-group">
          			<label class="col-lg-3 control-label" for="name">Name:</label>
          			<div class="col-lg-8 input-group">              
              			<div class="input-group-addon"><span class="fa fa-meh-o"></span></div>
            			<input class="form-control" placeholder="<?=$user->NAME?>" type="text" name="name" id="name">
          			</div>
        		</div>
			    <div class="form-group">
			    	<label class="col-lg-3 control-label" for="email">Email:</label>
			        <div class="col-lg-8 input-group">           
              			<div class="input-group-addon"><span class="fa fa-envelope"></span></div>
			            <input class="form-control" placeholder="<?=$user->EMAIL_ADDRESS?>" type="text" name="email" id="email">
			    	</div>
			    </div>
        		<div class="form-group">
          			<label class="col-lg-3 control-label" for="rest_id">Default Restaurant:</label>
          			<div class="col-lg-8 input-group">
              			<div class="input-group-addon"><span class="fa fa-cutlery"></span></div>
            			<div class="ui-select"> 
				        	<select id="rest_id" name="rest_id" class="form-control">
				            <?php foreach($restaurants as $rows){ ?>
				            	<option value = "<?=$rows->REST_ID?>" <?=($rows->REST_ID==$default->REST_ID)?'selected':''?> ><?=$rows->NAME?></option>
				            <?php } ?>
				            </select>
            			</div>			
          			</div>
        		</div>
			    <div class="form-group">
			    	<label class="col-md-3 control-label" for="user">Username:</label>
			        <div class="col-md-8 input-group">
              			<div class="input-group-addon"><span class="fa fa-user"></span></div>
			            <input class="form-control" placeholder="<?=$user->USERNAME?>" type="text" name="user" id="user">
			        </div>
			    </div>
			    <div class="form-group">
			    	<label class="col-md-3 control-label" for="pass1">Password:</label>
			        <div class="col-md-8 input-group">
              			<div class="input-group-addon"><span class="fa fa-lock"></span></div>
			            <input class="form-control" placeholder="*******" type="password" name="pass1" id="pass1">
			        </div>
				</div>
			    <div class="form-group">
			    	<label class="col-md-3 control-label" for="pass2">Confirm password:</label>
			        <div class="col-md-8 input-group">
              			<div class="input-group-addon"><span class="fa fa-lock"></span></div>
			            <input class="form-control" placeholder="*******" type="password" name="pass2" id="pass2">
					</div>
				</div>
        		<div class="form-group">
          			<label class="col-md-3 control-label"></label>
          			<div class="col-md-8">
            			<input class="btn btn-success" value="Save Changes" type="submit" name="spro">
            			<span></span>
            			<input class="btn btn-warning" value="Cancel" type="reset">
          			</div>
        		</div>
    		<?=form_close()?>
		</div>
  	</div>
</div>
<div id="baseurl" data-url="<?=base_url()?>"></div>

<script>
$('#myFile').bind('change', function() {
  var filesize = this.files[0].size / 1024;
  var filetype = this.files[0].type;
  if((filesize>300)||(filetype.substring(0,5)!="image")){
    $(".fileinput-preview").hide();  
    $(".fileinput-error").show().html("<span style='display:inline-block;padding:35px;'>You were trying to upload a <b>"+parseInt(filesize)+" kb "+strstr(filetype,'/',true)+"</b> file. Please upload a <b>Maximum 300 kb image</b> file</span>"); 
  } else {              
    $(".fileinput-error").hide(); 
    $(".fileinput-preview").show(); 
  }

});

$(function(){
	var baseurl = $("#baseurl").data('url');
  	//pass validation
  	$("#profile").validate({ 
    	rules: {
      		email: { 
        		email: true,
        		remote: baseurl+"process/users?p=takene" 
      		}, 
	      	user: {
	        	minlength: 3,
	        	remote: baseurl+"process/users?p=takenu"
	      	},
	     	pass1: { 
	        	minlength: 6 
	      	}, 
	      	pass2: { 
	        	equalTo: "#pass1",
	        	minlength: 6
	      	}      
    	},
	    messages:{ 
	      	email: {
	        	remote: "Please enter another email"
	      	},
	      	user: {
	        	remote: "Please enter another username"
	      	},
	      	pass2: { 
	        	equalTo:"The passwords don’t match"
	      	}
	    }
  });
    
});         

$.validator.setDefaults({
    highlight: function(element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function(element) {
        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
    },
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        if(element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else {
            error.insertAfter(element);
        }
    }
});

function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

function strstr(haystack, findme, flag)
{  
var position = 0;  
  position = haystack.indexOf(findme);
  if (position == -1)
  {
    return false;
  } else
 {
    if (flag)
{ return haystack.substr(0, position);
    } else
{
      return haystack.slice(position);
    }
  }
}  
</script>
