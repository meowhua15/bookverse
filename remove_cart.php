<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$edition_id = $_GET['edition_id'];

$delete_cart = "DELETE FROM cart_item 
                WHERE user_id = {$_SESSION['user_id']} and edition_id = $edition_id;";
mysqli_query($conn, $delete_cart);
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>