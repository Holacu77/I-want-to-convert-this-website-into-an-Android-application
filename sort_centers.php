<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
require 'config.php';

// جلب العدد الكلي للمرشحين
$totalCandidates = $pdo->query("SELECT COUNT(*) FROM candidates")->fetchColumn();

// جلب جميع المراكز
$stmt = $pdo->query("SELECT * FROM centers");
$centers = $stmt->fetchAll();

$completed = [];
$incomplete = [];

// تقسيم المراكز إلى مكتملة وغير مكتملة
foreach ($centers as $center) {
    $centerId = $center['id'];
        
            // جلب عدد المحطات الخاصة بالمركز
                $totalStationsStmt = $pdo->prepare("SELECT COUNT(*) FROM stations WHERE center_id = ?");
                    $totalStationsStmt->execute([$centerId]);
                        $totalStations = $totalStationsStmt->fetchColumn();
                            
                                $completeStations = 0;
                                    
                                        // التحقق من كل محطة للتأكد من وجود سجل صوت لكل مرشح (حتى وإن كانت القيمة 0)
                                            $stationsStmt = $pdo->prepare("SELECT id FROM stations WHERE center_id = ?");
                                                $stationsStmt->execute([$centerId]);
                                                    while ($station = $stationsStmt->fetch()) {
                                                            $voteCountStmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE center_id = ? AND station_id = ? AND vote_count >= 0");
                                                                    $voteCountStmt->execute([$centerId, $station['id']]);
                                                                            $enteredVotes = $voteCountStmt->fetchColumn();
                                                                                    
                                                                                            if ($enteredVotes == $totalCandidates && $totalCandidates > 0) {
                                                                                                        $completeStations++;
                                                                                                                }
                                                                                                                    }
                                                                                                                        
                                                                                                                            // تصنيف المركز بناءً على اكتمال جميع محطاته
                                                                                                                                if ($totalStations > 0 && $completeStations == $totalStations) {
                                                                                                                                        $completed[] = $center;
                                                                                                                                            } else {
                                                                                                                                                    $incomplete[] = $center;
                                                                                                                                                        }
                                                                                                                                                        }

                                                                                                                                                        // ترتيب المراكز المكتملة وغير المكتملة أبجدياً حسب اسم المركز
                                                                                                                                                        usort($completed, function($a, $b){ 
                                                                                                                                                            return strcmp($a['center_name'], $b['center_name']); 
                                                                                                                                                            });
                                                                                                                                                            usort($incomplete, function($a, $b){ 
                                                                                                                                                                return strcmp($a['center_name'], $b['center_name']); 
                                                                                                                                                                });

                                                                                                                                                                // دمج القائمة بحيث تظهر المراكز المكتملة أولاً ثم غير المكتملة
                                                                                                                                                                $sorted = array_merge($completed, $incomplete);
                                                                                                                                                                $html = '';

                                                                                                                                                                if (empty($sorted)) {
                                                                                                                                                                    $html .= "<p>لا توجد مراكز مطابقة للشروط.</p>";
                                                                                                                                                                    } else {
                                                                                                                                                                        // إنشاء زر لكل مركز مع تلوين مختلف للمراكز المكتملة
                                                                                                                                                                            foreach ($sorted as $center) {
                                                                                                                                                                                    $centerId = $center['id'];
                                                                                                                                                                                            
                                                                                                                                                                                                    $totalStationsStmt = $pdo->prepare("SELECT COUNT(*) FROM stations WHERE center_id = ?");
                                                                                                                                                                                                            $totalStationsStmt->execute([$centerId]);
                                                                                                                                                                                                                    $totalStations = $totalStationsStmt->fetchColumn();
                                                                                                                                                                                                                            
                                                                                                                                                                                                                                    $completeStations = 0;
                                                                                                                                                                                                                                            $stationsStmt = $pdo->prepare("SELECT id FROM stations WHERE center_id = ?");
                                                                                                                                                                                                                                                    $stationsStmt->execute([$centerId]);
                                                                                                                                                                                                                                                            while ($station = $stationsStmt->fetch()) {
                                                                                                                                                                                                                                                                        $voteCountStmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE center_id = ? AND station_id = ? AND vote_count >= 0");
                                                                                                                                                                                                                                                                                    $voteCountStmt->execute([$centerId, $station['id']]);
                                                                                                                                                                                                                                                                                                $enteredVotes = $voteCountStmt->fetchColumn();
                                                                                                                                                                                                                                                                                                            
                                                                                                                                                                                                                                                                                                                        if ($enteredVotes == $totalCandidates && $totalCandidates > 0) {
                                                                                                                                                                                                                                                                                                                                        $completeStations++;
                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                    
                                                                                                                                                                                                                                                                                                                                                                            $centerButtonClass = ($totalStations > 0 && $completeStations == $totalStations)
                                                                                                                                                                                                                                                                                                                                                                                                      ? "list-group-item-success"
                                                                                                                                                                                                                                                                                                                                                                                                                                : "list-group-item-secondary";
                                                                                                                                                                                                                                                                                                                                                                                                                                        
                                                                                                                                                                                                                                                                                                                                                                                                                                                $html .= '<button type="button" class="list-group-item ' . $centerButtonClass . ' list-group-item-action" onclick="selectCenter(' . $centerId . ', \'' . addslashes($center['center_name']) . '\')">';
                                                                                                                                                                                                                                                                                                                                                                                                                                                        $html .= htmlspecialchars($center['center_name']);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                $html .= '</button>';
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    }

                                                                                                                                                                                                                                                                                                                                                                                                                                                                    echo $html;
                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ?>