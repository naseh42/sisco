<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>پنل مدیریت کاربران VPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center">پنل مدیریت کاربران VPN</h1>
        <hr>

        <!-- فرم افزودن کاربر -->
        <div class="card p-4 mb-4">
            <h3>افزودن کاربر جدید</h3>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="username" class="form-label">نام کاربری</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">رمز عبور</label>
                    <input type="text" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="bandwidth" class="form-label">محدودیت حجم (گیگابایت)</label>
                    <input type="number" class="form-control" id="bandwidth" name="bandwidth" required>
                </div>
                <div class="mb-3">
                    <label for="time" class="form-label">محدودیت زمان (روز)</label>
                    <input type="number" class="form-control" id="time" name="time" required>
                </div>
                <button type="submit" name="add_user" class="btn btn-primary">افزودن کاربر</button>
            </form>
        </div>

        <!-- جدول نمایش کاربران -->
        <div class="card p-4">
            <h3>لیست کاربران</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>شناسه</th>
                        <th>نام کاربری</th>
                        <th>رمز عبور</th>
                        <th>حجم (گیگابایت)</th>
                        <th>زمان (روز)</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $conn = new mysqli("localhost", "root", "", "vpn_users");
                    if ($conn->connect_error) {
                        die("خطا در اتصال به دیتابیس: " . $conn->connect_error);
                    }

                    // افزودن کاربر
                    if (isset($_POST['add_user'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $bandwidth = $_POST['bandwidth'];
                        $time = $_POST['time'];

                        $sql = "INSERT INTO users (username, password, bandwidth_limit, time_limit) VALUES ('$username', '$password', $bandwidth, $time)";
                        $conn->query($sql);
                        header("Location: index.php");
                    }

                    // حذف کاربر
                    if (isset($_GET['delete'])) {
                        $id = $_GET['delete'];
                        $sql = "DELETE FROM users WHERE id=$id";
                        $conn->query($sql);
                        header("Location: index.php");
                    }

                    // نمایش کاربران
                    $result = $conn->query("SELECT * FROM users");
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['password']}</td>
                                <td>{$row['bandwidth_limit']}</td>
                                <td>{$row['time_limit']}</td>
                                <td><a href='?delete={$row['id']}' class='btn btn-danger btn-sm'>حذف</a></td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>