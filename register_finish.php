<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$user_username = $_POST['username'];
$user_email = $_POST['email'];
$user_password = $_POST['password'];
$user_lname = $_POST['lastname'];
$user_fname = $_POST['firstname'];
$user_birthday = strtotime($_POST['birthday']);
$user_birthday = date('Y-m-d', $user_birthday);
$user_gender = $_POST['gender'];
$user_phone = $_POST['phone'];
$user_zipcode = $_POST['zipcode'];
$user_city = $_POST['city'];
$user_district = $_POST['district'];
$user_addr = $_POST['address'];


$check_exist = "SELECT USER_EMAIL FROM USER WHERE USER_EMAIL = '{$user_email}';";
if (mysqli_num_rows(mysqli_query($conn, $check_exist)) !== 0) {
    // already registered
    $_SESSION['register_message'] = 'Duplicate';
    echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
} else {
    $register = "INSERT INTO USER (user_username, user_email, user_password, user_lname, user_fname, user_birthday, user_gender, user_phone, user_zipcode, user_city, user_district, user_addr, user_vip) 
            VALUES ('{$user_username}', '{$user_email}', '{$user_password}', '{$user_lname}', '{$user_fname}', '{$user_birthday}', {$user_gender}, '{$user_phone}', '{$user_zipcode}', '{$user_city}', '{$user_district}', '{$user_addr}', 0);";
    if (mysqli_query($conn, $register)) {
        // successfully registered
        $_SESSION['register_message'] = 'Success';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';

    } else {
        // failed to register
        $_SESSION['register_message'] = 'Fail';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=register.php>';

    }
}
?>