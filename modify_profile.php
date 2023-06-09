<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$user_email = $_POST['email'];
$user_gender = $_POST['gender'];
$user_phone = $_POST['phone'];
$user_zipcode = $_POST['zipcode'];
$user_city = $_POST['city'];
$user_district = $_POST['district'];
$user_addr = $_POST['address'];


$modify = "UPDATE USER 
            SET user_email = '{$user_email}',
                user_gender = {$user_gender},
                user_phone =  '{$user_phone}',
                user_zipcode =  '{$user_zipcode}',
                user_city = '{$user_city}', 
                user_district = '{$user_district}', 
                user_addr = '{$user_addr}'
            WHERE user_email = '{$_SESSION['user_email']}';";

$check_exist = "SELECT USER_EMAIL FROM USER WHERE USER_EMAIL = '{$user_email}';";
if ($_SESSION['user_email'] != mysqli_fetch_row(mysqli_query($conn, $check_exist))[0] & mysqli_num_rows(mysqli_query($conn, $check_exist)) !== 0) {
    // modify to an already registered email
    $_SESSION['modify_message'] = 'Duplicate';
    echo '<meta http-equiv=REFRESH CONTENT=0;url=home.php>';
} else {
    if (mysqli_query($conn, $modify)) {
        // successfully modified
        $_SESSION['user_email'] = $user_email;
        $_SESSION['modify_message'] = 'Success';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=home.php>';

    } else {
        // failed to modify
        $_SESSION['modify_message'] = 'Fail';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=home.php>';
    }
}
?>