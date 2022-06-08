<!DOCTYPE html>
<html>
  <head>
    <title>Student Matric No. Generator</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    
    <link rel="stylesheet" type="text/css" href="admin_dash/sms.css"/>
    <link rel="shortcut icon" href="admin_dash/images/logo.png" type="image/x-icon">
    <link rel="icon" href="admin_dash/images/logo.png" type="image/x-icon">

  <!-- bootstrap -->
  <link rel="stylesheet" href="admin_dash/assets/css/bootstrap.min.css">
  <!-- Jquery -->
  <script src="admin_dash/assets/js/jquery-2.1.4.min.js"></script>
  <!-- Css -->
  <link rel="stylesheet" type="text/css" href="admin_dash/stylings.css">  
  <!-- bootstrap & fontawesome -->
  <link rel="stylesheet" href="admin_dash/assets/font-awesome/4.5.0/css/font-awesome.min.css" />

    
  </head>
    <body class="container-fluid">
        <div class="main-wrapper">
            <div class="row">
                 <div align="center" class="alert alert-info col-xs-12">
                    <div class="col-xs-2">
                        <img src="admin_dash/images/logo.png" title="PLASU Logo" alt="logo" style="width: 80%;"/> 
                    </div>
                    <div class="col-xs-10">
                         <h3 class='alert alert-success' style="word-spacing: 15px;"><?php echo strtoupper("Students' Matriculation Number System"); ?> </h3>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="col-xsg-12">
                <div class="col-md-10 col-md-offset-1 pt-50">
                    <div class="panel">
                        <div class="panel-heading">
                            <div class="panel-title text-center">
                                <h4 class='jumbotron' style="color: seagreen;">For Plateau State University Students Only</h4>
                            </div>
                        </div>
                        <div class="panel-body p-20">

                            <div class="section-title">
                                <p class="sub-title col-sm-8"><h5 class="alert alert-success">Student Matriculation Number Search Engine</h5></p>
                            </div>

                            <form class="form-horizontal" method="post">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Want to Request for your result?</label>
                                    <div class="col-sm-6">
                                       <a href="search_jamb.php" class="btn btn-success">click here</a>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                    <!-- /.panel -->
                    <hr>
                    <div style="margin-bottom: 60px;">
                        <?php require "admin_dash/footer.php"; ?>
                    </div>
                </div>
                    <!-- /.row -->
            </div>
        </div><br><br>
        <!-- /.main-wrapper -->
    </body>
</html>
