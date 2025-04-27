<?php
require 'csrf.php';
require_once 'auth.php';
require 'access_control.php';

$pageTitle = "إضافة مرشح";
require_once 'config.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $candidate_name = trim($_POST['candidate_name']);
        if (!empty($candidate_name)) {
                $stmt = $pdo->prepare("INSERT INTO candidates (candidate_name) VALUES (:candidate_name)");
                        $stmt->execute(['candidate_name' => $candidate_name]);
                                // بعد نجاح الإدخال، يتم إعادة التوجيه لمنع إعادة إرسال النموذج عند تحديث الصفحة
                                        header("Location: add_candidate.php?success=1");
                                                exit;
                                                    } else {
                                                            $message = "يرجى إدخال اسم المرشح.";
                                                                }
                                                                }
                                                                require_once 'header.php';
                                                                ?>
                                                                <?php
                                                                if (isset($_GET['success'])) {
                                                                    echo '<div class="alert alert-info text-center">تم إضافة المرشح بنجاح!</div>';
                                                                    }
                                                                    if (!empty($message)) {
                                                                        echo '<div class="alert alert-danger text-center">'.$message.'</div>';
                                                                        }
                                                                        ?>
                                                                        <div class="card shadow-sm">
                                                                          <div class="card-body">
                                                                                <h2 class="card-title text-center mb-3"><i class="fa-solid fa-user-plus"></i> إضافة مرشح</h2>
                                                                                          <form method="POST">
                                                                                                          <div class="mb-3">
                                                                                                                                  <label class="form-label">اسم المرشح</label>
                                                                                                                                                          <input type="text" name="candidate_name" class="form-control" placeholder="أدخل اسم المرشح" required>
                                                                                                                                                                          </div>
                                                                                                                                                                                          <div class="d-grid gap-2">
                                                                                                                                                                                                                  <button type="submit" class="btn btn-primary btn-custom"><i class="fa-solid fa-check"></i> حفظ</button>
                                                                                                                                                                                                                                  </div>
                                                                                                                                                                                                                                            </form>
                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                              <?php include 'footer.php'; ?>