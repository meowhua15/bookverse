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
        if ($_SESSION['register_message'] == 'Fail') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  註冊失敗，請重新註冊
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['register_message']);
        }
        if ($_SESSION['login_message'] == 'Not Registered') {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                  此電子郵件尚未註冊，請先註冊後再登入
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
            unset($_SESSION['login_message']);
        }
        ?>

        <div class="container mt-5 mb-2">
            <div class="row">
                <div class="col-3">
                    <h4>▌註冊 Register </h4>
                </div>
            </div>
        </div>
        <div class="card container mb-5" style="background-color: #fbfbfb;">
            <div class="card-body p-4" style="background-color: #fbfbfb;">
                <form class="needs-validation" method="POST" action="register_finish.php" data-toggle="validator"
                    novalidate>
                    <div class="row align-items-center mb-4">
                        <div class="col-6">
                            <label for="username" class="form-label">使用者名稱</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="bookverse2023" required minlength="4" maxlength="25">
                            <div id="usernameHelpBlock" class="form-text">
                                使用者名稱僅可包含 4-25 碼英數字母
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="email" class="form-label">電子信箱</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="bookverse2023@gmail.com" required>
                            <div id="emailHelpBlock" class="form-text">
                                請確認輸入有效電子郵件
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-6">
                            <label for="password" class="form-label">登入密碼</label>
                            <input type="password" class="form-control" id="password" name="password" required
                                minlength="8" maxlength="30">
                            <div id="passwordHelpBlock" class="form-text">
                                須含 8-30 碼英數字母或特殊符號，請注意大小寫
                            </div>
                        </div>

                        <div class="col-6">
                            <label for="passwordcheck" class="form-label">登入密碼確認</label>
                            <input type="password" class="form-control" id="passwordcheck" required minlength="8"
                                maxlength="30">
                            <div id="passwordcheckHelpBlock" class="form-text">
                                請再輸入一次密碼，須與先前輸入密碼相同
                            </div>
                        </div>
                    </div>

                    <div class="row align-items-center mb-4">
                        <div class="col-3">
                            <label for="lastname" class="form-label">姓</label>
                            <input type="text" id="lastname" name="lastname" class="form-control" required>
                        </div>
                        <div class=" col-3">
                            <label for="firstname" class="form-label">名</label>
                            <input type="text" id="firstname" name="firstname" class="form-control" required>
                        </div>
                        <div class="col-4">
                            <label for="birthday" class="form-label">出生年月日</label>
                            <input type="date" id="birthday" name="birthday" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">性別</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="male" value="1" required>
                            <label class="form-check-label" for="male">男性</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="female" value="2" required>
                            <label class="form-check-label" for="female">女性</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="other" value="3" required>
                            <label class="form-check-label" for="other">其他／不願透露</label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="form-label">手機號碼</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="0912345678"
                            required minlength="10" maxlength="10">
                    </div>

                    <div class="row align-items-center mb-4">
                        <span class="form-label">地址</span>
                        <div class="col-2">
                            <label for="zipcode" class="form-label">郵遞區號</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control" required maxlength="6">
                        </div>

                        <div class="col-2">
                            <label for="city" class="form-label">縣市</label>
                            <select class="form-select" id="city" name="city" onchange='load_district()' required>
                                <option selected>請選擇縣市
                                </option>
                                <?php
                                foreach ($json_data as $key => $val) {
                                    echo "<option value=$key>$key</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="district" class="form-label">鄉鎮市區</label>
                            <select class="form-select" id="district" name="district" required>
                                <option selected>請選擇鄉鎮市區</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="address" class="form-label">詳細地址</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-dark"
                        style="float: right; background-color: #0d3b5c;">註冊</button>
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
        // Create district dropdown after the user choose the city
        var areas = <?php echo json_encode($json); ?>;
        var area_arr = new Array();
        area_arr = JSON.parse(areas);

        $(document).ready(function() {
            $("#city").change(load_district());
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
                        district.appendChild(option);
                    }
                }
            }
        }

        // Form validation
        (function() {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    ['change', 'submit'].forEach(function(e) {
                        form.addEventListener(e, function(event) {

                            // custom validation
                            // 4 <= username <= 30 
                            var username = document.getElementById('username');
                            if (username.value.length < 4 || username.length > 30) {
                                username.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                username.classList.remove("is-invalid")
                            }

                            // validate email using regex
                            var email = document.getElementById('email');
                            var validRegex =
                                /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
                            if (!email.value.match(validRegex)) {
                                email.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                email.classList.remove("is-invalid")
                            }

                            // password length check
                            var password = document.getElementById('password');
                            if (password.value.length < 8 || username.length > 30) {
                                password.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                password.classList.remove("is-invalid")
                            }

                            // password same check
                            var passwordcheck = document.getElementById('passwordcheck');
                            if (password.value !== passwordcheck.value || passwordcheck
                                .value === '') {
                                passwordcheck.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                passwordcheck.classList.remove("is-invalid")
                            }

                            // lname check 
                            var lastname = document.getElementById('lastname');
                            if (lastname.value === '') {
                                lastname.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                lastname.classList.remove("is-invalid")
                            }

                            // fname check 
                            var firstname = document.getElementById('firstname');
                            if (firstname.value === '') {
                                firstname.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                firstname.classList.remove("is-invalid")
                            }

                            // birthday check 
                            var birthday = document.getElementById('birthday');
                            if (birthday.value === '') {
                                birthday.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                birthday.classList.remove("is-invalid")
                            }

                            // gender
                            var gender = document.getElementsByName("gender")

                            for (var i = 0; i < gender.length; i++) {
                                if (gender[i].checked) {
                                    break;
                                }
                            }
                            if (i == gender.length) {
                                for (var i = 0; i < gender.length; i++) {
                                    gender[i].classList.add("is-invalid")
                                    event.preventDefault()
                                    event.stopPropagation()
                                }
                            } else {
                                for (var i = 0; i < gender.length; i++) {
                                    gender[i].classList.remove("is-invalid")
                                }
                            }

                            // cellphone check 
                            var phone = document.getElementById('phone');
                            if (phone.value.length !== 10 || isNaN(parseInt(phone.value,
                                    10))) {
                                phone.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                phone.classList.remove("is-invalid")
                            }

                            // address check 
                            var zipcode = document.getElementById('zipcode');
                            if (zipcode.value === '' || isNaN(parseInt(zipcode.value, 10))) {
                                zipcode.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                zipcode.classList.remove("is-invalid")
                            }

                            // city check 
                            var city = document.getElementById('city');
                            if (city.value === '' || city.value === '請選擇縣市') {
                                city.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                city.classList.remove("is-invalid")
                            }

                            // district check 
                            var district = document.getElementById('district');
                            if (district.value === '' || district.value === '請選擇鄉鎮市區') {
                                district.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                district.classList.remove("is-invalid")
                            }

                            // address check 
                            var address = document.getElementById('address');
                            if (address.value === '') {
                                address.classList.add("is-invalid")
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                address.classList.remove("is-invalid")
                            }

                            if (!form.checkValidity()) {
                                event.preventDefault()
                                event.stopPropagation()
                            } else {
                                form.classList.add('was-validated')
                            }
                        }, false)
                    })
                })
        })()
        </script>
    </body>

</html>