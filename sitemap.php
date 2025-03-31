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

// استعلام لجلب بيانات المنشورات
$sql = "SELECT token, created_at FROM post_news";
$result = $conn->query($sql);

if (!$result) {
    die("فشل استعلام قاعدة البيانات: " . $conn->error);
}

// إعداد اسم ملف XML
$xmlFile = 'sitemap.xml';

// بدء كتابة XML
$xmlContent = '<?xml version="1.0" encoding="UTF-8"?>';
$xmlContent .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

if ($result->num_rows > 0) {
    // عرض البيانات من قاعدة البيانات
    while ($row = $result->fetch_assoc()) {
        $title = $row['token'];
        $created_at = date('Y-m-d', strtotime($row['created_at'])); // تنسيق التاريخ
        
        // إنشاء الرابط
        $url = 'https://pymo.pro/news/bg?' . urlencode($title);

        $xmlContent .= '<url>';
        $xmlContent .= '<loc>' . htmlspecialchars($url) . '</loc>';
        $xmlContent .= '<lastmod>' . $created_at . '</lastmod>';
        $xmlContent .= '<changefreq>daily</changefreq>'; // يمكنك تغيير التردد حسب الحاجة
        $xmlContent .= '<priority>0.8</priority>'; // يمكنك تخصيص الأولوية حسب الحاجة
        $xmlContent .= '</url>';
    }
} else {
    echo "لا توجد بيانات لعرضها.";
}

$xmlContent .= '</urlset>';

// محاولة حفظ ملف XML
if (file_put_contents($xmlFile, $xmlContent) === false) {
    die("فشل حفظ ملف XML. تأكد من الأذونات.");
}

// إغلاق الاتصال
$conn->close();

echo "تم إنشاء خريطة الموقع بنجاح!";
?>