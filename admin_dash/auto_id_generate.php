<?php

/*
***************************************************
*** Examination ment ManageSystem               ***
***---------------------------------------------***
*** Developer: Dejene Techane                   ***
*** Title: Import student profile               ***
***************************************************
*/

/* Procedure
*********************************************
 * ----------- *
 * PHP Section *
 * ----------- *
Step 1: Perform Session Validation.
  case 1:Submit to import file to the system.
 * ------------ *
 * HTML Section *
 * ------------ *
Step 2: Display the html form
	case 1: Import form to import excel file
	

*********************************************
*/

error_reporting(0);
/********************* Step 1 *****************************/
session_start();
include_once '../include/emsdb.php';
        if(!isset($_SESSION['username'])){
            $_GLOBALS['message']="Session Timeout.Click here to <a href=\"../index.php\">Re-LogIn</a>";
        }
        //This is to protect unauthorized users
 else if(!($_SESSION['role']=="Administrator")){
    unset($_SESSION['username']);
  $_GLOBALS['message']="Please, You are accessing unauthorized page.Click here to <a href=\"../index.php\">Re-LogIn</a>";
 }
        else if(isset($_REQUEST['logout'])){
           unset($_SESSION['username']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location: ../index.php');
        }else if(isset($_REQUEST['stdmng'])){
        	header('Location:studentmng.php');
        }
        
       else if(isset($_REQUEST['import']))
	{  
        if ($_FILES['file']['size'] > 0) { 
        	
        $file = $_FILES['file']['tmp_name'];
		  $handle = fopen($file, "r");
		  
      
        
     	$c = 0;
		while(($filesop = fgetcsv($handle, 10000, ",")) !== false)
		{
			$name = $filesop[0];
			$sex = $filesop[1];
			$colid = $filesop[2]; 
			$prog = $filesop[3];						
			//ecrypting password
			//$pass = md5($filesop[4]);
			//$role = "Student";
	$result = executeQuery("select max(id) as id from autoidgenerate where uid=" . $_SESSION['uid'] . ";");
    $r = mysql_fetch_array($result);
    if (is_null($r['id']))
        $newid= 1;
    else
        $newid=$r['id'] + 1;
			$c++;
			if($c>1)
			{
		     $sql1 = executeQuery("INSERT INTO auto_id_generate(id,name,sex,college_id,program) VALUES ('".$newid."','$name','$sex','$colid','$prog')");
			 //$sql2=executeQuery("INSERT INTO user (username,password,role) VALUES('$idno','$pass','$role')");
		}
		
		}		
		
			if($sql1 || $sql2){
			$_GLOBALS['message']="You database has imported successfully. Click <a href=\"studentmng.php\">Here</a>  to view.";
			
			}else{
			$_GLOBALS['message']="Sorry! There may be duplication of data.";
			}
	  
	  	  
	  }			
		
			else{
			 $_GLOBALS['message']= "You are opening Empty file, try again.";	
			}
	        
			closedb();
	}
        
?>

<html>
    <head>
        <title>EMS-IMPORT STUDENT PROFILE</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
         <link rel="icon" type="jpg/png" href="../images/logo.png"/>
        <link rel="stylesheet" type="text/css" href="../ems.css"/>
    </head>
    <body>
        <?php
       /********************* Step 2 *****************************/
        if(isset($_GLOBALS['message'])) {
            echo "<div class=\"message\">".$_GLOBALS['message']."</div>";
        }
        ?>
        <div id="container">
            <div class="header">                              
                <?php require'../include/header.php';?>                
                </div>
            <div class="menubar">

                <form name="admwelcome" action="studentmng.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['username'])){ ?>
                        <li><input type="submit" value="LogOut" name="logout" class="subbtn" title="Log Out"/></li>
                          <li><input type="submit" value="Manage Student" name="stdmng" class="subbtn" title="Manage Student"/></li>
                        <?php } ?>
                    </ul>
                </form>
            </div>
       <div class="page">
          <?php if(isset($_SESSION['username'])){ ?>

        <form name="import" method="post" enctype="multipart/form-data">
        <table cellpadding="20" cellspacing="20" style="text-align:left;margin-left:15em" >
         <tr>
         <td><div class="help">NOTE: To import Student profile from excel follow the following steps:</br>
         1.Open new spreadsheet and format like the following</br></div></td></tr>
         <tr><td><img src="../images/autoid.png"/></br></td>
         <tr><td><div class="help">2. Then save it as &lt;filename &gt;.csv(e.g studentlist.csv)</br>
         3.Then go back to the system and click on the browse file button and open .csv file format</br>
         4. Finally, Click on Load File Into Database button to load excel file to database.</br>
         NB:The file extension should be .csv file format, Unless other file format should not be possible!</div></td></tr>
         <tr>
    	<td>Browse Student List:<input type="file" name="file" />
    	<!--<tr><td>Academic Year in E.C <input type="text" name="ayear" id="textbox" placeholder="E.g <?php echo (date('Y')-8);?> E.C" onkeyup="isnum(this)"/></td>
    	<tr><td>COLLEGE ID:<input type="text" name="ayear" id="textbox"placeholder="E.g IOT" onkeyup="isalpha(this)" max="5"/>
    	<tr><td>Program:<select id="textbox" name="prog">
    	<option value="<Select Program">&lt;Select Program&gt;</option>
    	<option value="R">Regular</option>
    	<option value="E">Evening</option>
    	<option value="S">Summer</option>
    	</select>-->
        <input type="submit" name="import" class="subbtn" value="Load File Into Database" /></td>
        </tr>
        </table>
    </form>
                <?php }?>

            </div>

          <div id="footer">
           <?php include'../include/footer.php';?>
           
           
           </div>
      </div>
  </body>
</html>
