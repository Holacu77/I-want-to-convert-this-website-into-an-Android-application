<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
// قصر الوصول على الأدمن فقط
require_once 'auth.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
        exit;
        }

        // تضمين إعدادات الاتصال وقواعد النسخ الاحتياطي مرة واحدة
        require_once 'config.php';
        require_once 'backup_functions.php';

        // تحديد مجلد النسخ الاحتياطي
        $bk_dir = __DIR__ . '/bk';
        if (!is_dir($bk_dir)) {
            if (!mkdir($bk_dir, 0755, true) || !chmod($bk_dir, 0755)) {
                    die('خطأ: تعذّر إنشاء مجلد النسخ الاحتياطية.');
                        }
                        }

                        // إنشاء النسخة الاحتياطية مع التقاط الاستثناءات
                        try {
                            createBackup($bk_dir);
                            } catch (Exception $e) {
                                die('خطأ أثناء إنشاء النسخة الاحتياطية: ' . $e->getMessage());
                                }

                                // جلب أحدث أرشيف ZIP
                                $files = glob("{$bk_dir}/backup_*.zip");
                                usort($files, function($a, $b) {
                                    return filemtime($b) - filemtime($a);
                                    });
                                    $latest = $files[0] ?? null;

                                    if (!$latest) {
                                        header('Location: backup.php?msg=' . urlencode('✖ خطأ: لم يتم إنشاء النسخة.'));
                                            exit;
                                            }

                                            // إرسال الأرشيف للمتصفح
                                            header('Content-Description: File Transfer');
                                            header('Content-Type: application/zip');
                                            header('Content-Disposition: attachment; filename="' . basename($latest) . '"');
                                            header('Expires: 0');
                                            header('Cache-Control: must-revalidate');
                                            header('Pragma: public');
                                            header('Content-Length: ' . filesize($latest));
                                            readfile($latest);
                                            exit;