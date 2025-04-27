<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
        exit;
        }
        $pageTitle = "إدارة المرشحين";
        require 'config.php';
        include 'header.php';

        // عرض رسالة النجاح إذا وُجدت
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-info text-center">' . htmlspecialchars($_GET['msg']) . '</div>';
            }

            if (isset($_GET['deleteall'])) {
                $pdo->query("DELETE FROM votes");
                    $pdo->query("DELETE FROM candidates");
                        header("Location: manage_candidates.php?msg=" . urlencode("تم حذف جميع المرشحين بنجاح"));
                            exit;
                            }

                            if (isset($_GET['delete'])) {
                                $candidate_id = (int) $_GET['delete'];
                                    $stmt = $pdo->prepare("DELETE FROM votes WHERE candidate_id = :candidate_id");
                                        $stmt->execute(['candidate_id' => $candidate_id]);
                                            $stmt = $pdo->prepare("DELETE FROM candidates WHERE id = :candidate_id");
                                                $stmt->execute(['candidate_id' => $candidate_id]);
                                                    header("Location: manage_candidates.php?msg=" . urlencode("تم حذف المرشح بنجاح"));
                                                        exit;
                                                        }

                                                        $stmt = $pdo->query("SELECT * FROM candidates ORDER BY candidate_name");
                                                        $candidates = $stmt->fetchAll();
                                                        ?>
                                                        <h2 class="text-center mb-3">إدارة المرشحين</h2>
                                                        <div class="text-end mb-2">
                                                          <a href="manage_candidates.php?deleteall=1" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف جميع المرشحين؟');">حذف الكل</a>
                                                          </div>
                                                          <div class="mb-3">
                                                            <input type="text" id="searchCandidate" class="form-control" placeholder="ابحث عن مرشح...">
                                                            </div>
                                                            <div class="table-responsive">
                                                              <table class="table table-hover table-bordered" id="candidatesTable">
                                                                  <thead class="table-dark">
                                                                        <tr>
                                                                                <th>اسم المرشح</th>
                                                                                        <th>الإجراءات</th>
                                                                                              </tr>
                                                                                                  </thead>
                                                                                                      <tbody>
                                                                                                            <?php if ($candidates): ?>
                                                                                                                    <?php foreach ($candidates as $candidate): ?>
                                                                                                                              <tr>
                                                                                                                                          <td><?php echo htmlspecialchars($candidate['candidate_name']); ?></td>
                                                                                                                                                      <td>
                                                                                                                                                                    <a href="manage_candidates.php?delete=<?php echo $candidate['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المرشح؟');">حذف</a>
                                                                                                                                                                                </td>
                                                                                                                                                                                          </tr>
                                                                                                                                                                                                  <?php endforeach; ?>
                                                                                                                                                                                                        <?php else: ?>
                                                                                                                                                                                                                <tr>
                                                                                                                                                                                                                          <td colspan="2" class="text-center">لا توجد مرشحين مسجلين حتى الآن.</td>
                                                                                                                                                                                                                                  </tr>
                                                                                                                                                                                                                                        <?php endif; ?>
                                                                                                                                                                                                                                            </tbody>
                                                                                                                                                                                                                                              </table>
                                                                                                                                                                                                                                              </div>
                                                                                                                                                                                                                                              <script>
                                                                                                                                                                                                                                              document.getElementById('searchCandidate').addEventListener('keyup', function(){
                                                                                                                                                                                                                                                let filter = this.value.toLowerCase();
                                                                                                                                                                                                                                                  let rows = document.querySelectorAll('#candidatesTable tbody tr');
                                                                                                                                                                                                                                                    rows.forEach(row => {
                                                                                                                                                                                                                                                        let candidateName = row.cells[0].textContent.toLowerCase();
                                                                                                                                                                                                                                                            row.style.display = candidateName.includes(filter) ? '' : 'none';
                                                                                                                                                                                                                                                              });
                                                                                                                                                                                                                                                              });
                                                                                                                                                                                                                                                              </script>
                                                                                                                                                                                                                                                              <?php include 'footer.php'; ?>