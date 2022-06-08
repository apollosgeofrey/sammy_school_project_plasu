

<?php

/*
***************************************************
*** Student Management System                   ***
***---------------------------------------------***
*** Developer: Dejene Techane                   ***
*** Title: Database Library Functions           ***
***************************************************
*/

include_once 'dbsettings.php';

$conn=false;

function executeQuery($query)
{
    global $conn,$dbserver,$dbname,$dbpassword,$dbusername;
    global $message;
    if (!($conn = mysqli_connect ($dbserver,$dbusername,$dbpassword, $dbname)))
         $message="Cannot connect to server";

    $result=mysqli_query($conn, $query);
    if(!$result)
        $message="Error while executing query.<br/>mysqli Error: ".mysqli_error($conn);
    else
        return $result;

}
function closedb()
{
    global $conn;
    if($conn != false)
     mysqli_close($conn);
}
?>
