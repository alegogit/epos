<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>

<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<script type="text/javascript" src="../assets/js/jquery-ui.js"></script>

<link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.css"/>
<link rel="stylesheet" type="text/css" href="../assets/css/jquery-ui.css"/>
<link rel="stylesheet" type="text/css" href="../assets/css/jquery-ui.theme.css"/>

  <script>
  $(function() {
    $( "#accordion" ).accordion({
      collapsible: true
    });
  });
  </script>
  
</head>

<body>
<!-- /. -->
<div class="container-fluid" style="font-size:80%;">

  <div class="row">
    <div class="col-sm-2">
        <div id="accordion">
          <h3>Advanced Search</h3>
          <div>
            <form role="form">
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox"> Check me out
                </label>
              </div>
              <button type="submit" class="btn btn-default">Submit</button>
            </form>
          </div>
        </div><!-- /#accordion -->  
    </div><!-- /.col-sm-2 -->
    
    <div class="col-sm-10">
      <table class="table table-bordered table-hover table-striped">
        <thead>
          <tr class="info">
            <th>#title 1</th>
            <th>#title 2</th>
            <th>#title 3</th>
            <th>#title 4</th>
            <th>#title 5</th>
          </tr>
        </thead>
        <tbody>
        <?php for($i=1;$i<=20;$i++){ ?>
          <tr>
            <td><?php echo "#row".$i."  #column1"; ?></td>
            <td><?php echo "#row".$i."  #column2"; ?></td>
            <td><?php echo "#row".$i."  #column3"; ?></td>
            <td><?php echo "#row".$i."  #column4"; ?></td>
            <td><?php echo "#row".$i."  #column5"; ?></td>
          </tr>
        <?php } ?>  
        </tbody>
      </table>
    </div><!-- /.col-sm-2 -->
  </div><!-- /.row -->

</div><!-- /.container-fluid -->

<!-- /. -->
</body>
</html>
