<?php
// csrf.php: ملف حماية CSRF كامل
// يشمل في بداية أي صفحة تريد تفعيل الحماية فيها

// بدء الجلسة إذا لم تكن مفعلة
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    }

    // توليد التوكن إن لم يكن موجوداً
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        // التحقق من التوكن في طلبات POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
                if (!hash_equals($_SESSION['csrf_token'], $token)) {
                        // يمكنك تغيير التحويل لصفحة خطأ أو عرض رسالة مخصصة
                                http_response_code(403);
                                        exit('خطأ أمني: فشل التحقق من CSRF.');
                                            }
                                            }

                                            // بدء Output Buffering لإضافة حقل مخفي لكل <form>
                                            ob_start(function($buffer) {
                                                $token = $_SESSION['csrf_token'];
                                                    // إدراج حقل CSRF داخل كل نموذج
                                                        return preg_replace(
                                                                '/<form\b([^>]*)>/i',
                                                                        '<form$1><input type="hidden" name="csrf_token" value="' . $token . '">',
                                                                                $buffer
                                                                                    );
                                                                                    });
                                                                                    ?>