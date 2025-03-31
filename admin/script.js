// API endpoint والـ API Key الخاصين بتوليد المنشور
const API_URL = "https://api.together.xyz/v1/chat/completions";
const API_KEY = "YOUR_API_TOGETHER";

// دوال التعامل مع النافذة المنبثقة لتوليد المنشور بالذكاء الاصطناعي
function openAIWindow() {
    document.getElementById('aiModal').style.display = 'block';
}

function closeAIWindow() {
    document.getElementById('aiModal').style.display = 'none';
}

// دوال النافذة المنبثقة للمعاينة
function openPreviewWindow() {
    // نسخ محتوى المحرر إلى منطقة المعاينة
    const content = document.getElementById('editor').innerHTML;
    document.getElementById('previewArea').innerHTML = content;
    document.getElementById('previewModal').style.display = 'block';
}

function closePreviewWindow() {
    document.getElementById('previewModal').style.display = 'none';
}

// دالة توليد المنشور باستخدام API الذكاء الاصطناعي
function generatePost() {
    var aiTitle = document.getElementById('aiTitle').value;
    if (!aiTitle.trim()) {
        alert('يرجى إدخال عنوان المنشور');
        return;
    }
    
    // إعداد البيانات المطلوب إرسالها وفق النموذج المطلوب
    const payload = {
        model: "meta-llama/Llama-3.3-70B-Instruct-Turbo",
        messages: [
            { role: "user", content: aiTitle }
        ]
    };

    fetch(API_URL, {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${API_KEY}`,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(data => {
        if (data && data.choices && data.choices.length > 0 && data.choices[0].message && data.choices[0].message.content) {
            // وضع الرد المُولد داخل محرر النصوص
            document.getElementById('editor').innerHTML = data.choices[0].message.content;
        } else {
            alert('حدث خطأ أثناء توليد المنشور');
        }
        closeAIWindow();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء توليد المنشور');
        closeAIWindow();
    });
}

// اغلاق النوافذ عند النقر خارج محتواها
window.onclick = function(event) {
    var aiModal = document.getElementById('aiModal');
    var previewModal = document.getElementById('previewModal');
    if (event.target === aiModal) {
        aiModal.style.display = 'none';
    }
    if (event.target === previewModal) {
        previewModal.style.display = 'none';
    }
};
