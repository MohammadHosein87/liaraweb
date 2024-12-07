<?php
session_start();

// گرفتن متغیر محیطی DATABASE_URL
$database_url = getenv('DATABASE_URL');

// اگر متغیر موجود نبود، خطا بده
if (!$database_url) {
    die('خطا در دریافت متغیر محیطی DATABASE_URL');
}

// تجزیه URL به قسمت‌های مختلف
$parsed_url = parse_url($database_url);

// استخراج اطلاعات اتصال به دیتابیس از URL
$servername = $parsed_url['host'];  // مانند "licenses"
$username = $parsed_url['user'];    // مانند "root"
$password = $parsed_url['pass'];    // مانند "Tsf6jrThPTPRUA6f8cAbYEJg"
$dbname = ltrim($parsed_url['path'], '/');  // مانند "ecstatic_driscoll"

// ایجاد اتصال به دیتابیس
$conn = new mysqli($servername, $username, $password, $dbname);

// چک کردن اینکه اتصال برقرار شد یا نه
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// // بررسی اینکه آیا کوکی برای ورود قبلاً تنظیم شده یا نه
// if (isset($_COOKIE['user_logged_in'])) {
//     // اگر کوکی هست، کاربر قبلاً وارد شده و نیاز به بررسی دوباره نیست
//     header("Location: admin.php?status=logged_in");
//     exit();
// }

// دریافت نام کاربری و پسورد از فرم (با فرض اینکه داده‌ها POST می‌شوند)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name']; // نام کاربری
    $pass = $_POST['pass']; // پسورد

    // بررسی اینکه نام کاربری و پسورد برابر با مقدارهای مشخص شده باشد
    if ($name == "MMD_Coder" && $pass == "M1387h1387") {
        // ارسال کاربر به admin.php همراه با اطلاعات ورود در URL
        // مثلاً با ارسال نام کاربری و پسورد از طریق URL (GET request)
        header("Location: admin.php?name=$name&pass=$pass");
        exit();
    } else {
        // بررسی در دیتابیس برای کاربر و پسورد
        $stmt = $conn->prepare("SELECT * FROM lic WHERE name = ? AND pass = ?");
        $stmt->bind_param("ss", $name, $pass); // بایند کردن متغیرها به دستور SQL
        $stmt->execute();
        $result = $stmt->get_result();
        
        // اگر رکوردی با این نام کاربری و پسورد پیدا شد
        if ($result->num_rows > 0) {
            // اگر ورود موفق بود، تنظیم کوکی برای ورود
            // ارسال کاربر به index.php
            header("Location: index.php?name=$name&pass=$pass");
            exit();
        } else {
            // اگر نام کاربری یا پسورد اشتباه بود
            echo "نام کاربری یا پسورد اشتباه است!";
        }

        // بستن اتصال
        $stmt->close();
    }
}

$conn->close();
?>

<!-- فرم ورود -->
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه ورود</title>
    <style>
        /* استایل‌ها همونطور که قبلاً نوشتم */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .login-container button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>ورود به حساب</h2>
        <form method="POST" action="login.php">
            <input type="text" name="name" placeholder="نام کاربری" required>
            <input type="password" name="pass" placeholder="پسورد" required>
            <button type="submit">ورود</button>
        </form>
    </div>
</body>
</html>
