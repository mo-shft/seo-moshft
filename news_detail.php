<?php
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/
include 'config.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
// التحقق من وجود العنوان في الرابط
$title = isset($_GET['title']) ? $conn->real_escape_string($_GET['title']) : '';

if (!empty($title)) {
    // جلب البيانات من قاعدة البيانات باستخدام العنوان
    $sql = "SELECT token, title, description, image_paths FROM post_news WHERE token = '$title' OR title = '$title'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $post = $result->fetch_assoc();
    } else {
        $error = "المنشور المطلوب غير موجود.";
    }
} else {
    $error = "لم يتم تحديد عنوان المنشور.";
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content=""
    <title><?php echo htmlspecialchars($post['title']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* تنسيق لعرض الرسائل في منتصف الصفحة */
        
        .message {
            text-align: center;
            padding: 20px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
        }
        .news-post {
            text-align: center;
        }
        .slider {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }
        .slide img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .back-button {
    position: fixed; /* لتثبيته في مكانه */
    top: 100px; /* المسافة من الأعلى */
    right: 20px; /* المسافة من اليمين */
    background-color: #007bff; /* لون الخلفية الأزرق */
    color: #fff; /* لون النص الأبيض */
    padding: 10px 15px; /* الحشوة الداخلية */
    border-radius: 20px; /* لجعل الحواف مستديرة */
    text-decoration: none; /* إزالة خط التسطير */
    font-size: 16px; /* حجم الخط */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* ظل خفيف */
    transition: background-color 0.3s; /* تأثير الانتقال */
    z-index:1000;
}

.back-button:hover {
    background-color: #0056b3; /* لون الخلفية عند التمرير */
}

    </style>
</head>
<body>
<a href="javascript:history.back()" class="back-button">
    &#8592; 
</a>

<?php if (isset($error)) { ?>
    <!-- رسالة خطأ في منتصف الصفحة -->
    <div class="message">
        <h1><?php echo htmlspecialchars($error); ?></h1>
    </div>
<?php } else { ?>
    <h1><?php echo htmlspecialchars($post['title']); ?></h1>

    <div class="news-post">
        <div class="slider">
            <?php
            $images = explode(',', $post['image_paths']);
            foreach ($images as $image) {
                echo '<div class="slide"><img src="/' . htmlspecialchars($image) . '" alt="صورة"></div>';
            }
            ?>
        </div>
        
        
        <div class="news-description">
    <?php echo $post['description']; // عرض الـ HTML كما هو ?>
</div>

    </div>
<?php } ?>

<script src="scripts.js"></script>
</body>
</html>

