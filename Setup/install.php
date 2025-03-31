<?php
session_start();
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/
// حالة التثبيت
$step = isset($_GET['step']) ? (int)$_GET['step'] : 1;

// معالجة بيانات النماذج
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($step === 2) {
        // حفظ بيانات قاعدة البيانات في الجلسة
        $_SESSION['db_config'] = [
            'servername' => $_POST['servername'],
            'username' => $_POST['username'],
            'password' => $_POST['password'],
            'dbname' => $_POST['dbname']
        ];
        
        // اختبار الاتصال بقاعدة البيانات
        try {
            $conn = new mysqli(
                $_POST['servername'],
                $_POST['username'],
                $_POST['password'],
                $_POST['dbname']
            );
            
            if ($conn->connect_error) throw new Exception($conn->connect_error);
            
            // إنشاء ملف config.php
            $config_content = "<?php\n";
            $config_content .= "define('DB_HOST', '{$_POST['servername']}');\n";
            $config_content .= "define('DB_USER', '{$_POST['username']}');\n";
            $config_content .= "define('DB_PASS', '{$_POST['password']}');\n";
            $config_content .= "define('DB_NAME', '{$_POST['dbname']}');\n";
            $config_content .= "?>";

            if (!file_put_contents('../config.php', $config_content)) {
                throw new Exception('فشل في إنشاء ملف الإعدادات');
            }
            
            header('Location: install.php?step=3');
            exit;
            
        } catch (Exception $e) {
            $error = "خطأ في الاتصال: " . $e->getMessage();
        }
    }
    
    if ($step === 3) {
        // إنشاء الجداول وحساب الأدمن
        require_once '../config.php';
        
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        // إنشاء جدول الأدمن
        $sql_admin = "CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL
        )";
        
        // إنشاء جدول المنشورات
        $sql_posts = "CREATE TABLE IF NOT EXISTS post_news (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            image_paths TEXT,
            token VARCHAR(100),
            description TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $sql_seo = "CREATE TABLE IF NOT EXISTS post_seo (
            id INT AUTO_INCREMENT PRIMARY KEY,
            txt_id VARCHAR(50) NOT NULL,
            dic VARCHAR(255) NOT NULL
        )";
        if ($conn->query($sql_admin) !== TRUE || $conn->query($sql_posts) !== TRUE|| $conn->query($sql_seo) !== TRUE) {
            die("خطأ في إنشاء الجداول: " . $conn->error);
        }
        
        // إدخال بيانات الأدمن
        $username = $conn->real_escape_string($_POST['admin_user']);
        $password = password_hash($_POST['admin_pass'], PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO admins (username, password) VALUES ('$username', '$password')";
        if ($conn->query($sql) !== TRUE) {
            die("خطأ في إدخال البيانات: " . $conn->error);
        }
        
        header('Location: install.php?step=4');
        exit;
    }
}
?>


 <!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تثبيت إضافة SEO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-color: #2196F3;
            --gradient-blue: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }

        body {
            font-family: 'Tajawal', Arial, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .install-wrapper {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 800px;
            overflow: hidden;
            transform: translateY(20px);
            opacity: 0;
            animation: fadeInUp 0.6s forwards;
        }

        .step-header {
            background: var(--gradient-blue);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .step-content {
            padding: 30px;
            position: relative;
        }

        .loader {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255,255,255,0.9);
            z-index: 10;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 2px solid #eee;
            border-radius: 8px;
            transition: all 0.3s;
        }

        input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 8px rgba(33,150,243,0.2);
        }

        .btn {
            background: var(--gradient-blue);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: inline-flex;
            align-items: center;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33,150,243,0.3);
        }

        .progress-bar {
            height: 4px;
            background: #eee;
            position: relative;
            margin: 20px 0;
        }

        .progress-fill {
            height: 100%;
            background: var(--primary-color);
            width: <?= ($step-1)*33 ?>%;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes fadeInUp {
            to { transform: translateY(0); opacity: 1; }
        }

        @media (max-width: 768px) {
            .install-wrapper {
                border-radius: 10px;
            }
            
            .step-header {
                padding: 20px;
            }
            
            .step-content {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="install-wrapper">
        <div class="step-header animate__animated animate__fadeIn">
            <h1>✨ تثبيت إضافة SEO</h1>
            <p>الخطوة <?= $step ?> من 4</p>
        </div>
        
        <div class="progress-bar">
            <div class="progress-fill"></div>
        </div>

        <div class="step-content">
            <div class="loader">
                <div class="spinner"></div>
                <p style="margin-top:15px;">جاري المعالجة...</p>
            </div>

            <?php if ($step === 1): ?>
                <div class="animate__animated animate__fadeInRight">
                    <h2>مرحبًا بك في إضافة SEO من Moshft! 🚀</h2>
                    <p>سيقوم هذا المعالج بإعداد النظام في بضع خطوات بسيطة</p>
                    <button class="btn" onclick="showLoader()">
                        ابدأ التثبيت 
                        <span style="margin-right:8px;">→</span>
                    </button>
                </div>

                <?php elseif ($step === 2): ?>
    <div class="step">
        <h2>إعدادات قاعدة البيانات</h2>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST">
            <input type="text" name="servername" placeholder="اسم الخادم (localhost)" required>
            <input type="text" name="username" placeholder="اسم المستخدم" required>
            <input type="password" name="password" placeholder="كلمة المرور">
            <input type="text" name="dbname" placeholder="اسم قاعدة البيانات" required>
            <button type="submit">اختبار الاتصال والمتابعة</button>
        </form>
    </div>

    <?php elseif ($step === 3): ?>
    <div class="step">
        <h2>إنشاء حساب الأدمن</h2>
        <form method="POST">
            <input type="text" name="admin_user" placeholder="اسم المستخدم" required>
            <input type="password" name="admin_pass" placeholder="كلمة المرور" required>
            <button type="submit">إنهاء التثبيت</button>
        </form>
    </div>
            <?php elseif ($step === 4): ?>
                <div class="animate__animated animate__bounceIn">
                    <div style="text-align:center;">
                        <div style="font-size:60px; color: #4CAF50;">✓</div>
                        <h2>التثبيت اكتمل بنجاح! 🎉</h2>
                        <p>تم إنشاء جميع الجداول والإعدادات بنجاح</p>
                        <div class="animate__animated animate__pulse animate__infinite" style="color:#666; margin-top:30px;">
                            تم التطوير بواسطة <strong>المهندس محمد شعبان</strong> (Moshft)
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        function showLoader() {
            document.querySelector('.loader').style.display = 'flex';
            setTimeout(() => {
                window.location.href = 'install.php?step=2';
            }, 500);
        }

        // إضافة تأثيرات عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input, button').forEach(el => {
                el.classList.add('animate__animated', 'animate__fadeInUp');
            });
        });
    </script>
</body>
</html>
