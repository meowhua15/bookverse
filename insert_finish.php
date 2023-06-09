<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php session_start();
include("mysql_connect.inc.php");

$BOOK_NAME = $_POST['BOOK_NAME'];
$AUTHOR_LNAME = $_POST['AUTHOR_LNAME'];
$AUTHOR_FNAME = $_POST['AUTHOR_FNAME'];
$EDITION_ISBN10 = $_POST['EDITION_ISBN10'];
$EDITION_ISBN13 = $_POST['EDITION_ISBN13'];
$PUBLISHER_NAME = $_POST['PUBLISHER_NAME'];
$EDITION_PUBDATE = strtotime($_POST['EDITION_PUBDATE']);
$EDITION_PUBDATE = date('Y-m-d', $EDITION_PUBDATE);
$EDITION_PRICE = $_POST['EDITION_PRICE'];
$EDITION_INVENTORY = $_POST['EDITION_INVENTORY'];
$BOOK_INTRO = $_POST['BOOK_INTRO'];
$BOOK_IMAGE=$_FILES['BOOK_IMAGE']['name'];
$temp_name=$_FILES['BOOK_IMAGE']['tmp_name'];
move_uploaded_file($temp_name,"static/book/$BOOK_IMAGE");


$check_exist = "SELECT EDITION_ISBN10 FROM edition WHERE EDITION_ISBN10 = '{$isbn10}';";
if (mysqli_num_rows(mysqli_query($conn, $check_exist)) !== 0) {
    // already inserted
    $_SESSION['insert_message'] = 'Duplicate';
    echo '<meta http-equiv=REFRESH CONTENT=0;url=inventory.php>';
} else {
    $insert = "INSERT INTO author (AUTHOR_LNAME, AUTHOR_FNAME) 
            VALUES ('{$AUTHOR_LNAME}', '{$AUTHOR_FNAME}');
            INSERT INTO book (BOOK_NAME, BOOK_INTRO, BOOK_IMAGE) 
            VALUES ('{$BOOK_NAME}', '{$BOOK_INTRO}', '{$BOOK_IMAGE}');
            INSERT INTO publisher (PUBLISHER_NAME) 
            VALUES ('{$PUBLISHER_NAME}');
            INSERT INTO edition (EDITION_PRICE, EDITION_INVENTORY, EDITION_ISBN10, EDITION_ISBN13, EDITION_PUBDATE) 
            VALUES ('{$EDITION_PRICE}','{$EDITION_INVENTORY}', '{$EDITION_ISBN10}', '{$EDITION_ISBN13}', '{$EDITION_PUBDATE}');";
    if (mysqli_query($conn, $insert)) {
        // successfully inserted
        $_SESSION['insert_message'] = 'Success';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=inventory.php>';

    } else {
        // failed to insert
        $_SESSION['insert_message'] = 'Fail';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=insert.php>';

    }
}
?>
