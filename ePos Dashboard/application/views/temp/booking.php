<!-- /. -->
<?php if(!defined("KEY")) die("script cannot be accessed directly."); ?>
<div id="page-content-wrapper">

<div class="container-fluid" style="font-size:90%;">

  <a href="#menu-toggle" class="" id="menu-toggle" style="font-size:80%; margin-top:-5%;">
    <span id="hand" class="glyphicon glyphicon-hand-left"></span> Show/Hide Menu</a>
  <br /><br />

<form id="msform" class="form-horizontal" action="" role="form">
	<!-- progressbar -->
	<ul id="progressbar">
		<li class="active"><p>Account Setup</p></li>
		<li><p>Social Profiles</p></li>
		<li><p>Personal Details</p></li>
        <li><p>Personal Details 2</p></li>
	</ul>
	<!-- fieldsets -->
	<fieldset>
		<h2 class="fs-title">Create your account</h2>
		<h3 class="fs-subtitle">
            <div id="effect"></div>
              <!--email belum diisi.-->
        </h3>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-4 control-label">Email</label>
          <div class="col-sm-7">
            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Email">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword" class="col-sm-4 control-label">Password</label>
          <div class="col-sm-7">
            <input type="password" name="pass" class="form-control" id="inputPassword" placeholder="Password">
          </div>
        </div>
        <div class="form-group">
          <label for="inputPassword2" class="col-sm-4 control-label">Confirm Password</label>
          <div class="col-sm-7">
            <input type="password" name="pass2" class="form-control" id="inputPassword2" placeholder="Confirm Password">
          </div>
        </div>
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Social Profiles</h2>
		<h3 class="fs-subtitle"></h3>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">Twitter</label>
          <div class="col-sm-8">
            <input type="text" name="twitter" class="form-control" placeholder="Twitter" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">Facebook</label>
          <div class="col-sm-8">
            <input type="text" name="facebook" class="form-control" placeholder="Facebook" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">Google+</label>
          <div class="col-sm-8">
            <input type="text" name="gplus" class="form-control" placeholder="Google Plus" />
          </div>
        </div>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
	<fieldset>
		<h2 class="fs-title">Personal Details</h2>
		<h3 class="fs-subtitle"></h3>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">First Name</label>
          <div class="col-sm-8">
            <input type="text" name="fname" class="form-control" placeholder="First Name" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">Last Name</label>
          <div class="col-sm-8">
            <input type="text" name="lname" class="form-control" placeholder="Last Name" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">Phone</label>
          <div class="col-sm-8">
            <input type="text" name="phone" class="form-control" placeholder="Phone" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-3 control-label">Address</label>
          <div class="col-sm-8">
            <textarea name="address" rows="3" class="form-control" placeholder="Address"></textarea>
          </div>
        </div>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="button" name="next" class="next action-button" value="Next" />
	</fieldset>
    <fieldset>
		<h2 class="fs-title">Personal Details 2</h2>
		<h3 class="fs-subtitle"></h3>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-4 control-label">First Name</label>
          <div class="col-sm-7">
            <input type="text" name="fname" class="form-control" placeholder="First Name" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-4 control-label">Last Name</label>
          <div class="col-sm-7">
            <input type="text" name="lname" class="form-control" placeholder="Last Name" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-4 control-label">Phone</label>
          <div class="col-sm-7">
            <input type="text" name="phone" class="form-control" placeholder="Phone" />
          </div>
        </div>
        <div class="form-group">
          <label for="inputEmail" class="col-sm-4 control-label">Address</label>
          <div class="col-sm-7">
            <textarea name="address" class="form-control" placeholder="Address"></textarea>
          </div>
        </div>
		<input type="button" name="previous" class="previous action-button" value="Previous" />
		<input type="submit" name="submit" class="submit action-button" value="Submit" />
	</fieldset>
</form>

</div>

<script>
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches


//var email = document.getElementById('email');
//------------------------------------------------------------
    function runEffect() {
      // get effect type from
      //var selectedEffect = $( "#effectTypes" ).val();
 
      // most effect types need no options passed by default
      //var options = {};
      // some effects have required parameters
      //if ( selectedEffect === "scale" ) {
      //  options = { percent: 100 };
      //} else if ( selectedEffect === "size" ) {
      //  options = { to: { width: 280, height: 185 } };
      //}
 
      // run the effect
      $( "#effect" ).show("fade" , "easeOutBounce", 500, callback);//easeOutBounce
    };
 
    //callback function to bring a hidden box back
    function callback() {
      setTimeout(function() {
        $( "#effect:visible" ).fadeOut(); //.removeAttr( "style" )
		$("#warn").remove();
      }, 2500 );
    };
 
    // set effect from select menu value
    //$( "#button" ).click(function() {
    //  runEffect();
    //  return false;
    //});
 
    $( "#effect" ).fadeOut();
//------------------------------------------------------------

$(".next").click(function(){
	/*var email = document.forms["msform"]["email"].value;
	var pass = document.forms["msform"]["pass"].value; 
	var pass2 = document.forms["msform"]["pass2"].value; 
	if(email == "" || email == null){
		runEffect();
		$("#effect").append("<div id='warn' class='alert alert-danger'>Please enter your E-mail</div>")
		$("#email").focus();
		$("#email").css("border-color","red");
		setTimeout(function() {
		  $("#email").removeAttr( "style" );
		  }, 3000 );
		return false;
	}
	else if(pass == "" || pass == null){
		runEffect();
		$("#effect").append("<div id='warn' class='alert alert-danger'>Please enter your Password.</div>")
		$("#pass").focus();
		$("#pass").css("border-color","red");
		setTimeout(function() {
		  $("#pass").removeAttr( "style" );
		  }, 3000 );
		return false;
	}
	else if(pass2 == "" || pass2 == null){
		runEffect();
		$("#effect").append("<div id='warn' class='alert alert-danger'>Please confirm your Password.</div>")
		$("#pass2").focus();
		$("#pass2").css("border-color","red");
		setTimeout(function() {
		  $("#pass2").removeAttr( "style" );
		  }, 3000 );
		return false;
	}
	else{*/
	
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'transform': 'scale('+scale+')'});
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
	//}
});

$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});

$(".submit").click(function(){
	return false;
})

</script>

<!-- Menu Toggle Script -->
<script>
$("#menu-toggle").click(function(e) {
  e.preventDefault();
  $("#wrapper").toggleClass("toggled");
});
$( "#menu-toggle" ).click(function(){
	if($( "#hand" ).attr("class") == "glyphicon glyphicon-hand-left"){
      $( "#hand" ).removeClass("glyphicon glyphicon-hand-left",500);
	  $( "#hand" ).addClass("glyphicon glyphicon-hand-right",500);
	}
	else{
	  $( "#hand" ).removeClass("glyphicon glyphicon-hand-right",500);
	  $( "#hand" ).addClass("glyphicon glyphicon-hand-left",500);
	}
	  
      //$( "#hand" ).switchClass( "glyphicon glyphicon-hand-right glyphicon", "glyphicon glyphicon-hand-left glyphicon");
    });

</script>

