
<?php
//error_reporting(0);
include_once 'admin_dash/smsdb.php';
?>
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
  <body>

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
                <div class="header">
                  <div class="col-xs-2"> 
                    <img style="float:left;" height="auto" width="70%" src="admin_dash/images/logo.png" alt="Mat. No. Gen."/>
                  </div>
                  <div class="col-xs-9">
                    <h3 class="headtext col-xs-12 text-center"> &nbsp; Plateau State University</h3>
                    <h5 class="headtext col-xs-12 text-center"><i>...Students Matric No. Search Result...</i> </h5>
                  </div>
                </div>           
                </div>
            <form name="stdmng" action="studentmng.php" method="post">
                <div class="menubar" id="menubar" name="menubar">

<ul id="menu">
<form action="#" method="post">
   <li><a href="index.php" class="btn btn-success" title="Dash Board">DashBoard</a></li>
</form>                        
<?php
    if (isset($_REQUEST['view'])){
    	?>
         <li> <button name="print" onclick="tablePrint();" class="btn btn-success"> Print </button></li> 
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
                       
<?php } ?>
                    </ul>

                </div>
                <div class="page">
<?php
if (isset($_REQUEST['view'])) {
    //view student details
    $rslt = executeQuery("select * from auto_id_generate where jame_reg_no = '".$_REQUEST['view']."'");
    if ($rslt == true && mysqli_affected_rows($conn) == 1) {           
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
        } else {
            $jam_no = $_REQUEST['view'];
            echo "<script>alert('No matriculation number record found for { $jam_no }');
                    window.location.href='search_jamb.php'; </script>";
        }
        ?>          
    </table>
</span><br>
                   

<?php
         closedb();
    } else {
        echo "<script>alert('Jamb Registration Number Not Set!');
                window.location.href='search_jamb.php'; </script>";
    }
?>

                </div>
            </form>
         <?php include'admin_dash/footer.php';?>  
        </div>
    </body>
</html>

