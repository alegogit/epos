<!-- /. -->
<?php session_start(); define("KEY", "passed"); error_reporting(E_ALL & ~E_NOTICE); ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ePOS</title>

<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/icon.ico" />

<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>  

<?php if ( ($menu == 'setting') || ($menu == 'inventory') || ($menu == 'customers') || ($menu == 'profile') ) { ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-editable.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-select.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/inputmask/jquery.inputmask.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.autoresize.js"></script> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-editable.css"/> 
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap-select.min.css"/>
<style>
.popover-content {
    max-height: 300px;
    overflow-y: scroll;
}
</style>
<?php } ?>  
<?php if ( ($menu == 'setting') || ($menu == 'profile') ) { ?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/upload/jasny-bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jasny-bootstrap.min.css"/> 
<?php } ?>  

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/print.css" media="print"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/datepicker.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery-ui.theme.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css"/>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/msform.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/gallery-effect.css"/>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/custom.css"/>    
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css"/>

<!-- Chart -->
<script src="<?=base_url()?>assets/js/charts/chart.min.js"></script> 

<!-- Datepicker -->
<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>

<!-- Table -->
<script src="<?=base_url()?>assets/js/jquery.dataTables.js"></script> 

<!-- Currency -->
<script src="<?=base_url()?>assets/js/autoNumeric.js"></script> 
 
<script type="text/javascript">
$(function() {
    $( document ).tooltip({
      position: {
        my: "center bottom-5",
        at: "center top",
        using: function( position, feedback ) {
          $( this ).css( position );
          $( "<div>" )
            .addClass( "arrow" )
            .addClass( feedback.vertical )
            .addClass( feedback.horizontal )
            .appendTo( this );
        }
      }
    });
});

</script>

<style>
  .ui-tooltip, .arrow:after {
    background: black;
    border: 1px solid black;
  }
  .ui-tooltip {
    padding: 4px 8px;
    color: white;
    border-radius: 6px;
    font: bold 10px "Helvetica Neue", Sans-Serif;
    text-transform: uppercase;
    box-shadow: 0 0 2px black;
  }
  .arrow {
    width: 35px;
    height: 8px;
    overflow: hidden;
    position: absolute;
    left: 50%;
    margin-left: -17px;
    bottom: -8px;
  }
  .arrow.top {
    top: -8px;
    bottom: auto;
  }
  .arrow.left {
    left: 20%;
  }
  .arrow:after {
    content: "";
    position: absolute;
    left: 10px;
    top: -10px;
    width: 15px;
    height: 15px;
    box-shadow: 6px 5px 9px -9px black;
    -webkit-transform: rotate(45deg);
    -ms-transform: rotate(45deg);
    transform: rotate(45deg);
  }
  .arrow.top:after {
    bottom: -10px;
    top: auto;
  }
  
  .canvas-donut{
    width: 100% !important;
    max-width: 120px !important;
    height: auto !important;
  }
  
  .fitin{
    min-height: 150px;
    overflow: hidden;
    font-size: 90%;
  }
  </style>

</head>

<body style="background-color:#FBFBFB;">

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <div class="gallery">
            <a class="navbar-brand" style="margin-top:-10px !important;" href="<?=base_url()?>dashboard">
              <img class="img-thumbnail" style="width:40px; height:40px;" src="<?=$reslogo?>"/>  
              <!--<span style="padding-left:6px;padding-right:6px">epos</span>-->           
            </a>  
          </div>
        </div>
    
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <!--<li class="glyphicon glyphicon-bell" style="padding:5px 15px;">
            </li>-->
            <li class="dropdown">
              <a href="#" style="padding:5px 15px;" class="dropdown-toggle" data-toggle="dropdown">
                <img class="img-circle img-thumbnail" style="width:40px;padding:1px !important;" src="<?=$profpic?>" />
                <span style="padding-left:6px;padding-right:6px"><?php echo $user->NAME; ?></span><span class="caret"></span>
              </a>
              <ul class="dropdown-menu" role="menu" style="min-width:100% !important;">
                <li><a href="<?php echo site_url(); ?>profile"><span style="margin-right:10px;" class="glyphicon glyphicon-user"></span>My Profile</a></li>
                <!--<li><a href="<?php echo site_url(); ?>notifications"><span style="margin-right:10px;" class="glyphicon glyphicon-bullhorn"></span>Notifications <small class="badge">42</small></a></li>
                <li><a href="#"><span style="margin-right:10px;" class="glyphicon glyphicon-cog"></span>Setting</a></li>-->
                <li class="divider"></li>
                <li><a href="<?php echo site_url(); ?>logout"><span style="margin-right:10px;" class="glyphicon glyphicon-log-out"></span>Log Out</a></li>
              </ul>
            </li>
          </ul>
          
          <!--
          <form class="navbar-form navbar-right" role="search">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
          </form>
          -->
          
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

 	<div id="wrapper">
