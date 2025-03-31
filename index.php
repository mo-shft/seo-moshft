<?php
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/
include 'config.php';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
$sql = "SELECT token, id, title, SUBSTRING(description, 1, 100) AS short_desc, image_paths FROM post_news ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="ar">
<head>
 
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ;?></title>
    <meta name="description" content="<?= $description;?>">
    <meta name="keywords" content="<?= $keywords;?>">
    <meta property="og:title" content="<?= $title ;?>">
     <meta property="og:description" content="<?= $description ;?>">
    <meta property="og:image" content="logo.png">
    <meta property="og:type" content="website">
    <link rel="canonical" href="https://<?= $site ;?>">
    <link rel="icon" href="logo.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="logo.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="logo.png">
    <link rel="icon" type="image/png" sizes="16x16" href="logo.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="/logo.ico" color="#5bbad5">
    <meta name="theme-color" content="#ffffff">
    <style>
    
        /* تنسيق عام للترقيم */
.pagination {
    text-align: center;
    margin-top: 20px;
    
}

.pagination a {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 5px;
    background-color: #f2f2f2;
    color: #333;
    text-decoration: none;
    border-radius: 5px;
    font-size: 16px;
    transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
    background-color: #4CAF50;
    color: white;
}

.pagination a.active {
    background-color: #4CAF50;
    color: white;
    font-weight: bold;
}

.pagination a:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
}

/* تنسيق خاص للصفحات الأولى والأخيرة */
.pagination a.first, .pagination a.last {
    font-weight: bold;
}

.pagination a.disabled {
    background-color: #e0e0e0;
    color: #9e9e9e;
    cursor: not-allowed;
}

    </style>
</head>
<body>

<h1>آخر الأخبار</h1>
<div class="news-container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images = explode(',', $row['image_paths']);
            echo '<div class="news-post">';
            echo '<div class="news-title">' . htmlspecialchars($row['title']) . '</div>';
            echo '<div class="slider">';
            foreach ($images as $image) {
                echo '<div class="slide"><img src="/' . htmlspecialchars($image) . '" alt="صورة"></div>';
            }
            echo '</div>';
            echo '<button class="news-button" onclick="window.location.href=\'bg?' . $row['token'] . '\'">معرفة المزيد</button>';
            echo '</div>';
        }
    } else {
        echo "لا توجد أخبار.";
    }


$total_sql = "SELECT COUNT(*) FROM post_news";
$total_result = $conn->query($total_sql);
$total_rows = $total_result->fetch_row()[0];
$total_pages = ceil($total_rows / $limit);

echo '<div class="pagination">';
for ($i = 1; $i <= $total_pages; $i++) {
    echo '<a href="?page=' . $i . '">' . $i . '</a> ';
}
echo '</div>';

    $conn->close();
    ?>
</div>

   
<script src="scripts.js"></script>
</body>
</html>




