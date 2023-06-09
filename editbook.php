<?php session_start(); include("mysql_connect.inc.php");
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="zh-Hant">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/55ecebca52.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="./static/register.css">
        <title>BookVerse</title>
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
        if ($_SESSION['update_message'] == 'Fail') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  更新失敗，請重新操作。
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['update_message']);
        }
        ?>

        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌編輯書籍 Edit Book </h4>
                </div>
            </div>
        </div>
        <div class="card container mb-5" style="background-color: #fbfbfb;">
            <div class="card-body p-4" style="background-color: #fbfbfb;">
                <form class="needs-validation" method="POST" action="insert_finish.php" data-toggle="validator"
                    novalidate>
                    <div class="row align-items-center mb-4">
                        <div class="col-12">
                            <label for="BOOK_NAME" class="form-label">書籍名稱</label>
                            <input type="text" class="form-control" id="BOOK_NAME" name="BOOK_NAME">
                        </div>
                    </div>  
                    <div class="row align-items-center mb-4">
                        <div class="col-6">
                            <label for="AUTHOR_LNAME" class="form-label">作者姓氏</label>
                            <input type="text" class="form-control" id="AUTHOR_LNAME" name="AUTHOR_LNAME">
                        </div>
                        <div class="col-6">
                            <label for="AUTHOR_FNAME" class="form-label">作者名字</label>
                            <input type="text" class="form-control" id="AUTHOR_FNAME" name="AUTHOR_FNAME">
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-6">
                            <label for="EDITION_ISBN10" class="form-label">ISBN-10</label>
                            <input type="text" class="form-control" id="EDITION_ISBN10" name="EDITION_ISBN10">
                        </div>
                        <div class="col-6">
                            <label for="EDITION_ISBN13" class="form-label">ISBN-13</label>
                            <input type="text" class="form-control" id="EDITION_ISBN13" name="EDITION_ISBN13">
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-6">
                            <label for="PUBLISHER_NAME" class="form-label">出版社</label>
                            <input type="text" class="form-control" id="PUBLISHER_NAME" name="PUBLISHER_NAME">
                        </div>
                        <div class="col-6">
                            <label for="EDITION_PUBDATE" class="form-label">出版日期</label>
                            <input type="date" class="form-control" id="EDITION_PUBDATE" name="EDITION_PUBDATE">
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-6">
                            <label for="EDITION_PRICE" class="form-label">單價</label>
                            <input type="text" class="form-control" id="EDITION_PRICE" name="EDITION_PRICE">
                        </div>
                        <div class="col-6">
                            <label for="EDITION_INVENTORY" class="form-label">庫存</label>
                            <input type="text" class="form-control" id="EDITION_INVENTORY" name="EDITION_INVENTORY">
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-12">
                            <label for="BOOK_INTRO" class="form-label">書籍簡介</label>
                            <input type="text" class="form-control" id="BOOK_INTRO" name="BOOK_INTRO">
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-12">
                            <label for="BOOK_IMAGE" class="form-label">書籍照片</label>
                            <input type="file" class="form-control" id="BOOK_IMAGE" name="BOOK_IMAGE">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark"
                        style="float: right; background-color: #0d3b5c;">更新</button>
                    <button type="reset" class="btn btn-dark"
                        style="float: right; background-color: #AA0000;">取消</button>
        
        
        

                        
                        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script>
    </body>