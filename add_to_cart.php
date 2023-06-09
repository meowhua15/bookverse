<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$edition_id = $_POST['edition_id'];
$edition_item_count = $_POST['count'];

// check if user is logged in
if (!$_SESSION['username']) {
    $_SESSION['login_message'] = 'Cart';
    echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
} else {
    $found_cart = "SELECT * FROM cart_item WHERE user_id = {$_SESSION['user_id']} and edition_id = $edition_id;";
    if (mysqli_num_rows(mysqli_query($conn, $found_cart)) !== 0) {
        $update_cart = "UPDATE cart_item 
                        SET cart_item_count = {$edition_item_count}
                        WHERE user_id = {$_SESSION['user_id']} and edition_id = $edition_id;";
        mysqli_query($conn, $update_cart);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    } else {
        $add_to_cart = "INSERT INTO cart_item (user_id, edition_id, cart_item_count) 
                    VALUES ({$_SESSION['user_id']}, $edition_id, $edition_item_count);";
        mysqli_query($conn, $add_to_cart);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}
?>