<?php
require 'csrf.php'; 
session_start();
require 'config.php';



// تحديث current_session_id في قاعدة البيانات للمستخدم الحالي (الأدمن)
if (session_id()) {
    $stmt = $pdo->prepare("UPDATE users SET current_session_id = '' WHERE current_session_id = ?");
        $stmt->execute([session_id()]);
        }

        // مسح بيانات الجلسة وإنهاء الجلسة
        session_unset();
        session_destroy();

        // إعادة التوجيه إلى صفحة تسجيل دخول الأدمن
        header("Location: admin_login.php");
        exit;
        ?>