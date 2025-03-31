<?php
session_start();
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/
// التحقق من وجود اتصال بقاعدة البيانات
require_once '../config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
// إذا كان المستخدم مسجل الدخول مسبقاً، توجيهه للوحة التحكم
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: dashboard.php');
    exit;
}

// معالجة بيانات تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // البحث عن المستخدم في قاعدة البيانات
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // التحقق من كلمة المرور
        if (password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = "كلمة المرور غير صحيحة!";
        }
    } else {
        $error = "اسم المستخدم غير موجود!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>معالجة الدخول</title>
    <style>
        .alert {
            padding: 15px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            max-width: 400px;
            z-index: 1000;
        }
        
        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
    </style>
</head>
<body>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger animate__animated animate__shakeX">
            <?php echo $error; ?>
        </div>
        <script>
            setTimeout(() => {
                window.history.back();
            }, 2000);
        </script>
    <?php endif; ?>
    <a href="https://moshft.hup.icu/"><h4>powerd by seo moshft<h4></a>
  
</body>
</html>