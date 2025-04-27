<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
$pageTitle = "إدارة المراكز";
require 'config.php';

if (isset($_GET['delete'])) {
    $center_id = (int) $_GET['delete'];
        $stmt = $pdo->prepare("DELETE FROM stations WHERE center_id = :center_id");
            $stmt->execute(['center_id' => $center_id]);
                $stmt = $pdo->prepare("DELETE FROM votes WHERE center_id = :center_id");
                    $stmt->execute(['center_id' => $center_id]);
                        $stmt = $pdo->prepare("DELETE FROM centers WHERE id = :center_id");
                            $stmt->execute(['center_id' => $center_id]);
                                header("Location: centers_list.php");
                                    exit;
                                    }

                                    $stmt = $pdo->query("SELECT * FROM centers ORDER BY center_name");
                                    $centers = $stmt->fetchAll();
                                    include 'header.php';
                                    ?>
                                    <h2 class="text-center mb-3">إدارة المراكز</h2>
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
                                                                                      <?php if($centers): ?>
                                                                                              <?php foreach($centers as $center): ?>
                                                                                                        <tr>
                                                                                                                    <td><?php echo htmlspecialchars($center['center_name']); ?></td>
                                                                                                                                <td>
                                                                                                                                              <a href="centers_list.php?delete=<?php echo $center['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف هذا المركز؟');">حذف</a>
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
                                                                                                                                                                                                                        <div class="text-center">
                                                                                                                                                                                                                          <a href="index.php" class="btn btn-secondary btn-custom">عودة</a>
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