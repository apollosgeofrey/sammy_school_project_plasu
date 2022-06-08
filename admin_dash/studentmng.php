
<?php
 /*
 * ** Title: Student Management(Add,delete,Modify) ***
 * ***************************************************
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
  Case 3 : Delete - Delete the selected Student/s from System.
  Case 4 : Edit - Update the new information.
  Case 5 : Add - Add new student to the system.

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
    header('Location:index.php');
} else if (isset($_REQUEST['dashboard'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: admwelcome.php');
} else if (isset($_REQUEST['ins'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: insmng.php');
} else if (isset($_REQUEST['std'])) {
    /*     * ************************ Step 2 - Case 2 ************************ */
    //redirect to dashboard

    header('Location: importstd.php');

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
            <form name="stdmng" action="studentmng.php" method="post">
                <div class="menubar" id="menubar" name="menubar">


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
<?php
    } else if (isset($_REQUEST['edit'])) { //navigation for Edit option
?>
                        <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
                        <li><input type="submit" value="Save" name="savem" class="subbtn" onclick="validateform('stdmng')" title="Save the changes"/></li>

<?php
    } else if(isset($_REQUEST['view'])){
    	?>
    	 <li><input type="submit" value="Cancel" name="cancel" class="subbtn" title="Cancel"/></li>
         <li> <input type="submit" name="print" value="Print" onclick="tablePrint();" class="subbtn"></li> 
         <script>
function tablePrint(){ 
 document.all.menubar.style.visibility = 'hidden';  
    var display_setting="toolbar=no,location=no,directories=no,menubar=no,";  
    display_setting+="scrollbars=no,width=auto, height=auto, left=100, top=25";  
 //   var tableData = '<table border="1">'+document.getElementsByTagName('table')[0].innerHTML+'</table>';
    var content_innerhtml = document.getElementById("printout").innerHTML;  
    var document_print=window.open("","",display_setting);  
    document_print.document.open();  
    document_print.document.write('<body style="font-family:verdana; font-size:12px;" onLoad="self.print();self.close();" >');  
    document_print.document.write(content_innerhtml);  
    document_print.document.write('</body></html>');  
    document_print.print();  
    document_print.document.close(); 
   
    return false;  
    } 
  $(document).ready(function() {
    oTable = jQuery('#example').dataTable({
    "bJQueryUI": true,
    "sPaginationType": "full_numbers"
    } );
  });   
</script>
<?php
    	
    }else {  //navigation for Default
?>
                        
                        <li><input type="submit" value="Add" name="std" class="subbtn" title="Add" title="Add new Student Profile"/></li>
                       
<?php }
} ?>
                    </ul>

                </div>
                <div class="page">
<?php
if (isset($_SESSION['username'])) {
    
    if (isset($_REQUEST['view'])) {
        /*         * ************************ Step 3 - Case 1 ************************ */
        //view student details
         $rslt = executeQuery("select * from auto_id_generate where id=".$_REQUEST['view']."  order by id;");                  
         while($r1=mysqli_fetch_array($rslt)){
?>
         		 <span id="printout" class="">
    <table style="text-align:left;" id="datatable" class="">
	   <tr>
	       <td colspan='2'> <!-- <img style="margin:10px 2px 2px 10px;float:left;" height="90" width="100" src="" alt="Attach Photo Here"/> -->
                <h4 style="color:#0000cc;text-align:center;"><u><i>PLATEAU STATE UNIVERSITY, BOKKOS</i> </u> </h4>
            </td> 
        </tr>
        <tr>
            <td colspan='2'>
                <h5 style="color:#0000cc;text-align:center;"><u><i>STUDENT SOFT IDENTIFICATION</i> </u> </h5>
            </td> 
        </tr>      
        <tr>
            <td>
		      <b>College :</b>
            </td>
            <td>
                Plateau State University 
            </td>
        </tr>
        <tr>
            <td>
              <b>Name :</b>
            </td>
            <td>
                <?php echo htmlspecialchars_decode($r1['name'],ENT_QUOTES); ?>
            </td>
        </tr>
        <tr>
            <td>
              <b>Matriculation Number :</b>
            </td>
            <td>
                <?php echo htmlspecialchars_decode($r1['mat_number'],ENT_QUOTES); ?> 
            </td>
        </tr>
        <tr>
            <td>
              <b>Gender :</b>
            </td>
            <td>
                <?php echo htmlspecialchars_decode($r1['sex'],ENT_QUOTES); ?> 
            </td>
        </tr>
        <tr>
            <td>
              <b>Faculty : </b>
            </td>
            <td>
                <?php echo htmlspecialchars_decode($r1['faculty'],ENT_QUOTES); ?> 
            </td> 
        </tr>
        <tr>
            <td>
		      <b>Department : </b>
            </td>
            <td>
                <?php echo htmlspecialchars_decode($r1['department'],ENT_QUOTES); ?> 
            </td> 
        </tr>
        <tr>
            <td>
              <b>Nationality :</b>
            </td>
            <td>
                <?php echo "NIGERIAN" ?> 
            </td>
        </tr>
        <tr>
            <td>
              <b>Occupation :</b>
            </td>
            <td>
                <?php echo "Student" ?> 
            </td>
        </tr>
        <tr>
            <td>
              <b>Printout Date :</b>
            </td>
            <td>
                <?php echo date('M, d/Y');?> 
            </td>
        </tr>
        <tr>
            <td>
              <b>Signature :</b>
            </td>
            <td>
                <?php echo "_____________________________" ?> 
            </td>
        </tr>          
        <?php
			}
        ?>          
    </table>
</span><br>
                   

<?php
    }  else {
                /*                 * ************************ Step 3 - Case 3 ************************ */
                // Defualt Mode: Displays the Existing Users, If any.
                if (isset($_SESSION['rank_level'])) {
                    if ($_SESSION['rank_level'] == '2') {
                        $result = executeQuery("select * from auto_id_generate order by id desc;");
                    } else {
                        $result = executeQuery("select * from auto_id_generate where uid=".$_SESSION['uid']." order by id desc;");
                    }
                }
                if (mysqli_affected_rows($conn) == 0) {
                    echo "<h3 class='alert alert-success'>No Students Record Found For <u>" . $_SESSION['faculty_name'] . "</u> Faculty..!</h3>";
                } else {
                    $i = 0;
?>

                    <table id="demoTable" cellpadding="30" cellspacing="10" class="datatable">   
                    <thead>
                        <tr>                        	
                            <th>&nbsp;</th>
                            <th>S.No.</th>
                            <th>Jamb Reg. No.</th>
                            <th>Matric No.&lt;Auto generated&gt;</th>
                            <th>Full Name</th>
                            <th>Sex</th>
                            <th>Dept.</th>                        
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
<?php
    while ($r = mysqli_fetch_array($result)) {
        $i = $i + 1;
        if ($i % 2 == 0)
            echo "<tr class=\"alt\">";
        else                                       
            echo "<tr>";
        echo "<td style=\"text-align:center;\"><input type=\"checkbox\" name=\"d$i\" value=\"" . $r['id'] . "\" /></td><td>$i</td><td>" . htmlspecialchars_decode($r['jame_reg_no'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['mat_number'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['name'], ENT_QUOTES)
        . "</td><td>" . htmlspecialchars_decode($r['sex'], ENT_QUOTES) . "</td><td>" . htmlspecialchars_decode($r['department'], ENT_QUOTES) . "</td>"
        
       
         . "<td class=\"tddata\"><a title=\"View " . htmlspecialchars_decode($r['id'], ENT_QUOTES) . "\"href=\"studentmng.php?view=" . htmlspecialchars_decode($r['id'], ENT_QUOTES) . "\"><img src=\"images/detail.png\" height=\"30\" width=\"40\" alt=\"Edit\" /></a></td></tr>";
    
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
								</font>
                        </td>
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

