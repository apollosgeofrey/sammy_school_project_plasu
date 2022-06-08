<?php

/*
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

//error_reporting(0);
/********************* Step 1 *****************************/
session_start();
include_once 'smsdb.php';
if(!isset($_SESSION['username'])){
    $_GLOBALS['message']="Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
}
        //This is to protect unauthorized users
 else if(!($_SESSION['role']=="Administrator")){
    unset($_SESSION['username']);
  $_GLOBALS['message']="Please, You are accessing unauthorized page.Click here to <a href=\"../index.php\">Re-LogIn</a>";
 }
        else if(isset($_REQUEST['logout'])){
           unset($_SESSION['username']);
            $_GLOBALS['message']="You are Loggged Out Successfully.";
            header('Location:index.php');
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
            $jame_reg_no = $filesop[0];
			$name = $filesop[1];
			$sex = $filesop[2];
			$faculty = $filesop[3]; 
			$department = $filesop[4];	
            $year_entry = $filesop[5];					
			//ecrypting password
			//$pass = md5($filesop[4]);
			//$role = "Student";
	$result = executeQuery("select max(id) as id from auto_id_generate where uid=" . $_SESSION['uid'] . ";");
    $r = mysqli_fetch_array($result);
    if (is_null($r['id']))
        $newid= 1;
    else
        $newid=$r['id'] + 1;
			$c++;
			if($c>1)
			{
            $newid_str = strval($newid);
            $newid_leng = strlen($newid_str);
            if ($newid_leng == 1) {
                $newid_str = "000$newid_str";
            } else if ($newid_leng == 2) {
                $newid_str = "00$newid_str";
            } else if ($newid_leng == 3) {
                $newid_str = "0$newid_str";
            } else if ($newid_leng == 4) {
                $newid_str = "$newid_str";
            }
            $faculty_id = $_SESSION['faculty_id'];
            $mat_number = "PLASU/$year_entry/$faculty_id/$newid_str"; 
		     $sql1 = executeQuery("INSERT INTO auto_id_generate(id, jame_reg_no, name, sex, faculty, faculty_id, department, mat_number, uid) VALUES ($newid, '$jame_reg_no', '$name',' $sex', '$faculty', '$faculty_id', '$department', '$mat_number', '".$_SESSION['uid']."')");
			 //$sql2=executeQuery("INSERT INTO user (username,password,role) VALUES('$idno','$pass','$role')");
            }
		
		}		
		
			if($sql1 /*|| $sql2*/){
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
                <form name="admwelcome" action="studentmng.php" method="post">
                    <ul id="menu">
                        <?php if(isset($_SESSION['username'])){ ?>
                        <li><input type="submit" value="LogOut" name="logout" class="btn btn-success" title="Log Out"/></li>
                          <li><input type="submit" value="Manage Student" name="stdmng" class="subbtn" title="Manage Student"/></li>
                        <?php } ?>
                    </ul>
                </form>
            </div>
        <div class="col-sm-2">
        </div>
       <div class="page col-sm-8 container center-block" style="margin-bottom: 10px;">
          <?php if(isset($_SESSION['username'])){ ?>
        <form name="import" method="post" enctype="multipart/form-data">
        <table class="table table-responsive" style="text-align:left;" >
         <tr>
         <td><div class="help">NOTE: To import Student profile from excel follow the following steps:</br>
         1.Open new spreadsheet and format like the following</br></div></td></tr>
         <tr><td><img src="images/autoid.png" class="col-xs-12" /></br></td>
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
        <br><a href="freshstdlist.csv" class="btn btn-success" download="sample_CSV.csv"><span class="fa fa-download"></span>  Click to download CSV sample file</a>
        <span class="btn btn-success pull-right"><span class="fa fa-upload"></span> <input type="submit" name="import" class="btn btn-success" value="Load File Into Database" /></span>
    </td>
        </tr>
        </table>
    </form>
                <?php }?>

            </div>
        <?php include'footer.php';?>
      </div><br>
      <div class="col-xs-12" style="height: 30px;"></div>      
  </body>
</html>
