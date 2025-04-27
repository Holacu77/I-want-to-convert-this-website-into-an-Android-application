<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
session_start();
if (!isset($_SESSION["admin_logged_in"])) {
    header("Location: admin_login.php");
        exit;
        }
        $pageTitle = "رفع وتصدير البيانات";
        require 'config.php';
        include 'header.php';
        ?><style>
        .management-card {
            margin: 40px auto;
                max-width: 800px;
                    background: transparent;
                        border-radius: 15px;
                            box-shadow: 0 8px 16px rgba(0,0,0,0.15);
                                padding: 30px;
                                }
                                .management-card h2 {
                                    font-weight: bold;
                                        color: #333;
                                            margin-bottom: 30px;
                                            }
                                            .management-btn {
                                                font-size: 1.1rem;
                                                    border-radius: 10px;
                                                        padding: 15px;
                                                            display: flex;
                                                                align-items: center;
                                                                    justify-content: center;
                                                                        transition: all 0.3s ease;
                                                                        }
                                                                        .management-btn i {
                                                                            margin-left: 10px;
                                                                                font-size: 1.3rem;
                                                                                }
                                                                                .management-btn:hover {
                                                                                    transform: translateY(-3px);
                                                                                        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                                                                                        }
                                                                                        .back-btn {
                                                                                            margin-top: 25px;
                                                                                            }
                                                                                            </style><div class="container">
                                                                                              <div class="management-card text-center">
                                                                                                  <h2>رفع وتصدير البيانات</h2>
                                                                                                      <div class="row g-4">
                                                                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                                                                    <a href="upload_csv.php" class="btn btn-primary management-btn w-100" title="رفع للمراكز CSV">
                                                                                                                              رفع للمراكز CSV
                                                                                                                                        <i class="fa-solid fa-file-csv"></i>
                                                                                                                                                </a>
                                                                                                                                                      </div>
                                                                                                                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                                                                                                                    <a href="candidates_upload.php" class="btn btn-success management-btn w-100" title="رفع CSV للمرشحين">
                                                                                                                                                                              رفع CSV للمرشحين
                                                                                                                                                                                        <i class="fa-solid fa-user-group"></i>
                                                                                                                                                                                                </a>
                                                                                                                                                                                                      </div>
                                                                                                                                                                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                                                                                                                                                                    <a href="export_results.php" class="btn btn-secondary management-btn w-100" title="تصدير النتائج">
                                                                                                                                                                                                                              تصدير
                                                                                                                                                                                                                                        <i class="fa-solid fa-download"></i>
                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                            <div class="col-12 col-md-6 col-lg-3">
                                                                                                                                                                                                                                                                    <a href="backup.php" class="btn btn-warning management-btn w-100" title="باكاب واسترجاع البيانات">
                                                                                                                                                                                                                                                                              باكاب
                                                                                                                                                                                                                                                                                        <i class="fa-solid fa-database"></i>
                                                                                                                                                                                                                                                                                                </a>
                                                                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                                                                          </div>
                                                                                                                                                                                                                                                                                                              <div class="text-center back-btn">
                                                                                                                                                                                                                                                                                                                    <a href="site_management.php" class="btn btn-secondary management-btn" title="عودة">
                                                                                                                                                                                                                                                                                                                            <i class="fa-solid fa-arrow-left"></i> العودة
                                                                                                                                                                                                                                                                                                                                  </a>
                                                                                                                                                                                                                                                                                                                                      </div>
                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                        <?php include 'footer.php'; ?>