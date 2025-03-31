<?php
// ملف: check-auth.php
session_start();
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/
// التحقق من حالة تسجيل الدخول
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    // تخزين الصفحة الحالية لإعادة التوجيه لها بعد الدخول
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];
    
    // توجيه إلى صفحة الدخول مع رسالة
    header('Location: login.php?error=not_logged_in');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - Moshft SEO</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --sidebar-width: 250px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Tajawal', sans-serif;
        }

        body {
            background:#3c3e50 ;
            display: flex;
            min-height: 100vh;
        }

        /* الشريط الجانبي */
        .sidebar {
            background: var(--primary-color);
            width: var(--sidebar-width);
            padding: 20px;
            position: fixed;
            height: 100%;
            color: #FF6AA2FF;
            transition: 0.3s;
        }

        .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo img {
            width: 80px;
            border-radius: 50%;
        }

        .nav-menu {
            list-style: none;
            color: #FF6AA2FF;
            
        }

        .nav-item {
            margin: 15px 0;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .nav-item:hover {
            background: var(--secondary-color);
        }

        .nav-item a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .nav-item i {
            margin-left: 20px;
            font-size: 1.2rem;
            filter: brightness(0) invert(1);
        }

        /* المحتوى الرئيسي */
        .main-content {
            margin-right: var(--sidebar-width);
            padding: 30px;
            width: calc(100% - var(--sidebar-width));
        }

        /* بطاقات الإحصائيات */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var(--secondary-color);
        }

        .card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .card .stat {
            font-size: 2rem;
            color: var(--secondary-color);
            font-weight: bold;
        }

        /* جدول آخر المنشورات */
        .recent-table {
            background: white;
            margin-top: 40px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f8f9fa;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                padding: 0;
            }

            .main-content {
                margin-right: 0;
                width: 100%;
            }

            .nav-item span {
                display: none;
            }
        }
    </style>
</head>
<body>
       <?php include 'menu.php';?>

    <!-- المحتوى الرئيسي -->
    <main class="main-content">
        <h1>مرحبًا بك، <span style="color: var(--secondary-color)">في لوحة الادمن</span> 👋</h1>
        
        <!-- بطاقات الإحصائيات -->
        <div class="cards-container">
            <div class="card">
                <h3>إجمالي الزيارات</h3>
                <div class="stat">1,234</div>
            </div>
            <div class="card">
                <h3>المنشورات الجديدة</h3>
                <div class="stat">45</div>
            </div>
            <div class="card">
                <h3>المستخدمين النشطين</h3>
                <div class="stat">892</div>
            </div>
        </div>

        <!-- جدول آخر المنشورات -->
        <div class="recent-table">
            <h2>آخر المنشورات <i class="fas fa-clock"></i></h2>
            <table>
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>دليل تحسين محركات البحث</td>
                        <td>2023-10-01</td>
                        <td><span style="color: #2ecc71">نشط</span></td>
                    </tr>
                    <tr>
                        <td>أفضل ممارسات SEO</td>
                        <td>2023-09-28</td>
                        <td><span style="color: #e74c3c">مسودة</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <br>
        <a href="https://moshft.hup.icu/"><h4>powerd by seo moshft<h4></a>
  
    </main>
    
</body>
</html>