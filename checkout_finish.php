<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
include("mysql_connect.inc.php");

$shipment_type_name = $_POST['shipment_type'];
$pickup_store_id = $_POST['pickup_store'];
$shipment_cs_code = $_POST['cscode'];
$shipment_zipcode = $_POST['zipcode'];
$shipment_city = $_POST['city'];
$shipment_district = $_POST['district'];
$shipment_addr = $_POST['address'];

$payment_type_name = $_POST['payment_type'];
$payment_card_name = $_POST['payment_card_name'];
$payment_card_date = $_POST['payment_card_date'];
$payment_card_num = $_POST['payment_card_num'];
$payment_card_cvc = $_POST['payment_card_cvc'];

$invoice_type_name = $_POST['invoice_type'];
$invoice_info = $_POST['invoice_info'];

echo $shipment_type_name, $pickup_store_id, $shipment_cs_code, $shipment_zipcode, $shipment_city, $shipment_district, $shipment_addr;
echo $payment_type_name, $payment_card_name, $payment_card_date, $payment_card_num, $payment_card_cvc;
echo $invoice_type_name, $invoice_info;

// $check_exist = "SELECT USER_EMAIL FROM USER WHERE USER_EMAIL = '{$user_email}';";
// if (mysqli_num_rows(mysqli_query($conn, $check_exist)) !== 0) {
//     // already registered
//     $_SESSION['register_message'] = 'Duplicate';
//     echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';
// } else {
//     $register = "INSERT INTO USER (user_username, user_email, user_password, user_lname, user_fname, user_birthday, user_gender, user_phone, user_zipcode, user_city, user_district, user_addr, user_vip) 
//             VALUES ('{$user_username}', '{$user_email}', '{$user_password}', '{$user_lname}', '{$user_fname}', '{$user_birthday}', {$user_gender}, '{$user_phone}', '{$user_zipcode}', '{$user_city}', '{$user_district}', '{$user_addr}', 0);";
//     if (mysqli_query($conn, $register)) {
//         // successfully registered
//         $_SESSION['register_message'] = 'Success';
//         echo '<meta http-equiv=REFRESH CONTENT=0;url=login.php>';

//     } else {
//         // failed to register
//         $_SESSION['register_message'] = 'Fail';
//         echo '<meta http-equiv=REFRESH CONTENT=0;url=register.php>';

//     }
// }
?>