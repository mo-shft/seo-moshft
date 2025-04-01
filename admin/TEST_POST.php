<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>إنشاء منشور</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>إنشاء منشور جديد</h1>
        <form method="POST" action="" enctype="multipart/form-data">
            <label for="title">العنوان:</label>
            <input type="text" id="title" name="title" required>
            
            <label for="description">الوصف:</label>
            <div class="editor-container">
                <div class="toolbar">
                    <button type="button" onclick="document.execCommand('cut')"><i class="fas fa-cut"></i></button>
                    <button type="button" onclick="document.execCommand('copy')"><i class="fas fa-copy"></i></button>
                    <button type="button" onclick="document.execCommand('paste')"><i class="fas fa-paste"></i></button>
                    <button type="button" onclick="openAIWindow()"><i class="fas fa-robot"></i></button>
                </div>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>

            <label for="images">صور:</label>
            <input type="file" id="images" name="images[]" multiple>
            
            <input type="submit" value="حفظ المنشور">
        </form>
    </div>
    
    <div id="aiModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAIWindow()">&times;</span>
            <h2>توليد منشور بالذكاء الاصطناعي</h2>
            <label for="aiTitle">عنوان المنشور:</label>
            <input type="text" id="aiTitle">
            <button onclick="generatePost()">توليد</button>
        </div>
    </div>
    
    <script src="script.js"></script>
</body>
</html>
