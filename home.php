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
        .card:hover {
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
          echo $_SESSION['user_email'];
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

        <!-- carousel for homepage image -->
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-11">
                    <div id="homecarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $directory = './static/carousel';
                            $count = 0;
                            foreach (scandir($directory) as $file) {
                              if ($file !== '.' && $file !== '..') {
                                if ($count == 0) {
                                  echo "<div class='carousel-item active'>
                                      <img src='./static/carousel/{$file}' class='d-block w-100'>
                                      </div>";
                                  $count = $count + 1;
                                } else {
                                  echo "<div class='carousel-item'>
                                      <img src='./static/carousel/{$file}' class='d-block w-100'>
                                      </div>";
                                }
                              }
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#homecarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#homecarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- carousel for homepage image end -->


        <!-- booklist -->
        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌所有書籍</h4>
                </div>
            </div>
        </div>

        <div class="container text-center pb-4">
            <div class="row">
                <?php
                include("mysql_connect.inc.php");
                $sql = "SELECT * FROM book;";
                $result = mysqli_query($conn, $sql);

                for ($i = 0; $i < mysqli_num_rows($result); $i++) {
                  while ($book = mysqli_fetch_assoc($result)) { ?>
                <div class="col-3 py-2 hoverable">
                    <a href=" book.php?book_id=<?php echo $book['BOOK_ID']; ?>"
                        class=" text-decoration-none card h-100 rounded-3">
                        <div>
                            <img class="img-top pt-3 pb-1" width="150"
                                src="./static/books/<?php echo $book['BOOK_IMAGE']; ?>">
                        </div>
                        <div class="card-body">
                            <div class="card-text small fw-bolder"> <?php echo $book['BOOK_NAME']; ?> </div>
                        </div>
                    </a>
                </div>
                <?php }
                }
                ?>
            </div>
        </div>
        <!-- booklist end -->


        <!-- footer -->
        <nav class="navbar navbar-dark navbar-expand-lg" style="background-color: #052b47;">
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