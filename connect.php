<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");
$user_email = $_POST['email'];
$user_password = $_POST['password'];

$sql = "SELECT user_email, user_password, user_username, user_id FROM user where user_email = '{$user_email}'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_row($result);

// haven't register
if (mysqli_num_rows($result) == 0) {
    $_SESSION['login_message'] = 'Not Registered';
    echo '<meta http-equiv=REFRESH CONTENT=0;url=register.php>';
} else if ($row[0] == $user_email && $row[1] == $user_password) {
    $_SESSION['username'] = $row[2];
    $_SESSION['user_email'] = $row[0];
    $_SESSION['user_id'] = $row[3];
    echo '<meta http-equiv=REFRESH CONTENT=0;url=home.php>';
} else {
    $_SESSION['login_message'] = 'Fail';
    echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
}
?>