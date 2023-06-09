<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="zh-Hant">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://kit.fontawesome.com/55ecebca52.js" crossorigin="anonymous"></script>
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
                                  <li><a class='dropdown-item' href='user_order.php'><i class='fa-solid fa-receipt me-1'></i> 我的訂單</a></li>
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

        <div class="container mt-5 mb-3">
            <div class="row">
                <div class="col-3">
                    <h4>▌管理員介面 Admin </h4>
                </div>
            </div>
        </div>



        <div class="container">
            <div class="row">
                <div class="col-2">
                    <div class="card">
                        <div class="card-header"><b>工作列表</b></div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a class='nav-link' href='order.php'>訂單總覽</a>
                            </li>
                            <li class="list-group-item">
                                <a class='nav-link' href='add_book.php'>新增商品</a>
                            </li>
                            <li class="list-group-item">
                                <a class='nav-link' href='add_shipment.php'>新增運送方式</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="true" href="#">分頁1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#">分頁2</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><b>訂單總覽</b></h5>
                            <p class="card-text">訂單ㄉ表格</p>
                            <a href="#" class="btn btn-primary">儲存變更</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




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