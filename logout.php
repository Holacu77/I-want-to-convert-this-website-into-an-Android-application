<?php
require 'csrf.php'; 
session_start();
require 'config.php';

// إزالة معرف الجلسة من قاعدة البيانات للمستخدم الحالي
if (session_id()) {
    $stmt = $pdo->prepare(
            "UPDATE users SET current_session_id = NULL WHERE current_session_id = ?"
                );
                    $stmt->execute([session_id()]);
                    }

                    // مسح جميع متغيرات الجلسة
                    $_SESSION = [];

                    // حذف كوكي الجلسة من المتصفح
                    if (ini_get('session.use_cookies')) {
                        $params = session_get_cookie_params();
                            setcookie(
                                    session_name(),
                                            '',
                                                    time() - 42000,
                                                            $params['path'],
                                                                    $params['domain'],
                                                                            $params['secure'],
                                                                                    $params['httponly']
                                                                                        );
                                                                                        }

                                                                                        // إنهاء الجلسة بالكامل
                                                                                        session_destroy();

                                                                                        // إعادة التوجيه إلى صفحة تسجيل الدخول
                                                                                        header('Location: login.php');
                                                                                        exit;