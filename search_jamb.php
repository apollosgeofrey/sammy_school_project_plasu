<!DOCTYPE html>
<html>
  <head>
    <title>Student Matric No. Search Engine</title>
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
  <?php
    if (isset($_POST['requester']) && isset($_POST['jamn_no'])) {
        $jamn_no = trim(htmlentities($_POST['jamn_no']));
        if (!empty($jamn_no)) {
            header("Location: studentmng.php?view=$jamn_no");
        } else {
            echo "<script>alert('Your Jamb Registration Number Input Field Cannot be blank!');
                    window.location.href='search_jamb.php'; </script>";
        }
    }
  ?>
    <body class="">
        <div class="main-wrapper">

            <div class="login-bg-color bg-black-300">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="panel login-box" style="margin-top: 40px;">
                            <div class="panel-heading">
                                <div class="panel-title text-center">
                                    <h4 class="alert alert-success"><strong class="">PLATEAU STATE UNIVERSITY, BOKKOS</strong><hr>
                                    <i>Students' Matriculation Number Search Engine</i></h4>
                                </div>
                            </div>
                            <div class="panel-body p-20">
                                <form action="search_jamb.php" method="post" autocomplete="off">
                                	<div class="form-group">
                                		<label for="jamn_no" style="color: seagreen;">Enter your Jamb Registration Number</label>
                                        <input type="text" class="form-control" required="" id="jamn_no" placeholder="Valid Jamb Registration Number" title="Provide Valid Jamb Registration Number" name="jamn_no">
                                	</div>
                               <div class="form-group mt-20">
                                    <div class="">
                                        <button type="submit" name="requester" class="btn btn-success btn-labeled pull-right">Search Out<span class="btn-label btn-label-right"><i class="fa fa-check"></i></span></button>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                    <div class="col-sm-6">
                                        <a href="index.php" style="color: seagreen;">Back to Home</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- /.panel -->
                    </div>
                    <div class="col-sm-12 text-center">
                        <div class="col-sm-2">
                        </div>
                        <div style="margin-bottom: 30px;" class="col-sm-12 text-center">
                            <?php require "admin_dash/footer.php"; ?>
                        </div>
                    </div>

                    <!-- /.col-md-6 col-md-offset-3 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /. -->

        </div>
    </body>
</html>
