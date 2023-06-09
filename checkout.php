<?php session_start(); ?>
<?php
// Read Taiwan's cities and counties from json
$json = file_get_contents('./static/taiwan_area.json');
$json_data = json_decode($json, true);
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
        include("mysql_connect.inc.php");
        $shipment_type = "SELECT * FROM shipment_type;";
        $shipment_type_result = mysqli_query($conn, $shipment_type);
        $payment_type = "SELECT * FROM payment_type;";
        $payment_type_result = mysqli_query($conn, $payment_type);
        $invoice_type = "SELECT * FROM invoice_type;";
        $invoice_type_result = mysqli_query($conn, $invoice_type);
        $pickup_store = "SELECT * FROM pickup_store;";
        $pickup_store_result = mysqli_fetch_all(mysqli_query($conn, $pickup_store, MYSQLI_ASSOC));
        $user = "SELECT * FROM user WHERE user_id = {$_SESSION['user_id']};";
        $user_result = mysqli_fetch_row(mysqli_query($conn, $user));
        ?>


        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌結帳 Checkout </h4>
                </div>
            </div>
        </div>

        <div class="card container mb-5" style="background-color: #fbfbfb;">
            <div class="card-body p-4" style="background-color: #fbfbfb;">
                <form method="POST" action="checkout_finish.php" data-toggle="validator">

                    <!-- 運送方式 -->
                    <h4 class="fw-bolder" style="color: #0d3b5c;"><i class="fa-solid fa-truck"></i> 運送方式</h4>
                    <hr class="my-3" />
                    <div class="row align-items-center mb-4" id="shipmentrow1">
                        <div class=" col-3">
                            <label for="shipment_type" class="form-label">請選擇運送方式</label>
                            <select class="form-select" id="shipment_type" name="shipment_type"
                                onchange="load_shipment();" required>
                                <?php
                                while ($row = mysqli_fetch_assoc($shipment_type_result)) {
                                    echo "<option value='{$row['SHIPMENT_TYPE_NAME']}'>{$row['SHIPMENT_TYPE_NAME']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- 付款方式 -->
                    <h4 class="fw-bolder" style="color: #0d3b5c;"><i class="fa-solid fa-sack-dollar"></i> 付款方式
                    </h4>
                    <hr class="my-3" />
                    <div class="row align-items-center mb-4" id="paymentrow1">
                        <div class="col-6">
                            <label for="payment_type" class="form-label">付款方式</label>
                            <select class="form-select" id="payment_type" name="payment_type" required onchange="load_payment();">
                                <?php
                                while ($row = mysqli_fetch_assoc($payment_type_result)) {
                                    echo "<option value='{$row['PAYMENT_TYPE_NAME']}'>{$row['PAYMENT_TYPE_NAME']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <!-- 發票方式 -->
                    <h4 class="fw-bolder" style="color: #0d3b5c;"><i class="fa-solid fa-receipt"></i></i> 發票方式</h4>
                    <hr class="my-3"/>
                    <div class="mb-3">※實體發票將隨產品寄出</div>
                    <div class="row align-items-center mb-4">
                        <div class="col-6" id="invoicecol1">
                            <label for="invoice_type" class="form-label">請選擇發票方式</label>
                            <select class="form-select" id="invoice_type" name="invoice_type" required onchange="load_invoice();">
                                <?php
                                while ($row = mysqli_fetch_assoc($invoice_type_result)) {
                                    echo "<option value='{$row['INVOICE_TYPE_NAME']}'>{$row['INVOICE_TYPE_NAME']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark"
                        style="float: right; background-color: #0d3b5c;">確認下訂</button>
            </div>
        </div>

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
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script>
        type = 'text/javascript'
        // Create district dropdown after the user choose the city
        var areas = <?php echo json_encode($json); ?>;
        var area_arr = new Array();
        area_arr = JSON.parse(areas);

        $(document).ready(function() {
            $("#shipment_type").change(load_shipment());
            $("#pickup_store").change(load_pickup_store_addr());
            $("#payment_type").change(load_payment());
            $("#invoice_type").change(load_invoice());
        });

        function load_district() {
            var selected_city = $('#city').val();
            var district = document.getElementById('district')
            district.innerHTML = '';
            var option = document.createElement("option");
            option.text = '請選擇鄉鎮市區';
            district.appendChild(option);

            for (city in area_arr) {
                if (selected_city == city) {
                    for (let i = 0; i < area_arr[city].length; i++) {
                        var option = document.createElement("option");
                        option.value = area_arr[city][i];
                        option.text = area_arr[city][i];
                        if (area_arr[city][i] === selected_district) {
                            option.selected = "selected";
                        }
                        district.appendChild(option);
                    }
                }
            }
        };

        // Load shipment info dynamically
        function load_shipment() {
            var selected_shipment_type = $('#shipment_type').val();
            if (selected_shipment_type === '門市取貨') {
                if (document.getElementById('shipmentrow2')) {
                    document.getElementById('shipmentrow2').remove();
                }
                var pickup_store_arr = <?php echo json_encode($pickup_store_result); ?>;
                var insert = `<div class='row align-items-center mb-4' id='shipmentrow2'>` +
                    `<div class='col-3' id='pickup_store_col'>` +
                    `<label for='shipment_type' class='form-label'>請選擇取貨店鋪</label>` +
                    `<select class='form-select' id='pickup_store' name='pickup_store' required onchange='load_pickup_store_addr()'>`;
                for (var i = 0; i < pickup_store_arr.length; i++) {
                    insert += `<option value=${pickup_store_arr[i][0]}>${pickup_store_arr[i][5]}</option>`;
                }
                insert += ` </select> </div> </div>`;
                document.getElementById('shipmentrow1').insertAdjacentHTML('afterend', insert);

            } else if (selected_shipment_type === '宅配') {
                if (document.getElementById('shipmentrow2')) {
                    document.getElementById('shipmentrow2').remove();
                }
                var insert = `<div class="row align-items-center mb-4" id='shipmentrow2'>
                        <span class="form-label">請輸入收件地址</span>
                        <div class="col-2">
                            <label for="zipcode" class="form-label">郵遞區號</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control" required maxlength="6" value=<?php echo "$user_result[9]"; ?>>
                        </div>

                        <div class="col-2">
                            <label for="city" class="form-label">縣市</label>
                            <select class="form-select" id="city" name="city" onchange='load_district();' required>
                                <option selected>請選擇縣市
                                </option>
                                <?php
                                foreach ($json_data as $key => $val) {
                                    if ($key == $user_result[10]) {
                                        echo "<option value=$key selected>$key</option>";
                                    } else {
                                        echo "<option value=$key>$key</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="district" class="form-label">鄉鎮市區</label>
                            <select class="form-select" id="district" name="district" required>
                                <?php
                                foreach ($json_data as $key => $val) {
                                    if ($key == $user_result[10]) {
                                        foreach ($json_data[$key] as $dist) {
                                            if ($user_result[11] == $dist) {
                                                echo "<option value=$dist selected>$dist</option>";
                                            } else {
                                                echo "<option value=$dist>$dist</option>";

                                            }
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="col">
                            <label for="address" class="form-label">詳細地址</label>
                            <input type="text" id="address" name="address" class="form-control" value=<?php echo "$user_result[12]"; ?> required>
                        </div>
                    </div>`;
                document.getElementById('shipmentrow1').insertAdjacentHTML('afterend', insert);

            } else if (selected_shipment_type === '全家取貨' || selected_shipment_type === '711取貨') {
                if (document.getElementById('shipmentrow2')) {
                    document.getElementById('shipmentrow2').remove();
                }
                var insert = `<div class="row align-items-center mb-4" id='shipmentrow2'>
                        <div class="col-2">
                            <label for="cscode" class="form-label">超商門市店號</label>
                            <input type="text" id="cscode" name="cscode" class="form-control" required>
                        </div>` +
                        `<div class='col-8 pt-4 mt-2'>` +
                        `<span>請至<a href="https://emap.pcsc.com.tw/ecmap/default.aspx" target="_blank">711</a>或<a href="https://www.famiport.com.tw/Web_Famiport/page/ShopQuery.aspx" target="_blank">全家</a>電子地圖查詢</span></div></div>`;

                    document.getElementById('shipmentrow1').insertAdjacentHTML('afterend', insert);
            }


        };

        function load_pickup_store_addr() {
            var selected_pickup_store = $('#pickup_store').val();
            var pickup_store_arr = <?php echo json_encode($pickup_store_result); ?>;
            for (var i = 0; i < pickup_store_arr.length; i++) {
                if (pickup_store_arr[i][0] === selected_pickup_store) {
                    if (document.getElementById('pickup_store_addr')) {
                        document.getElementById('pickup_store_addr').remove();
                    }
                    insert =
                        `<div class='col-8 pt-4 mt-2' id='pickup_store_addr'>` +
                        `<span> 地址｜ ${pickup_store_arr[i][1]} ${pickup_store_arr[i][2]}${pickup_store_arr[i][3]}${pickup_store_arr[i][4]}</span></div>`;
                    document.getElementById('pickup_store_col').insertAdjacentHTML('afterend', insert);
                }
            }
        };

        function load_payment(){
            var selected_payment_type = $('#payment_type').val();
            if (selected_payment_type === '信用卡'){
                if (document.getElementById('paymentrow2')) {
                    document.getElementById('paymentrow2').remove();
                }
                var insert = `<div class="row align-items-center mb-4" id="paymentrow2">
                        <div class="col-3">
                            <label for="payment_card_name" class="form-label">信用卡持有人姓名</label>
                            <input type="text" id="payment_card_name" name="payment_card_name" class="form-control" required>
                        </div>
                        <div class="col-3">
                            <label for="payment_card_num" class="form-label">信用卡16碼卡號</label>
                            <input type="text" id="payment_card_num" name="payment_card_num" minlength=16 maxlength=16 class="form-control" required>
                        </div>
                        <div class="col-3">
                            <label for="payment_card_date" class="form-label">信用卡到期日（月／年）</label>
                            <input type="text" id="payment_card_date" name="payment_card_date" minlength=5 maxlength=5 class="form-control" placeholder="03/27" required>
                        </div>
                        <div class="col-3">
                            <label for="payment_card_cvc" class="form-label">信用卡安全碼（CVC）</label>
                            <input type="text" id="payment_card_cvc" name="payment_card_cvc" minlength=3 maxlength=3 class="form-control" required>
                        </div>
                    </div>`;
                document.getElementById('paymentrow1').insertAdjacentHTML('afterend', insert);
            } else {
                if (document.getElementById('paymentrow2')) {
                    document.getElementById('paymentrow2').remove();
                }
            }

        };

        function load_invoice(){
            var selected_invoice_type = $('#invoice_type').val();
            console.log(selected_invoice_type);
            if (selected_invoice_type === '發票載具'){
                if (document.getElementById('invoicecol2')) {
                    document.getElementById('invoicecol2').remove();
                }
                var insert = `
                        <div class="col-3" id="invoicecol2">
                            <label for="invoice_info" class="form-label">請輸入電子發票手機條碼</label>
                            <input type="text" id="invoice_info" name="invoice_info" class="form-control" minlength=8 maxlength=8 placeholder="/724YD-3" required>
                        </div>`;
                document.getElementById('invoicecol1').insertAdjacentHTML('afterend', insert);
            } else {
                if (document.getElementById('invoicecol2')) {
                    document.getElementById('invoicecol2').remove();
                }
            }
        };
        </script>
    </body>

</html>