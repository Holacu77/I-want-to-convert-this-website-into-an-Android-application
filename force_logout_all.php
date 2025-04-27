<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
session_start();
if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
        exit;
        }

        require 'config.php';

        // تحديث قاعدة البيانات لمسح current_session_id لكل المستخدمين
        $stmt = $pdo->prepare("UPDATE users SET current_session_id = ''");
        $stmt->execute();

        // محاولة حذف ملفات جلسات PHP (باستثناء جلسة الأدمن الحالي)
        $sessionPath = session_save_path();
        if (empty($sessionPath)) {
            $sessionPath = sys_get_temp_dir();
            }
            $sessionFiles = glob($sessionPath . "/sess_*");
            $currentSessionFile = $sessionPath . "/sess_" . session_id();
            foreach ($sessionFiles as $file) {
                if ($file !== $currentSessionFile) {
                        @unlink($file);
                            }
                            }

                            header("Location: admin_tools.php?msg=" . urlencode("تم تسجيل خروج الجميع بنجاح."));
                            exit;
                            ?>