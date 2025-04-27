<?php
// قصر الوصول على الأدمن فقط
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
        exit;
        }

        require 'config.php';
        $pageTitle = 'النسخ الاحتياطي';
        include 'header.php';

        $bk_dir    = __DIR__ . '/bk';
        $flag_file = "$bk_dir/auto_backup_enabled.txt";

        // 1) إنشاء مجلد النسخ إذا لم يكن موجوداً
        if (!is_dir($bk_dir)) {
            mkdir($bk_dir, 0755, true);
                chmod($bk_dir, 0755);
                }

                // 2) تبديل حالة النسخ التلقائي
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_auto'])) {
                    $state = ($_POST['toggle_auto'] === 'enable') ? '1' : '0';
                        file_put_contents($flag_file, $state);
                            $message = $state === '1'
                                    ? '✔ تم تفعيل النسخ الاحتياطي التلقائي.'
                                            : '✔ تم إيقاف النسخ الاحتياطي التلقائي.';
                                            }

                                            // 3) عرض رسالة من GET (dobackup أو uplobak)
                                            if (isset($_GET['msg'])) {
                                                $message = htmlspecialchars($_GET['msg']);
                                                }

                                                // 4) قراءة حالة التشغيل التلقائي
                                                $auto = file_exists($flag_file) && trim(file_get_contents($flag_file)) === '1';
                                                ?>

                                                <?php if (!empty($message)): ?>
                                                  <div class="alert alert-info text-center"><?php echo $message; ?></div>
                                                  <?php endif; ?>

                                                  <div class="card shadow-sm mb-4">
                                                    <div class="card-body text-center">
                                                        <h2 class="card-title mb-3"><i class="fa-solid fa-database"></i> النسخ الاحتياطي</h2>
                                                            <div class="d-grid gap-2">
                                                                  <a href="dobackup.php" class="btn btn-primary btn-custom">
                                                                          <i class="fa-solid fa-download"></i> تحميل باكاب
                                                                                </a>
                                                                                      <a href="uplobak.php" class="btn btn-warning btn-custom">
                                                                                              <i class="fa-solid fa-upload"></i> رفع باكاب
                                                                                                    </a>
                                                                                                          <form method="post" style="margin:0;">
                                                                                                                  <input type="hidden" name="toggle_auto" value="<?php echo $auto ? 'disable' : 'enable'; ?>">
                                                                                                                          <button type="submit" class="btn <?php echo $auto ? 'btn-danger' : 'btn-success'; ?> btn-custom">
                                                                                                                                    <i class="fa-solid <?php echo $auto ? 'fa-spinner fa-spin' : 'fa-play'; ?>"></i> باكاب تلقائي
                                                                                                                                            </button>
                                                                                                                                                  </form>
                                                                                                                                                      </div>
                                                                                                                                                          <div class="mt-3">
                                                                                                                                                                <?php if ($auto): ?>
                                                                                                                                                                        <span class="badge bg-success">التلقائي مفعل</span>
                                                                                                                                                                              <?php else: ?>
                                                                                                                                                                                      <span class="badge bg-secondary">التلقائي متوقف</span>
                                                                                                                                                                                            <?php endif; ?>
                                                                                                                                                                                                </div>
                                                                                                                                                                                                  </div>
                                                                                                                                                                                                  </div>

                                                                                                                                                                                                  <?php include 'footer.php'; ?>