<?php session_start(); include("mysql_connect.inc.php");?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
        
    <?php
    $query = "SELECT * FROM book JOIN author USING(AUTHOR_ID) JOIN edition USING(BOOK_ID) JOIN publisher USING(PUBLISHER_ID);";
    $query_run = mysqli_query($conn,$query);
    ?>
        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌書籍清單 Book List </h4>
                </div>
        </div>
        <div class="container">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>書籍索引</th>
                    <th>書籍名稱</th>
                    <th>作者姓氏</th>
                    <th>作者名字</th>
                    <th>ISBN-10</th>
                    <th>ISBN-13</th>
                    <th>出版社</th>
                    <th>出版日期</th>
                    <th>單價</th>
                    <th>庫存</th>
                    <th>書籍簡介</th>
                    <th>動作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(mysqli_num_rows($query_run)!==0){
                    foreach($query_run as $row);
                }
                ?>
                <tr>
                    <td><?php echo $row['BOOK_ID'];?></td>
                    <td>
                        <img width="100" src="static/book/<?php echo $row['BOOK_IMAGE'];?>">
                        <?php echo $row['BOOK_NAME'];?></td>
                    <td><?php echo $row['AUTHOR_LNAME'];?></td>
                    <td><?php echo $row['AUTHOR_FNAME'];?></td>
                    <td><?php echo $row['EDITION_ISBN10'];?></td>
                    <td><?php echo $row['EDITION_ISBN13'];?></td>
                    <td><?php echo $row['PUBLISHER_NAME'];?></td>
                    <td><?php echo $row['EDITION_PUBDATE'];?></td>
                    <td><?php echo $row['EDITION_PRICE'];?></td>
                    <td><?php echo $row['EDITION_INVENTORY'];?></td>
                    <td><?php echo $row['BOOK_INTRO'];?></td>
                <td>
                    <a href="editbook.php?EDITION_ISBN10=<?php echo $row['EDITION_ISBN10']; ?>" class="btn btn-sm btn-dark" title="Edit"><i class="fa-solid fa fa-edit"></i></a>
                    <a href="deletebook.php?EDITION_ISBN10=<?php echo $row['EDITION_ISBN10']; ?>" class="btn btn-sm btn-danger" title="Delete" onclick="if(confirm('Are you sure to delete this book?') === false) event.preventDefault()"><i class="fa-solid fa-trash"></i></a>
                </td>
                </tr>
            </tbody>
        </table>
        </div>
    
    
    
    
    
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script>
    </body>