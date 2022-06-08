
<?php
 /*
****************************************************
*** Student Management System                    ***
* ** Title: Users Management(Add,delete,Modify) ***
** *************************************************
 */

/* Procedure
 * ********************************************

 * ----------- *
 * PHP Section *
 * ----------- *

  Step 1: Perform Session Validation.

  Step 2: Event to Process...
  Case 1 : Logout - perform session cleanup.
  Case 2 : Dashboard - redirect to Dashboard
  Case 3 : Delete - Delete the selected User/s from System.
  Case 4 : Edit - Update the new information.
  Case 5 : Add - Add new user to the system.

 * ------------ *
 * HTML Section *
 * ------------ *

  Step 3: Display the HTML Components for...
  Case 1: Add - Form to receive new user information.
  Case 2: Edit - Form to edit Existing User Information.
  Case 3: Default Mode - Displays the Information of Existing Users, If any.
 * ********************************************
 */

//error_reporting(0);
session_start();
include_once 'smsdb.php';
/* * ************************ Step 1 ************************ */
if (!isset($_SESSION['username'])) {
    $_GLOBALS['message'] = "Session Timeout.Click here to <a href=\"index.php\">Re-LogIn</a>";
} 
//This is to protect unauthorized users
 else if(!($_SESSION['role']=="Administrator")){
    unset($_SESSION['username']);
  $_GLOBALS['message']="Please, You are accessing unauthorized page.Click here to <a href=\"index.php\">Re-LogIn</a>";
 }else if (isset($_REQUEST['logout'])) {
    /*     * ************************ Step 2 - Case 1 ************************ */
    //Log out and redirect login page
    unset($_SESSION['username']);
    header('Location: index.php');
} else if (isset($_REQUEST['dashboard'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: admwelcome.php');
} else if (isset($_REQUEST['tcmng'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: tcmng.php');
} else if (isset($_REQUEST['delete'])) {
    /*     * ************************ Step 2 - Case 3 ************************ */
    //deleting the selected users
    unset($_REQUEST['delete']);
    $hasvar = false;
    foreach ($_REQUEST as $variable) {
        if (is_numeric($variable)) { //it is because, some sessin values are also passed with request
            $hasvar = true;

            if (!@executeQuery("delete from user where uid=$variable")) {
                if (mysql_errno () == 1451) //Children are dependent value
                    $_GLOBALS['message'] = "To Prevent accidental deletions, system will not allow propagated deletions.<br/><b>Help:</b> If you still want to delete this user, then first manually delete all the records that are associated with this user.";
                else
                    $_GLOBALS['message'] = mysql_errno();
            }
        }
    }
    if (!isset($_GLOBALS['message']) && $hasvar == true)
        $_GLOBALS['message'] = "Selected User/s are successfully Deleted";
    else if (!$hasvar) {
        $_GLOBALS['message'] = "First Select the users to be Deleted.";
    }
} else if (isset($_REQUEST['savem'])) {
    /*     * ************************ Step 2 - Case 4 ************************ */
    //updating the modified values
    //retrieving values from the form
   //encrypting password
    	$newpass=md5(htmlspecialchars($_REQUEST['newpass'], ENT_QUOTES));
    	$repass=md5(htmlspecialchars($_REQUEST['repass'], ENT_QUOTES));
    	$uname=htmlspecialchars($_REQUEST['uname'], ENT_QUOTES);
        $faculty_name=htmlspecialchars($_REQUEST['faculty_name'], ENT_QUOTES);
        $faculty_id=htmlspecialchars($_REQUEST['faculty_id'], ENT_QUOTES);
        
    	//$role=htmlspecialchars($_REQUEST['role'], ENT_QUOTES);
    if (empty($_REQUEST['uname']) || empty($_REQUEST['newpass']) || empty($_REQUEST['repass']) || empty($_REQUEST['faculty_name']) || empty($_REQUEST['faculty_id'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty.Therefore Nothing is Updated";
    }  else if(!($repass==$newpass)){
        $_GLOBALS['message'] = "Re-password & new Password are not same, please try again";
        }
    
    else {
        $query = "update user set username = '$uname', faculty_name = '$faculty_name', faculty_id = '$faculty_id', password = '$newpass' where uid='" . htmlspecialchars($_REQUEST['user'], ENT_QUOTES) . "';";
        if (!@executeQuery($query))
            $_GLOBALS['message'] = mysql_error();
        else
            $_GLOBALS['message'] = "User Information is Successfully Updated.";
            $_SESSION['username']=$uname;
            $_SESSION['faculty_name']=$faculty_name;
            $_SESSION['faculty_id']=$faculty_id;
    }
    closedb();
}
else if (isset($_REQUEST['savea'])) {
    /*     * ************************ Step 2 - Case 5 ************************ */
    //Add the new user information in the database
    $result = executeQuery("select max(uid) as usr from user");
    $r = mysqli_fetch_array($result);
    if (is_null($r['usr']))
        $newusr = 1;
    else
        $newusr=$r['usr'] + 1;

    $result = executeQuery("select * from user where username='" . htmlspecialchars($_REQUEST['uname'], ENT_QUOTES) . "';");

    
    	//retrieving values from the form
    	//encrypting password
    	$pass=md5(htmlspecialchars($_REQUEST['password'], ENT_QUOTES));
    	$repass=md5(htmlspecialchars($_REQUEST['repass'], ENT_QUOTES));
    	$uname=htmlspecialchars($_REQUEST['uname'], ENT_QUOTES);
    	$role=htmlspecialchars($_REQUEST['role'], ENT_QUOTES);
        $facultyname=htmlspecialchars($_REQUEST['facultyname'], ENT_QUOTES);
        $facultyid=htmlspecialchars($_REQUEST['facultyid'], ENT_QUOTES);
    	
    if (empty($_REQUEST['uname']) || empty($_REQUEST['password']) || empty($_REQUEST['repass']) || empty($_REQUEST['facultyname']) || empty($_REQUEST['facultyid'])) {
        $_GLOBALS['message'] = "Some of the required Fields are Empty";
    }
        else if(!($repass==$pass)){
        $_GLOBALS['message'] = "Re-password is not mutch, please try again";
        }
     else if (mysqli_num_rows($result) > 0) {
        $_GLOBALS['message'] = "Sorry User Already Exists.";
    } else {
    	
        $query = "insert into user (uid, username, faculty_name, faculty_id, password, role) values($newusr,'" . $uname . "','" . $facultyname . "','" . $facultyid . "','" . $pass."','".$role."')";
        if (!@executeQuery($query)) {
            if (mysqli_error($conn) == 1062) //duplicate value
                $_GLOBALS['message'] = "Given User Name voilates some constraints, please try with some other name.";
            else
                $_GLOBALS['message'] = mysqli_error($conn);
        }
        else
            $_GLOBALS['message'] = "Successfully New User is Created.";
    }
    closedb();
}
require "header_login.php";
?>
    <script>

            $(document).ready(function () {
           
                    $('#demoTable').jTPS( {perPages:[5,12,15,50,'ALL'],scrollStep:1,scrollDelay:30,
                            clickCallback:function () {    
                                    // target table selector
                                    var table = '#demoTable';
                                    // store pagination + sort in cookie
                                    document.cookie = 'jTPS=sortasc:' + $(table + ' .sortableHeader').index($(table + ' .sortAsc')) + ',' +
                                            'sortdesc:' + $(table + ' .sortableHeader').index($(table + ' .sortDesc')) + ',' +
                                            'page:' + $(table + ' .pageSelector').index($(table + ' .hilightPageSelector')) + ';';
                            }
                    });

                    // reinstate sort and pagination if cookie exists
                    var cookies = document.cookie.split(';');
                    for (var ci = 0, cie = cookies.length; ci < cie; ci++) {
                            var cookie = cookies[ci].split('=');
                            if (cookie[0] == 'jTPS') {
                                    var commands = cookie[1].split(',');
                                    for (var cm = 0, cme = commands.length; cm < cme; cm++) {
                                            var command = commands[cm].split(':');
                                            if (command[0] == 'sortasc' && parseInt(command[1]) >= 0) {
                                                    $('#demoTable .sortableHeader:eq(' + parseInt(command[1]) + ')').click();
                                            } else if (command[0] == 'sortdesc' && parseInt(command[1]) >= 0) {
                                                    $('#demoTable .sortableHeader:eq(' + parseInt(command[1]) + ')').click().click();
                                            } else if (command[0] == 'page' && parseInt(command[1]) >= 0) {
                                                    $('#demoTable .pageSelector:eq(' + parseInt(command[1]) + ')').click();
                                            }
                                    }
                            }
                    }

                    // bind mouseover for each tbody row and change cell (td) hover style
                    $('#demoTable tbody tr:not(.stubCell)').bind('mouseover mouseout',
                        function (e) {
                                // hilight the row
                                e.type == 'mouseover' ? $(this).children('td').addClass('hilightRow') : $(this).children('td').removeClass('hilightRow');
                        }
                    );
            });
    </script>
    <style>
        body {
                font-family: Tahoma;
                font-size: 10pt;
        }
        #demoTable thead th {										
                white-space: nowrap;
                overflow-x:hidden;
                padding: 3px;
        }
        #demoTable tbody td{
    									
                padding: 3px;
        }
    </style>
</head>
<body>
<?php
if (isset($_GLOBALS['message'])) {
    echo "<div class=\"message\">" . $_GLOBALS['message'] . "</div>";
}
?>
        <div id="container">
             <div class="header">                              
                <?php require'header.php';?>                
                </div>
            <form name="usermng" action="usermng.php" method="post">
                <div class="menubar">


                    <ul id="menu">
<?php
if (isset($_SESSION['username'])) {
// Navigations
?>
                        <li><input type="submit" value="LogOut" name="logout" class="btn btn-success" title="Log Out"/></li>
                        <li><input type="submit" value="DashBoard" name="dashboard" class="subbtn" title="Dash Board"/></li>
                        

<?php
    //navigation for Add option
    if (isset($_REQUEST['add'])) {
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savea" class="subbtn" onclick="validateform('usermng')" title="Save the Changes"/></li>

<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('usermng')" title="Save the changes"/></li>

<?php
    } else {  //navigation for Default
?>
        <?php if (isset($_SESSION['rank_level'])) {
            if ($_SESSION['rank_level'] == '2') {
        ?>
                <li><input type="submit" value="Delete" name="delete" class="subbtn" title="Delete" onclick="return confirm('Are you sure you want to delete this program?')"/></li>
                <li><input type="submit" value="Add" name="add" class="subbtn" title="Add"/></li>
        <?php
                }
            }
        ?>
<?php }
} ?>
                    </ul>

                </div>
                <div class="page">
<?php
if (isset($_SESSION['username'])) {
    echo "<div class=\"pmsg\" style=\"text-align:center;\">Users Management </div>";
    if (isset($_REQUEST['add'])) {
        /*         * ************************ Step 3 - Case 1 ************************ */
        //Form for the new user
?>
                    <table style="text-align:left;"class="container table table-even">
                        <br><br>
                        <tr>
                            <td>User Name</td> 
                            <td><input type="text" name="uname" class="" placeholder="username" value="<?php if (isset($_POST['uname'])) { echo $_POST['uname']; } ?>"  size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('User Name field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td>Faculty Fullname</td> 
                            <td><input type="text" name="facultyname" placeholder="Faculty name" class="" value="<?php if (isset($_POST['facultyname'])) { echo $_POST['facultyname']; } ?>"  size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Faculty Name field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td>Faculty ID</td> 
                            <td><input type="text" placeholder="Example: ( FNS )" title="an example of Faculty Id is : ( FNS )" name="facultyid" class="" value="<?php if (isset($_POST['facultyid'])) { echo $_POST['facultyid']; } ?>"  size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Faculty Name field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td>Password</td>
                            <td><input type="password" name="password" placeholder="password" value=""  class="" size="16" onkeyup="isalphanum(this)"  onblur="if(this.value==''){alert('Password field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td>Re-type Password</td>
                            <td><input type="password" name="repass" value=""  size="16" class="" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Re-type Password field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td> Role</td>
                            <td><select name="role" id="textbox" class=""><option value="Administrator">Administrator</td>
                            
                        </tr>

                    </table><br><br>

<?php
    } else if (isset($_REQUEST['edit'])) {
        /*         * ************************ Step 3 - Case 2 ************************ */
        // To allow Editing Existing User Information
        $result = executeQuery("select * from user where username='" . htmlspecialchars($_REQUEST['edit'], ENT_QUOTES) . "';");
        if (mysqli_num_rows($result) == 0) {
            header('Location: usermng.php');
        } else if ($r = mysqli_fetch_array($result)) {

            //editing components
?>
                    <table class="table table-responsive" style="text-align:left;" >
                        <tr>
                            <td>User Name</td> 
                            <td><input type="text" name="uname" value="<?php echo htmlspecialchars_decode($r['username'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('User Name field is Empty');this.focus();this.value='';}"/></td>
                        </tr>

                        <tr>
                            <td>Faculty Name</td> 
                            <td><input type="text" name="faculty_name" value="<?php echo htmlspecialchars_decode($r['faculty_name'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Faculty Name field is Empty');this.focus();this.value='';}"/></td>
                        </tr>

                        <tr>
                            <td>Faculty ID</td> 
                            <td><input type="text" name="faculty_id" value="<?php echo htmlspecialchars_decode($r['faculty_id'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Faculty ID field is Empty');this.focus();this.value='';}"/></td>
                        </tr>

                        <tr>
                            <td>Old Password</td>
                            <td><input type="password" name="password" value="<?php echo htmlspecialchars($r['password'], ENT_QUOTES); ?>" size="16" onkeyup="isalphanum(this)"  onblur="if(this.value==''){alert('Password field is Empty');this.focus();this.value='';}"/></td>
                        </tr>
                         <tr>
                            <td>New Password</td>
                            <td><input type="password" name="newpass" value=""  size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('New Password field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td>Re-type Password</td>
                            <td><input type="password" name="repass" value=""  size="16" onkeyup="isalphanum(this)" onblur="if(this.value==''){alert('Re-type Password field is Empty');this.focus();this.value='';}"/></td>

                        </tr>
                        <tr>
                            <td> Role</td>
                            <td><select name="role" id="textbox" ><option value="<?php echo htmlspecialchars_decode($r['role'], ENT_QUOTES); ?>"><?php echo htmlspecialchars_decode($r['role'], ENT_QUOTES); ?>
                            <input type="hidden" name="user" value="<?php echo htmlspecialchars_decode($r['uid'], ENT_QUOTES); ?>"/></td>
                        </tr>                        
                    </table>
<?php
                    closedb();
                }
            } else {
                /*                 * ************************ Step 3 - Case 3 ************************ */
                // Defualt Mode: Displays the Existing Users, If any.
                $result = executeQuery("select * from user order by uid;");
                if (mysqli_num_rows($result) == 0) {
                    echo "<h3 style=\"color:#0000cc;text-align:center;\">No Users Yet..!</h3>";
                } else {
                    $i = 0;
?>
                    <table id="demoTable" cellpadding="30" cellspacing="10" class="datatable"> 
                    <thead>
                        <tr>                       	
                            <th>&nbsp;</th>
                            <th>S.No.</th>
                            <th>User Name</th>
                            <th>Faculty Name</th>
                            <th>Facilty ID</th>
                            <th>Passowrd</th>
                            <th>Role</th>
                            <th>Edit</th>                          
                        </tr>
                         </thead>
                        <tbody>
<?php
                    while ($r = mysqli_fetch_array($result)) {
                        $i = $i + 1;
                        if ($i % 2 == 0)
                            echo "<tr class=\"alt\">";
                        else
                            $link_edit = "";
                            if (isset($_SESSION['rank_level']) && isset($_SESSION['uid']) && isset($_SESSION['username'])) {
                                if ($_SESSION['rank_level'] == '2') {
                                    $link_edit = "<a title=\"Edit " . htmlspecialchars_decode($r['uid'], ENT_QUOTES) . "\"href=\"usermng.php?edit=" . htmlspecialchars_decode($r['username'], ENT_QUOTES) . "\"><img src=\"images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>";
                                } else if ($_SESSION['rank_level'] == '1') {
                                    if (htmlspecialchars_decode($r['username'], ENT_QUOTES) == $_SESSION['username']) {
                                        $link_edit = "<a title=\"Edit " . htmlspecialchars_decode($r['uid'], ENT_QUOTES) . "\"href=\"usermng.php?edit=" . htmlspecialchars_decode($r['username'], ENT_QUOTES) . "\"><img src=\"images/edit.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a>";
                                    }
                                }
                            }
                            echo "<tr>";
                        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['uid'] . "\" /></td><td>$i</td><td>" . htmlspecialchars_decode($r['username'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['faculty_name'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['faculty_id'], ENT_QUOTES)
                        . "</td><td>" . htmlspecialchars_decode($r['password'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['role'], ENT_QUOTES) . "</td>"
                        . "<td class=\"tddata\">$link_edit</td> </tr>";
                    }
?>

					</tbody>
    	<tfoot class="nav">
           	<tr>
                <td colspan=6 ><font color="#000000">
                    <div class="pagination"></div>
                    <div class="paginationTitle">Page</div>
                    <div class="selectPerPage"></div>
                    <div class="status"></div>
    			</font></td>
            </tr>
        </tfoot>
                    </table>
<?php
                }
                closedb();
            }
        }
?>

                </div>
            </form>
            <?php include'footer.php';?>  
        </div>
    </body>
</html>

