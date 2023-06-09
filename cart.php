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

        <!-- cart item info -->
        <?php
        $user_id = $_SESSION['user_id'];

        include("mysql_connect.inc.php");
        $cart_items = "SELECT BOOK_ID, BOOK_NAME, EDITION_ID, EDITION_NAME, EDITION_PRICE, CART_ITEM_COUNT, EDITION_INVENTORY FROM cart_item NATURAL JOIN edition NATURAL JOIN book where cart_item.USER_ID = {$user_id};";
        $cart_items_result = (mysqli_query($conn, $cart_items));
        ?>

        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌我的購物車</h4>
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>書名</th>
                        <th>版本</th>
                        <th>單價</th>
                        <th>數量</th>
                        <th>總價</th>
                        <th>刪除商品</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    for ($i = 0; $i < mysqli_num_rows($cart_items_result); $i++) {
                        while ($cart_item = mysqli_fetch_assoc($cart_items_result)) {
                            $total_price = $cart_item['CART_ITEM_COUNT'] * $cart_item['EDITION_PRICE'];
                            $total += $total_price;
                            ?>
                    <form method="POST" action="update_cart.php">
                        <input type="hidden" name="edition_id" id="edition_id"
                            value=<?php echo $cart_item['EDITION_ID']; ?> />
                        <tr>
                            <td><a href="/book.php?book_id=<?php echo $cart_item['BOOK_ID']; ?>"
                                    style='color: #052b47;' target="_blank"><?php echo $cart_item['BOOK_NAME']; ?></a></td>
                            <td><?php echo $cart_item['EDITION_NAME']; ?></td>
                            <td><?php echo $cart_item['EDITION_PRICE']; ?></td>
                            <td><select class="form-select" id="count" name="count" required style="width: 100px;"
                                    onchange="this.form.submit()">
                                    <?php for ($i = 1; $i <= $cart_item['EDITION_INVENTORY']; $i++) {
                                                if ($i == $cart_item['CART_ITEM_COUNT']) {
                                                    echo "<option value={$i} selected >{$i}</option>";
                                                } else {
                                                    echo "<option value={$i} >{$i}</option>";
                                                }
                                            } ?> </select></td>
                            <td><?php echo $total_price; ?></td>
                            <!-- <td><button type="button" class="btn btn-danger btn-sm">刪除</button></td> -->
                            <td>
                                <input type="button" class="btn btn-outline-dark btn-sm"
                                    onclick="location.href='/remove_cart.php?edition_id='+<?php echo $cart_item['EDITION_ID']; ?>;"
                                    value="刪除" />
                            </td>
                        </tr>
                    </form>
                    <?php
                        }
                    } ?>
                </tbody>
            </table>
            <?php
            if (mysqli_num_rows($cart_items_result) == 0) {
                echo "<img src='./static/empty_cart.jpg' width=1200px>";
            } else {
                echo "<div class='container mb-5'><div class='row'></div></div>";
                echo "<div class='container mb-5'><div class='row'></div></div>";
                echo "<div class='container mb-5'><div class='row'></div></div>";

            } ?>
        </div>
        <!-- cart item info end-->

        <!-- total and checkout -->
        <div class="container my-4">
            <hr />
            <div class="row">
                <div class="offset-md-9">
                    <h4 class="fw-bolder">商品總金額 <span class="text-danger">$ <?php echo $total; ?><span><button
                                    type="button" onclick="location.href='/checkout.php';" class="btn btn-danger ms-3" <?php if ($total == 0) {
                                        echo "disabled";
                                    } ?>>結帳</button>
                    </h4>
                </div>
            </div>
        </div>
        <!-- total and checkout end -->

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

        <link href=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous">
        </script>
    </body>

</html>