 <?php

 /*
*** Student Management System                   ***
*** Title:  Users Authentication                ***
*/ 
 //error_reporting(0);
  session_start();
  include_once 'smsdb.php';

 if(isset($_REQUEST['submit'])) {

 //Perform Authentication
 //encrypting password use md5
    $pass=md5(htmlspecialchars($_REQUEST['password'],ENT_QUOTES));
    $result=executeQuery("select * from user where username='".htmlspecialchars($_REQUEST['uname'],ENT_QUOTES)."' and password='".$pass."';");
    if(mysqli_num_rows($result)>0) {
        $r=mysqli_fetch_array($result);
         $role=$r['role'];
         //echo $role;
        if(strcmp(htmlspecialchars($r['password'],ENT_QUOTES),$pass)==0)  {
            $_SESSION['username']=htmlspecialchars_decode($r['username'],ENT_QUOTES);
            $_SESSION['rank_level']=htmlspecialchars_decode($r['rank_level'],ENT_QUOTES);
            $_SESSION['faculty_name']=htmlspecialchars_decode($r['faculty_name'],ENT_QUOTES);
            $_SESSION['faculty_id']=htmlspecialchars_decode($r['faculty_id'],ENT_QUOTES);
            $_SESSION['uid']=$r['uid'];
            //storing user role into session variable to protect unauthorized users.
            $_SESSION['role']=$r['role'];
            if (isset($_GLOBALS['message'])) {            
              unset($_GLOBALS['message']);
            }
           
           // echo $role;
            if($role=='Administrator'){
              header('Location:admwelcome.php');
            } else {
            	$_GLOBALS['message']="Check Your user name and Password.";
            }	  
        } else {
          $_GLOBALS['message']="Check Your user name and Password.";
        }
    } else {
        $_GLOBALS['message']="Check Your user name and Password.";
    }
      closedb();
  }

//header file
  require "header_login.php";
?>
      
  <div id="container-fliud col-sm-12 col-xs-12">          
    <div class="header">
      <div class="col-xs-2"> 
        <img style="margin:10px 2px 2px 10px;float:left;" height="auto" width="70%" src="images/logo.png" alt="Mat. No. Gen."/>
      </div>
      <div class="col-xs-9">
        <h3 class="headtext col-xs-12 text-center"> &nbsp; Plateau State University</h3>
        <h5 class="headtext col-xs-12 text-center"><i>...Matric No. Generator...</i> </h5>
      </div>
    </div>
     <form id="stdloginform" action="index.php" method="post" class="col-xs-12">
      <?php 
        if(isset($_GLOBALS['message'])) {
           echo "<div class=\"message text-center \">".$_GLOBALS['message']."</div>";
        }
      ?>
        <div class="col-xs-6 ">
          <ul id="menu">      
          </ul>
        </div><br>
        <div class="col-sm-3">
          
        </div>
      <div class="well col-sm-6 col-sm-offset-4 center-block col-xs-12">    
          <div class="form-group col-xs-11">
            <label for='uname' >Username:</label>
            <input type="text" class="form-control" name="uname" id="uname" value="<?php if(isset($_POST['uname'])){ echo $_POST['uname']; } ?>" />
          </div>

          <div class="form-group col-xs-11">
            <label for='password' >Password:</label>
            <input type="password" class="form-control" name="password" id="password" value="<?php if(isset($_POST['password'])){ echo $_POST['password']; } ?>" />
          </div><br><br>

          <div class="form-group col-xs-6 ">
              <input type="checkbox" value="remember_me" name="remember_me" id="remember_me"/>
              <label for="remember_me">Remember Me</label>
          </div>
          <div class="form-group col-xs-6 text-right">
            <input type="checkbox" value="forgot_password" name="forgot_password" id="forgot_password"/> 
            <label for="forgot_password">Forgot Password?</label>
          </div>

          <div class="form-group col-xs-12">
            <input type="submit" value="Log In" name="submit" class="btn btn-success text-center col-sm-3" />
          </div>
      </div>
    </form>

      <?php include'footer.php';?>
    </div>
  </body>
</html>
