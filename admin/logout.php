<?php
// ملف: logout.php
session_start();
/*
******************************************************************************************************************
This plugin was developed by Engineer Mohamed Shaaban. You can visit the following website:  

https://moshft.hup.icu

Powerd by moshft
******************************************************************************************************************
*/
// مسح جميع بيانات الجلسة
session_unset();
session_destroy();

// توجيه إلى صفحة الدخول مع رسالة نجاح
header('Location: login.php?logout=success');
exit;
?>