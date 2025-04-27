<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
        exit;
        }
        $pageTitle = "إدارة المراكز";
        require 'config.php';
        include 'header.php';

        // عرض رسالة النجاح إذا وُجدت
        if (isset($_GET['msg'])) {
            echo '<div class="alert alert-info text-center">' . htmlspecialchars($_GET['msg']) . '</div>';
            }

            if (isset($_GET['deleteall'])) {
                $stmt = $pdo->prepare("DELETE FROM centers");
                    $stmt->execute();
                        header("Location: manage_centers.php?msg=" . urlencode("تم حذف جميع المراكز بنجاح"));
                            exit;
                            }

                            if (isset($_GET['delete'])) {
                                $center_id = (int) $_GET['delete'];
                                    $stmt = $pdo->prepare("DELETE FROM stations WHERE center_id = :center_id");
                                        $stmt->execute(['center_id' => $center_id]);
                                            $stmt = $pdo->prepare("DELETE FROM votes WHERE center_id = :center_id");
                                                $stmt->execute(['center_id' => $center_id]);
                                                    $stmt = $pdo->prepare("DELETE FROM centers WHERE id = :center_id");
                                                        $stmt->execute(['center_id' => $center_id]);
                                                            header("Location: manage_centers.php?msg=" . urlencode("تم حذف المركز بنجاح"));
                                                                exit;
                                                                }

                                                                $stmt = $pdo->query("SELECT * FROM centers ORDER BY center_name");
                                                                $centers = $stmt->fetchAll();
                                                                ?>
                                                                <h2 class="text-center mb-3">إدارة المراكز</h2>
                                                                <div class="text-end mb-2">
                                                                  <a href="manage_centers.php?deleteall=1" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف جميع المراكز؟');">حذف الكل</a>
                                                                  </div>
                                                                  <div class="mb-3">
                                                                    <input type="text" id="searchCenter" class="form-control" placeholder="ابحث عن مركز...">
                                                                    </div>
                                                                    <div class="table-responsive">
                                                                      <table class="table table-hover table-bordered" id="centersTable">
                                                                          <thead class="table-dark">
                                                                                <tr>
                                                                                        <th>اسم المركز</th>
                                                                                                <th>الإجراءات</th>
                                                                                                      </tr>
                                                                                                          </thead>
                                                                                                              <tbody>
                                                                                                                    <?php if ($centers): ?>
                                                                                                                            <?php foreach ($centers as $center): ?>
                                                                                                                                      <tr>
                                                                                                                                                  <td><?php echo htmlspecialchars($center['center_name']); ?></td>
                                                                                                                                                              <td>
                                                                                                                                                                            <a href="manage_centers.php?delete=<?php echo $center['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المركز؟');">حذف</a>
                                                                                                                                                                                        </td>
                                                                                                                                                                                                  </tr>
                                                                                                                                                                                                          <?php endforeach; ?>
                                                                                                                                                                                                                <?php else: ?>
                                                                                                                                                                                                                        <tr>
                                                                                                                                                                                                                                  <td colspan="2" class="text-center">لا توجد مراكز مضافة حتى الآن.</td>
                                                                                                                                                                                                                                          </tr>
                                                                                                                                                                                                                                                <?php endif; ?>
                                                                                                                                                                                                                                                    </tbody>
                                                                                                                                                                                                                                                      </table>
                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                      <script>
                                                                                                                                                                                                                                                      document.getElementById('searchCenter').addEventListener('keyup', function(){
                                                                                                                                                                                                                                                        let filter = this.value.toLowerCase();
                                                                                                                                                                                                                                                          let rows = document.querySelectorAll('#centersTable tbody tr');
                                                                                                                                                                                                                                                            rows.forEach(row => {
                                                                                                                                                                                                                                                                let centerName = row.cells[0].textContent.toLowerCase();
                                                                                                                                                                                                                                                                    row.style.display = centerName.includes(filter) ? '' : 'none';
                                                                                                                                                                                                                                                                      });
                                                                                                                                                                                                                                                                      });
                                                                                                                                                                                                                                                                      </script>
                                                                                                                                                                                                                                                                      <?php include 'footer.php'; ?>