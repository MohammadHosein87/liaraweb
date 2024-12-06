<?php
// اتصال به دیتابیس
$servername = "localhost";
$username = "root";
$password = "your_password";
$dbname = "your_database";

// اتصال به دیتابیس
$conn = mysqli_connect($servername, $username, $password, $dbname);

// چک کردن اتصال
if (!$conn) {
    die("اتصال به دیتابیس موفقیت‌آمیز نبود: " . mysqli_connect_error());
}

// عملیات نمایش داده‌ها
$query = "SELECT * FROM your_table_name";
$result = mysqli_query($conn, $query);

// عملیات ویرایش داده‌ها
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $id = $_POST['edit_id'];
    $name = $_POST['name'];
    $update_query = "UPDATE your_table_name SET name = '$name' WHERE id = $id";
    mysqli_query($conn, $update_query);
    header('Location: index.php'); // ریدایرکت برای بارگزاری مجدد
}

// عملیات حذف داده‌ها
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM your_table_name WHERE id = $delete_id";
    mysqli_query($conn, $delete_query);
    header('Location: index.php'); // ریدایرکت بعد از حذف
}

// عملیات ورود کاربر (برای نمایش صفحه اصلی)
$logged_in = false; // فرض بر این است که کاربر هنوز وارد نشده
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == "admin" && $password == "admin123") {  // این‌جا باید اعتبارسنجی واقعی انجام بشه
        $logged_in = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت دیتابیس</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <!-- صفحه ورود -->
    <?php if (!$logged_in): ?>
        <div class="login-container">
            <h2>ورود به پنل مدیریت دیتابیس</h2>
            <form action="index.php" method="POST">
                <input type="text" name="username" placeholder="نام کاربری" required>
                <input type="password" name="password" placeholder="کلمه عبور" required>
                <button type="submit">ورود</button>
            </form>
        </div>
    <?php else: ?>
        <!-- داشبورد -->
        <div class="dashboard-container">
            <h2>داشبورد مدیریت دیتابیس</h2>
            <a href="#view-database">مشاهده دیتابیس</a>
            <a href="#edit-database">ویرایش دیتابیس</a>

            <!-- مشاهده دیتابیس -->
            <div id="view-database">
                <h3>مشاهده داده‌ها</h3>
                <table>
                    <tr>
                        <th>ID</th>
                        <th>نام</th>
                        <th>عملیات</th>
                    </tr>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td>
                                <a href="#edit-database?id=<?php echo $row['id']; ?>">ویرایش</a>
                                <a href="index.php?delete_id=<?php echo $row['id']; ?>">حذف</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>

            <!-- ویرایش دیتابیس -->
            <?php if (isset($_GET['id'])): ?>
                <div id="edit-database">
                    <?php
                    $edit_id = $_GET['id'];
                    $edit_query = "SELECT * FROM your_table_name WHERE id = $edit_id";
                    $edit_result = mysqli_query($conn, $edit_query);
                    $edit_row = mysqli_fetch_assoc($edit_result);
                    ?>
                    <h3>ویرایش داده</h3>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="edit_id" value="<?php echo $edit_row['id']; ?>">
                        <input type="text" name="name" value="<?php echo $edit_row['name']; ?>" required>
                        <button type="submit">ویرایش</button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

</body>
</html>
