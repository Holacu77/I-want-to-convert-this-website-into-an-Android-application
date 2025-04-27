<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
// تحديد مسار ملف السجل
$logFile = 'log.txt';

// قراءة محتويات ملف السجل
$logContent = file_exists($logFile) ? file_get_contents($logFile) : 'ملف السجل غير موجود';

// استلام قيمة البحث من خلال GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// تقسيم السجل إلى أسطر
$logLines = explode("\n", $logContent);

// ترشيح الأسطر إذا تم البحث
if ($search !== '') {
    $logLines = array_filter($logLines, function($line) use ($search) {
            return stripos($line, $search) !== false;
                });
                }
                ?>
                <!DOCTYPE html>
                <html lang="ar">
                <head>
                  <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                      <title>عرض السجل</title>
                        <!-- Bootstrap 5 CSS (نسخة RTL) -->
                          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
                            <!-- FontAwesome -->
                              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                                <style>
                                    body {
                                          background-color: #f1f3f5;
                                              }
                                                  .header-title {
                                                        margin-bottom: 2rem;
                                                              font-weight: bold;
                                                                  }
                                                                      .log-line {
                                                                            border-bottom: 1px solid #dee2e6;
                                                                                  padding: 0.5rem 0;
                                                                                        font-size: 0.9rem;
                                                                                            }
                                                                                                .log-line:last-child {
                                                                                                      border-bottom: none;
                                                                                                          }
                                                                                                              /* تحسين حجم الخط على الشاشات الصغيرة */
                                                                                                                  @media (max-width: 576px) {
                                                                                                                        .header-title {
                                                                                                                                font-size: 1.5rem;
                                                                                                                                      }
                                                                                                                                            .log-line {
                                                                                                                                                    font-size: 0.8rem;
                                                                                                                                                          }
                                                                                                                                                              }
                                                                                                                                                                </style>
                                                                                                                                                                </head>
                                                                                                                                                                <body>
                                                                                                                                                                  <div class="container py-4">
                                                                                                                                                                      <h2 class="header-title text-center">عرض السجل</h2>
                                                                                                                                                                          
                                                                                                                                                                              <!-- نموذج البحث مع شبكة متجاوبة -->
                                                                                                                                                                                  <div class="row mb-4">
                                                                                                                                                                                        <div class="col-12 col-md-8 mb-2">
                                                                                                                                                                                                <form class="d-flex" method="get">
                                                                                                                                                                                                          <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control me-2" placeholder="ابحث داخل السجل">
                                                                                                                                                                                                                    <button class="btn btn-primary" type="submit">
                                                                                                                                                                                                                                <i class="fa-solid fa-magnifying-glass"></i> بحث
                                                                                                                                                                                                                                          </button>
                                                                                                                                                                                                                                                  </form>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                              <div class="col-12 col-md-4 text-md-end">
                                                                                                                                                                                                                                                                      <a href="view_log.php" class="btn btn-outline-secondary">
                                                                                                                                                                                                                                                                                <i class="fa-solid fa-rotate"></i> إعادة تعيين
                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                                                                  </div>
                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                          <!-- عرض السجل داخل بطاقة متجاوبة -->
                                                                                                                                                                                                                                                                                                              <div class="card shadow-sm">
                                                                                                                                                                                                                                                                                                                    <div class="card-body">
                                                                                                                                                                                                                                                                                                                            <?php if (!empty($logLines) && is_array($logLines)): ?>
                                                                                                                                                                                                                                                                                                                                      <?php foreach ($logLines as $line): ?>
                                                                                                                                                                                                                                                                                                                                                  <?php if(trim($line) !== ''): ?>
                                                                                                                                                                                                                                                                                                                                                                <div class="log-line"><?php echo htmlspecialchars($line); ?></div>
                                                                                                                                                                                                                                                                                                                                                                            <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                      <?php endforeach; ?>
                                                                                                                                                                                                                                                                                                                                                                                              <?php else: ?>
                                                                                                                                                                                                                                                                                                                                                                                                        <p class="text-center">لا توجد سجلات لعرضها.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                                                                                                                                              
                                                                                                                                                                                                                                                                                                                                                                                                                                  <!-- زر العودة إلى أدوات الإدارة -->
                                                                                                                                                                                                                                                                                                                                                                                                                                      <div class="text-center mt-4">
                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="admin_tools.php" class="btn btn-outline-primary">
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="fa-solid fa-arrow-left"></i> العودة إلى أدوات الإدارة
                                                                                                                                                                                                                                                                                                                                                                                                                                                          </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Bootstrap 5 JS مع Popper -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </body>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </html><?php
// تحديد مسار ملف السجل
$logFile = 'log.txt';

// قراءة محتويات ملف السجل
$logContent = file_exists($logFile) ? file_get_contents($logFile) : 'ملف السجل غير موجود';

// استلام قيمة البحث من خلال GET
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// تقسيم السجل إلى أسطر
$logLines = explode("\n", $logContent);

// ترشيح الأسطر إذا تم البحث
if ($search !== '') {
    $logLines = array_filter($logLines, function($line) use ($search) {
            return stripos($line, $search) !== false;
                });
                }
                ?>
                <!DOCTYPE html>
                <html lang="ar">
                <head>
                  <meta charset="UTF-8">
                    <meta name="viewport" content="width=device-width, initial-scale=1">
                      <title>عرض السجل</title>
                        <!-- Bootstrap 5 CSS (نسخة RTL) -->
                          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
                            <!-- FontAwesome -->
                              <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
                                <style>
                                    body {
                                          background-color: #f1f3f5;
                                              }
                                                  .header-title {
                                                        margin-bottom: 2rem;
                                                              font-weight: bold;
                                                                  }
                                                                      .log-line {
                                                                            border-bottom: 1px solid #dee2e6;
                                                                                  padding: 0.5rem 0;
                                                                                        font-size: 0.9rem;
                                                                                            }
                                                                                                .log-line:last-child {
                                                                                                      border-bottom: none;
                                                                                                          }
                                                                                                              /* تحسين حجم الخط على الشاشات الصغيرة */
                                                                                                                  @media (max-width: 576px) {
                                                                                                                        .header-title {
                                                                                                                                font-size: 1.5rem;
                                                                                                                                      }
                                                                                                                                            .log-line {
                                                                                                                                                    font-size: 0.8rem;
                                                                                                                                                          }
                                                                                                                                                              }
                                                                                                                                                                </style>
                                                                                                                                                                </head>
                                                                                                                                                                <body>
                                                                                                                                                                  <div class="container py-4">
                                                                                                                                                                      <h2 class="header-title text-center">عرض السجل</h2>
                                                                                                                                                                          
                                                                                                                                                                              <!-- نموذج البحث مع شبكة متجاوبة -->
                                                                                                                                                                                  <div class="row mb-4">
                                                                                                                                                                                        <div class="col-12 col-md-8 mb-2">
                                                                                                                                                                                                <form class="d-flex" method="get">
                                                                                                                                                                                                          <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" class="form-control me-2" placeholder="ابحث داخل السجل">
                                                                                                                                                                                                                    <button class="btn btn-primary" type="submit">
                                                                                                                                                                                                                                <i class="fa-solid fa-magnifying-glass"></i> بحث
                                                                                                                                                                                                                                          </button>
                                                                                                                                                                                                                                                  </form>
                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                              <div class="col-12 col-md-4 text-md-end">
                                                                                                                                                                                                                                                                      <a href="view_log.php" class="btn btn-outline-secondary">
                                                                                                                                                                                                                                                                                <i class="fa-solid fa-rotate"></i> إعادة تعيين
                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                                                                  </div>
                                                                                                                                                                                                                                                                                                      
                                                                                                                                                                                                                                                                                                          <!-- عرض السجل داخل بطاقة متجاوبة -->
                                                                                                                                                                                                                                                                                                              <div class="card shadow-sm">
                                                                                                                                                                                                                                                                                                                    <div class="card-body">
                                                                                                                                                                                                                                                                                                                            <?php if (!empty($logLines) && is_array($logLines)): ?>
                                                                                                                                                                                                                                                                                                                                      <?php foreach ($logLines as $line): ?>
                                                                                                                                                                                                                                                                                                                                                  <?php if(trim($line) !== ''): ?>
                                                                                                                                                                                                                                                                                                                                                                <div class="log-line"><?php echo htmlspecialchars($line); ?></div>
                                                                                                                                                                                                                                                                                                                                                                            <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                      <?php endforeach; ?>
                                                                                                                                                                                                                                                                                                                                                                                              <?php else: ?>
                                                                                                                                                                                                                                                                                                                                                                                                        <p class="text-center">لا توجد سجلات لعرضها.</p>
                                                                                                                                                                                                                                                                                                                                                                                                                <?php endif; ?>
                                                                                                                                                                                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                                                                                                                                              
                                                                                                                                                                                                                                                                                                                                                                                                                                  <!-- زر العودة إلى أدوات الإدارة -->
                                                                                                                                                                                                                                                                                                                                                                                                                                      <div class="text-center mt-4">
                                                                                                                                                                                                                                                                                                                                                                                                                                            <a href="admin_tools.php" class="btn btn-outline-primary">
                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="fa-solid fa-arrow-left"></i> العودة إلى أدوات الإدارة
                                                                                                                                                                                                                                                                                                                                                                                                                                                          </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <!-- Bootstrap 5 JS مع Popper -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </body>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                      </html>