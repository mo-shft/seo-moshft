<!--
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
-->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل دخول الإدمن - Moshft SEO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        :root {
            --primary-blue: #2196F3;
            --dark-blue: #1976D2;
            --gradient-bg: linear-gradient(135deg, #2196F3 0%, #1976D2 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', Arial, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-bg);
            padding: 20px;
        }

        .login-container {
            background: rgba(255, 255, 255, 0.95);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            position: relative;
            transform: scale(0.95);
            animation: scaleUp 0.6s forwards;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: var(--gradient-bg);
            border-radius: 50%;
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(33,150,243,0.3);
            animation: float 3s ease-in-out infinite;
        }

        .logo-circle img {
            width: 80%;
            
        }

        h2 {
            text-align: center;
            color: var(--dark-blue);
            margin: 40px 0 30px;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #eee;
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-blue);
            box-shadow: 0 0 15px rgba(33,150,243,0.2);
        }

        .form-group label {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
            pointer-events: none;
            transition: all 0.3s;
        }

        .form-group input:focus + label,
        .form-group input:not(:placeholder-shown) + label {
            top: -10px;
            right: 15px;
            font-size: 0.8rem;
            color: var(--primary-blue);
            background: white;
            padding: 0 5px;
        }

        .login-btn {
            width: 100%;
            padding: 15px;
            background: var(--gradient-bg);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(33,150,243,0.4);
        }

        @keyframes scaleUp {
            to { transform: scale(1); }
        }

        @keyframes float {
            0%, 100% { transform: translate(-50%, 0px); }
            50% { transform: translate(-50%, -15px); }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
            
            h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container animate__animated animate__fadeIn">
        <div class="logo-circle animate__animated animate__bounceIn">
            <img src="seo.png" alt="Seo Moshft Logo">
        </div>
        <br><br>
<?php if (isset($_GET['logout']) && $_GET['logout'] === 'success'): ?>
<div class="alert alert-success animate__animated animate__bounceIn">
    ✅ تم تسجيل الخروج بنجاح - إلى اللقاء!
</div>
<?php endif; ?>
        <h2>تسجيل دخول الإدمن</h2>
        
        <form action="login-process.php" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder=" " required>
                <label>اسم المستخدم</label>
            </div>

            <div class="form-group">
                <input type="password" name="password" placeholder=" " required>
                <label>كلمة المرور</label>
            </div>

            <button type="submit" class="login-btn animate__animated animate__fadeInUp">
                دخول إلى لوحة التحكم
            </button>
        </form><br>
        <a href="https://moshft.hup.icu/"><h4>powerd by seo moshft<h4></a>
    </div>

    <script>
        // إضافة تأثيرات عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.form-group input').forEach(input => {
                input.classList.add('animate__animated', 'animate__fadeInRight');
            });
        });
    </script>
</body>
</html>