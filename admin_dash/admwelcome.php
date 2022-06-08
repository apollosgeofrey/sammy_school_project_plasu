<?php

/*
***************************************************
*** Title: Admin Welcome                        ***
***************************************************
*/

/* Procedure
*********************************************
 * ----------- *
 * PHP Section *
 * ----------- *
Step 1: Perform Session Validation.
 * ------------ *
 * HTML Section *
 * ------------ *
Step 2: Display the Dashboard.
*********************************************
*/

//error_reporting(0);
include_once 'smsdb.php';
/********************* Step 1 *****************************/
session_start();
if(!isset($_SESSION['username'])){
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} 
      //This is to protect unauthorized users
 else if(!($_SESSION['role']=="Administrator")){
    unset($_SESSION['username']);
    $_GLOBALS['message']="Please, You are accessing unauthorized page.Click here to <a href=\"index.php\">Re-LogIn</a>";
 } else if(isset($_REQUEST['logout'])){
   unset($_SESSION['username']);
   $_GLOBALS['message']="You are Loggged Out Successfully.";
   header('Location:index.php');
}

//header file
  require "header_login.php";
?>
<?php
/********************* Step 2 *****************************/
    if(isset($_GLOBALS['message'])) {
        echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
    }
?>
        <div id="container">
            <div class="header">                              
                <?php require'header.php';?>                
            </div>
            <div class="menubar">
                <form name="admwelcome" action="admwelcome.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['username'])){ ?>
                        <li><input type="submit" value="LogOut" name="logout" class="btn btn-success" title="Log Out"/></li>
                        <?php include'menus.php';?>
                       
                        <?php } ?>
                    </ul>
                </form>
            </div>
            <div class="page">
                <?php if(isset($_SESSION['username'])){ ?>
                	
               <?php
                $result=executeQuery("select * from user where username='".$_SESSION['username']."';");
                $r=mysqli_fetch_array($result);
                closedb();?>
                <h4 class="alert alert-success text-center"><i> &nbsp;Welcome to your dashboard <?php echo htmlspecialchars_decode($r['username'], ENT_QUOTES);?></i></h4>
               <img src="images/page.gif" height="130"/> 
                
                <?php }?>

            </div>

           <?php include'footer.php';?>
      </div>
  </body>
</html>
