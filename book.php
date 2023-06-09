<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="zh-Hant">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/55ecebca52.js" crossorigin="anonymous"></script>
        <title>BookVerse</title>
        <style>
        .bookcard:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
        }
        </style>
    </head>

    <body>
        <!-- navbar -->
        <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #052b47;">
            <div class="container-fluid">
                <a class="navbar-brand" style="margin-left: 8px; margin-right:2px;" href="home.php"><i
                        class="fa-solid fa-book-atlas"></i> BookVerse</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="px-3 py-2" style="width: 840px;">
                    <form class=" d-flex" role="search">
                        <input class="form-control me-2" type="Search" placeholder="輸入關鍵字看好書" aria-label="Search">
                        <button class="bg-transparent border-0 shadow-none" type="submit"><i
                                class="fa-solid fa-magnifying-glass" style="color: white;"></i></button>
                    </form>
                </div>
                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto">
                        <?php
                        if ($_SESSION['username'] == null) {
                            echo "<li class='nav-item'>
                                  <a class='nav-link' href='login.php'><i class='fa-solid fa-circle-user me-2'></i><b>登入</b></a>
                                </li>
                                <li class='nav-item'>
                                  <a class='nav-link px-0 disabled'><b>|</b></a>
                                </li>
                                <li class='nav-item'>
                                  <a class='nav-link' href='register.php'><b>註冊</b></a>
                                </li>";
                        } else {
                            echo "<li class='nav-item dropdown'>
                                <a class='nav-link dropdown-toggle' href='#' role='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                <i class='fa-solid fa-user me-1'></i>
                                <b>{$_SESSION['username']}</b></a>
                                <ul class='dropdown-menu'>
                                  <li><a class='dropdown-item' href='user_order.php'><i class='fa-solid fa-receipt me-1'></i>我的訂單</a></li>
                                  <li><a class='dropdown-item' href='user_profile.php'><i class='fa-solid fa-pen me-1'></i>會員資料</a></li>
                                  <li><a class='dropdown-item' href='logout.php'><i class='fa-solid fa-right-from-bracket me-1'></i>登出</a></li>
                                </ul></li>";
                            echo "<li class='nav-item'>
                                  <a class='nav-link px-0 disabled'><b>|</b></a>
                                </li>";
                            echo "<li class='nav-item'>
                                  <a class='nav-link' href='cart.php'><i class='fa-solid fa-cart-shopping me-2'></i><b>購物車</b></a>
                                </li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- navbar end -->

        <?php
        if ($_SESSION['modify_message'] == 'Success') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  會員資料修改成功
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['modify_message']);
        }
        if ($_SESSION['modify_message'] == 'Fail') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  會員資料修改失敗，請重新修改
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['modify_message']);
        }
        if ($_SESSION['modify_message'] == 'Duplicate') {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  該電子郵件已被註冊，請重新修改
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['modify_message']);
        }
        ?>

        <?php
        // Get book and edition information
        $book_id = $_GET['book_id'];

        include("mysql_connect.inc.php");
        $book = "SELECT * FROM book WHERE BOOK_ID = {$book_id};";
        $book_result = mysqli_fetch_assoc((mysqli_query($conn, $book)));
        // var_dump($book_result);
        $book_author = "SELECT AUTHOR_LNAME, AUTHOR_FNAME FROM book NATURAL JOIN author
                        WHERE BOOK_ID = {$book_id};";
        $author_result = mysqli_fetch_assoc((mysqli_query($conn, $book_author)));
        $edition = "SELECT * FROM book NATURAL JOIN edition NATURAL JOIN publisher
                        WHERE BOOK_ID = {$book_id};";
        $edition_result = mysqli_query($conn, $edition);
        ?>

        <!-- book information -->
        <div class="container-fluid mb-5">
            <div class="row mt-5">
                <div class="col-3 offset-md-1">
                    <img class="" width="250" src="./static/books/<?php echo $book_result['BOOK_IMAGE']; ?>">
                </div>
                <div class=" col-7 card border-0">
                    <div class="card-body">
                        <h3 class="card-title fw-bolder"><?php echo $book_result['BOOK_NAME']; ?></h3>
                        <p class="card-text fw-bolder">
                            作者｜<?php echo "{$author_result['AUTHOR_LNAME']} {$author_result['AUTHOR_FNAME']}"; ?>
                        </p>
                        <span class="card-text fw-bolder">簡介</span>
                        <hr class="m-1" />
                        <p class="card-text"><?php echo $book_result['BOOK_INTRO']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- book information end -->

        <!-- Loop through each edition -->
        <div class="container mb-3">
            <div class="row ms-3">
                <div class="col-md-5">
                    <h5>▌可購買版本 </h5>
                </div>
            </div>
        </div>

        <?php
        for ($i = 0; $i < mysqli_num_rows($edition_result); $i++) {
            while ($edition = mysqli_fetch_assoc($edition_result)) { ?>
                <div class="container">
                    <div class="row ms-5 mb-4">
                        <div class="col">
                            <div class="bookcard card text-bg-light">
                                <div class="card-header fw-bolder">
                                    <?php echo $edition['EDITION_NAME']; ?>
                                </div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="card-body">
                                            <text class="card-text">出版社｜<?php echo $edition['PUBLISHER_NAME']; ?></text><br />
                                            <text class="card-text">出版日期｜<?php echo $edition['EDITION_PUBDATE']; ?></text><br />
                                            <text
                                                class="card-text">ISBN10｜<?php echo $edition['EDITION_ISBN10']; ?></text><br />
                                            <text
                                                class="card-text">ISBN13｜<?php echo $edition['EDITION_ISBN13']; ?></text><br />
                                        </div>
                                    </div>
                                    <div class="col-3 align-self-end">
                                        <div class="card-body">
                                            <?php if ($edition['EDITION_INVENTORY'] == 0) {
                                                echo "<text class='card-text fw-bolder text-danger'>很抱歉，此版本暫無庫存</text>";
                                            } else {
                                                echo "<text class='card-text fw-bolder'>庫存｜{$edition['EDITION_INVENTORY']}</text>";
                                            } ?>
                                            <br /><text class="card-text fw-bolder">售價｜<?php echo $edition['EDITION_PRICE']; ?>
                                                元</text>
                                        </div>
                                    </div>
                                    <div class="col-4 align-self-end">
                                        <div class="card-body">
                                            <form class="row" method="POST" action="add_to_cart.php">
                                                <input type="hidden" name="edition_id"
                                                    value=<?php echo $edition['EDITION_ID']; ?> />
                                                <div class="col-4">
                                                    <select class=" form-select" id="count" name="count" required <?php if ($edition['EDITION_INVENTORY'] == 0) {
                                                        echo "disabled";
                                                    } ?>>
                                                        <?php for ($i = 1; $i <= $edition['EDITION_INVENTORY']; $i++) {
                                                            echo "<option value={$i}>{$i}</option>";
                                                        } ?> </select>
                                                </div>
                                                <div class="col-8">
                                                    <button type="submit" class="btn btn-outline-secondary" <?php if ($edition['EDITION_INVENTORY'] == 0) {
                                                        echo "disabled";
                                                    } ?>><i class="fa-solid fa-cart-plus"></i>
                                                        加入購物車</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        <!-- edition end -->

        <!-- footer -->
        <nav class=" navbar navbar-dark navbar-expand-lg" style="background-color: #052b47;">
            <div class="container-fluid">
                <span class="navbar-text">© 2023 BookVerse</span>
                <span class="navbar-text"> Made with ♥ by DBMS group 13 </span>
                <ul class="navbar-nav navbar-left">
                    <li class='nav-item'>
                        <a class='nav-link' href='privacy.php'><b>隱私權政策</b></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link px-0 disabled'><b>|</b></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='userterms.php'><b>使用者條款</b></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link px-0 disabled'><b>|</b></a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='admin.php'><b>系統管理員</b></a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- footer end -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous">
        </script>
    </body>

</html>