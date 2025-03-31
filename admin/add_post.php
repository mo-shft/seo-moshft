<?php
session_start();
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
?>
<?php
// الاتصال بقاعدة البيانات
include '../config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $conn->real_escape_string($_POST['title']);
    $description = $conn->real_escape_string($_POST['description']);
    $image_paths = '';
 $token = bin2hex(random_bytes(10));
    if (!empty($_FILES['images']['name'][0])) {
        $uploads_dir = '../uploads/';
        $images = $_FILES['images'];
        $uploaded_images = [];

        foreach ($images['tmp_name'] as $key => $tmp_name) {
            $file_name = basename($images['name'][$key]);
            $file_path = $uploads_dir . $file_name;

            if (move_uploaded_file($tmp_name, $file_path)) {
                $uploaded_images[] = $file_path;
            }
        }

        $image_paths = implode(',', $uploaded_images);
    }

    $sql = "INSERT INTO news (title, description, image_paths , token) VALUES ('$title', '$description', '$image_paths', '$token')";
    
    if ($conn->query($sql) === TRUE) {
        echo "تم إنشاء المنشور بنجاح";
    } else {
        echo "خطأ: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>محرر منشورات احترافي</title>
    <link rel="stylesheet" href="styles.css">
    <!-- تضمين مكتبة Font Awesome للأيقونات -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</head>
<body>
    <div class="editor-container">
        <div class="toolbar">
            <!-- أدوات تنسيق النص -->
            <button type="button" onclick="document.execCommand('bold')"><i class="fa fa-bold"></i></button>
            <button type="button" onclick="document.execCommand('italic')"><i class="fa fa-italic"></i></button>
            <button type="button" onclick="document.execCommand('underline')"><i class="fa fa-underline"></i></button>
            <button type="button" onclick="document.execCommand('strikeThrough')"><i class="fa fa-strikethrough"></i></button>
            <!-- أدوات التحرير الأساسية -->
            <button type="button" onclick="document.execCommand('cut')"><i class="fa fa-cut"></i></button>
            <button type="button" onclick="document.execCommand('copy')"><i class="fa fa-copy"></i></button>
            <button type="button" onclick="document.execCommand('paste')"><i class="fa fa-paste"></i></button>
            <!-- أدوات القوائم والمحاذاة -->            
            <button type="button" onclick="document.execCommand('insertUnorderedList')"><i class="fa fa-list-ul"></i></button>
            <button type="button" onclick="document.execCommand('insertOrderedList')"><i class="fa fa-list-ol"></i></button>
            <button type="button" onclick="document.execCommand('justifyLeft')"><i class="fa fa-align-left"></i></button>
            <button type="button" onclick="document.execCommand('justifyCenter')"><i class="fa fa-align-center"></i></button>
            <button type="button" onclick="document.execCommand('justifyRight')"><i class="fa fa-align-right"></i></button>
            <button type="button" onclick="document.execCommand('justifyFull')"><i class="fa fa-align-justify"></i></button>
            <!-- زر توليد المنشور بالذكاء الاصطناعي -->            
            <button type="button" onclick="openAIWindow()"><i class="fa fa-robot"></i></button>
            <!-- زر معاينة المحتوى -->            
            <button type="button" onclick="openPreviewWindow()"><i class="fa fa-eye"></i></button>
        </div>
        <!-- منطقة التحرير مع إمكانية التعديل مباشرة -->
        <div id="editor" contenteditable="true">
            <p><code>ابدأ الكتابة هنا...</code></p>
        </div>
    </div>

    <!-- النافذة المنبثقة لتوليد المنشور بالذكاء الاصطناعي -->
    <div id="aiModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAIWindow()">&times;</span>
            <h2>توليد منشور بالذكاء الاصطناعي</h2>
            <label for="aiTitle">عنوان المنشور:</label>
            <input type="text" id="aiTitle" placeholder="أدخل عنوان المنشور">
            <button onclick="generatePost()">إرسال</button>
        </div>
    </div>
    
    <!-- النافذة المنبثقة لمعاينة المحتوى -->
    <div id="previewModal" class="modal">
        <div class="modal-content preview-content">
            <span class="close" onclick="closePreviewWindow()">&times;</span>
            <h2>معاينة المحتوى</h2>
            <div id="previewArea"></div>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
