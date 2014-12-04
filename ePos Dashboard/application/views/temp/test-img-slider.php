<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>

<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css"/>


</head>

<body>

<script>
$(document).ready(function() {
	$('#promoCarousel').carousel({
		interval: 5000
	});
	
	$('#serviceCarousel').carousel({
		interval: 5000
	});

    
    $('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
	});
    
    
});
</script>

<style>
.thumbnail {
  display: block;
  padding: 4px;
  margin-bottom: 20px;
  line-height: 1.42857143;
  -webkit-transition: all .2s ease-in-out;
  transition: all .2s ease-in-out;
  border-radius: 0;
  border: none;
  background-color: none;
}

.carousel-control {
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  width: 5%;
  opacity: .5;
  font-size: 10px;
  color: #fff;
  text-align: center;
  text-shadow: none;
}
.carousel-control.left {
	background-image: none;
}
.carousel-control.right {
  left: auto;
  right: 0;
  background-image: none;
}

.carousel-control {
  padding-top:10.25%;
  width:10%;
}

</style>

<div class="container">

  <div class="row">
  
    <div class="col-md-6">

        <div class="well-none">
            <div id="promoCarousel" class="carousel slide">
                
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                              <div class="container">
                                <div class="carousel-caption">
                                  <h3>Example headline.</h3>
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div><!--/row-->
                    </div><!--/item-->
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div><!--/row-->
                    </div><!--/item-->
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div><!--/row-->
                    </div><!--/item-->
                </div><!--/carousel-inner--> 
                <a class="left carousel-control" href="#promoCarousel" data-slide="prev"><i class="glyphicon glyphicon-chevron-left glyphicon-4"></i></a>

                <a class="right carousel-control" href="#promoCarousel" data-slide="next"><i class="glyphicon glyphicon-chevron-right glyphicon-4"></i></a>
            </div>
            <!--/myCarousel-->
        </div>
        <!--/well-->
        
	</div><!-- /.col-md-6 -->

    <div class="col-md-6">

        <div class="well-none">
            <div id="serviceCarousel" class="carousel slide">
                
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div><!--/row-->
                    </div><!--/item-->
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div><!--/row-->
                    </div><!--/item-->
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                            <div class="col-sm-6 col-xs-12"><a href="#x" class="thumbnail">
                              <img src="http://placehold.it/250x250" alt="Image" class="img-responsive"></a>
                            </div>
                        </div><!--/row-->
                    </div><!--/item-->
                </div><!--/carousel-inner--> 
                <a class="left carousel-control" href="#myCarousel1" data-slide="prev"><i class="glyphicon glyphicon-chevron-left glyphicon-4"></i></a>
                <a class="right carousel-control" href="#myCarousel1" data-slide="next"><i class="glyphicon glyphicon-chevron-right glyphicon-4"></i></a>
            </div><!--/myCarousel-->
        </div><!--/well-->
          
    </div><!-- /.col-md-6 -->
    
  </div><!-- /.row -->

</div><!-- /.container-fluid -->

</body>
</html>