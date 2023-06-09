<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$edition_id = $_POST['edition_id'];
$edition_item_count = $_POST['count'];


$update_cart = "UPDATE cart_item 
                SET cart_item_count = {$edition_item_count}
                WHERE user_id = {$_SESSION['user_id']} and edition_id = $edition_id;";
mysqli_query($conn, $update_cart);
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>