<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
session_start();
require 'config.php';

// التأكد من صلاحية المسؤول فقط
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'admin') {
    header("Location: index.php");
        exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $message = "";
                
                    // معالجة تغيير الشعار
                        if (isset($_POST['update_logo']) && isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                                $logoTmpPath = $_FILES['logo']['tmp_name'];
                                        $logoName = basename($_FILES['logo']['name']);
                                                $uploadFileDir = './uploads/'; // تأكد من وجود هذا المجلد وصلاحيات الكتابة به
                                                        $dest_path = $uploadFileDir . $logoName;
                                                                
                                                                        if (move_uploaded_file($logoTmpPath, $dest_path)) {
                                                                                    // تحديث إعدادات الشعار في ملف إعدادات أو قاعدة بيانات (مثال هنا باستخدام ملف نصي)
                                                                                                file_put_contents('site_logo.txt', $dest_path);
                                                                                                            $message .= "تم تحديث الشعار بنجاح. ";
                                                                                                                    } else {
                                                                                                                                $message .= "حدث خطأ أثناء رفع الشعار. ";
                                                                                                                                        }
                                                                                                                                            }
                                                                                                                                                
                                                                                                                                                    // معالجة تغيير الخلفية
                                                                                                                                                        if (isset($_POST['update_background']) && isset($_FILES['background']) && $_FILES['background']['error'] === UPLOAD_ERR_OK) {
                                                                                                                                                                $bgTmpPath = $_FILES['background']['tmp_name'];
                                                                                                                                                                        $bgName = basename($_FILES['background']['name']);
                                                                                                                                                                                $uploadFileDir = './uploads/';
                                                                                                                                                                                        $dest_path = $uploadFileDir . $bgName;
                                                                                                                                                                                                
                                                                                                                                                                                                        if (move_uploaded_file($bgTmpPath, $dest_path)) {
                                                                                                                                                                                                                    // تحديث إعدادات الخلفية (مثال باستخدام ملف نصي)
                                                                                                                                                                                                                                file_put_contents('site_background.txt', $dest_path);
                                                                                                                                                                                                                                            $message .= "تم تحديث الخلفية بنجاح.";
                                                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                                                                $message .= "حدث خطأ أثناء رفع الخلفية.";
                                                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                
                                                                                                                                                                                                                                                                                    // يمكنك إضافة معالجة أقسام أخرى هنا بنفس النمط
                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                            header("Location: site_settings.php?msg=" . urlencode($message));
                                                                                                                                                                                                                                                                                                exit;
                                                                                                                                                                                                                                                                                                }
                                                                                                                                                                                                                                                                                                ?>