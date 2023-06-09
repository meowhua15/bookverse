<?php session_start();     include("mysql_connect.inc.php");
    $EDITION_ISBN10 = $_GET['EDITION_ISBN10'];


	$query = "DELETE FROM edition WHERE EDITION_ISBN10 = '$EDITION_ISBN10';";
    if (mysqli_query($conn, $query)) {
        // successfully deleted
        $_SESSION['delete_message'] = 'Success';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=inventory.php>';

    } else {
        // failed to delete
        $_SESSION['delete_message'] = 'Fail';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=inventory.php>';

    }
	header("Location: inventory.php");
?>