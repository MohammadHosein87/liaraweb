<?php
$conn = new mysqli('licenses', 'root', 'Tsf6jrThPTPRUA6f8cAbYEJg', 'ecstatic_driscoll', 3306);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// بررسی اینکه آیا پارامتر name و pass در URL وجود داره و به ترتیب برابر با MMD_Coder, mmd نباشه
if ($_GET['name'] !== 'MMD_Coder' || $_GET['pass'] !== 'mmd') {
    die('Access denied');
    header("Location: login.php");
    exit();
}

// اگر اطلاعات ارسال شده باشه برای افزودن یا ویرایش
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $pass = $_POST['pass'];
    $value = $_POST['value'];
    $email = $_POST['email'];
    $start = $_POST['start'];
    $exp = $_POST['exp'];
    $action = $_POST['action'];

    if ($action == 'add') {
        // محاسبه remaining_days
        $remaining_days = (strtotime($exp) - strtotime($start)) / (60 * 60 * 24);
        
        // افزودن اطلاعات به دیتابیس
        $stmt = $conn->prepare("INSERT INTO lic (name, pass, value, email, start, exp, remaining_days) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssi", $name, $pass, $value, $email, $start, $exp, $remaining_days);
        if ($stmt->execute()) {
            // exact like `pass` in python, but here, in php.
            ;
        } else {
            echo "خطا در افزودن اطلاعات.";
        }
        $stmt->close();
    } elseif ($action == 'edit') {
        $id = $_POST['id'];
        // محاسبه remaining_days
        $remaining_days = (strtotime($exp) - strtotime($start)) / (60 * 60 * 24);

        // ویرایش اطلاعات
        $stmt = $conn->prepare("UPDATE lic SET name = ?, pass = ?, value = ?, email = ?, start = ?, exp = ?, remaining_days = ? WHERE id = ?");
        $stmt->bind_param("ssssssii", $name, $pass, $value, $email, $start, $exp, $remaining_days, $id);
        if ($stmt->execute()) {
            echo "اطلاعات با موفقیت ویرایش شد.";
        } else {
            echo "خطا در ویرایش اطلاعات.";
        }
        $stmt->close();
    }
}

// نمایش لیست کاربران
$result = $conn->query("SELECT * FROM lic");
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل ادمین</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<div class="admin-container">
    <h2>پنل ادمین</h2>

    <!-- فرم برای افزودن یا ویرایش اطلاعات -->
    <form method="POST">
        <input type="text" name="name" placeholder="نام کاربری" required>
        <input type="password" name="pass" placeholder="پسورد" required>
        <input type="text" name="value" placeholder="مقدار" required>
        <input type="email" name="email" placeholder="ایمیل" required>
        <input type="date" name="start" placeholder="تاریخ شروع" required>
        <input type="date" name="exp" placeholder="تاریخ انقضا" required>
        <input type="hidden" name="action" value="add">
        <button type="submit">افزودن کاربر جدید</button>
    </form>

    <!-- نمایش لیست کاربران -->
    <h3>لیست کاربران</h3>
    <table>
        <thead>
            <tr>
                <th>نام کاربری</th>
                <th>پسورد</th>
                <th>مقدار</th>
                <th>ایمیل</th>
                <th>تاریخ شروع</th>
                <th>تاریخ انقضا</th>
                <th>روزهای باقی‌مانده</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['pass']); ?></td>
                    <td><?php echo htmlspecialchars($row['value']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['start']); ?></td>
                    <td><?php echo htmlspecialchars($row['exp']); ?></td>
                    <td><?php echo htmlspecialchars($row['remaining_days']); ?></td>
                    <td>
                        <!-- فرم ویرایش کاربر -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                            <input type="password" name="pass" value="<?php echo htmlspecialchars($row['pass']); ?>" required>
                            <input type="text" name="value" value="<?php echo htmlspecialchars($row['value']); ?>" required>
                            <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                            <input type="date" name="start" value="<?php echo htmlspecialchars($row['start']); ?>" required>
                            <input type="date" name="exp" value="<?php echo htmlspecialchars($row['exp']); ?>" required>
                            <input type="hidden" name="action" value="edit">
                            <button type="submit">ویرایش</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- دکمه خروج -->
    <a href="logout.php"><button>خروج</button></a>

</div>

</body>
</html>

