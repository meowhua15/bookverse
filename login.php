<?php session_start(); ?>
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
        if ($_SESSION['register_message'] == 'Success') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  註冊成功！請再次登入
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['register_message']);
        }
        if ($_SESSION['register_message'] == 'Duplicate') {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  此電子郵件已註冊，請直接登入
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['register_message']);
        }
        if ($_SESSION['login_message'] == 'Fail') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  登入失敗，請確認帳號密碼輸入正確
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['login_message']);
        }
        if ($_SESSION['login_message'] == 'Cart') {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  請先登入，再新增商品至購物車
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['login_message']);
        }
        ?>

        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌登入 Login </h4>
                </div>
            </div>
        </div>
        <div class="card container mb-5" style="background-color: #fbfbfb;">
            <div class="card-body p-4" style="background-color: #fbfbfb;">
                <form class="needs-validation" method="POST" action="connect.php" nonvalidate>
                    <div class="row align-items-center mb-4">
                        <div class="col-6 offset-md-3">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="bookverse2023@gmail.com" required>
                            <div id="emailHelpBlock" class="form-text">
                                請輸入註冊時使用之電子郵件
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-6 offset-md-3">
                            <label for="password" class="form-label">登入密碼</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                minlength="8" maxlength="30">
                            <div id="passwordHelpBlock" class="form-text">
                                請注意大小寫
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <button type="submit" class="btn btn-dark col-4 offset-md-4"
                            style="background-color: #0d3b5c;">登入</button>
                    </div>

            </div>
        </div>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script>
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
        </script>

    </body>

</html>