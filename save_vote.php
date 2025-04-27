<?php
require 'csrf.php';
require 'auth.php';
header('Content-Type: application/json');
if ($_SESSION['account_type'] === 'viewer') {
    echo json_encode(["status" => "error", "message" => "ليس لديك صلاحية لإدخال الأصوات."]);
        exit;
        }
        $pageTitle = "حفظ الأصوات";
        require 'config.php';

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $center_id    = $_POST['center_id']    ?? null;
                $station_id   = $_POST['station_id']   ?? null;
                    $candidate_id = $_POST['candidate_id'] ?? null;
                        $vote_count   = $_POST['vote_count']   ?? null;

                            if ($center_id && $station_id && $candidate_id && $vote_count !== null) {
                                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE center_id = ? AND station_id = ? AND candidate_id = ?");
                                            $stmt->execute([$center_id, $station_id, $candidate_id]);
                                                    if ($stmt->fetchColumn() > 0) {
                                                                $stmt = $pdo->prepare("UPDATE votes SET vote_count = ? WHERE center_id = ? AND station_id = ? AND candidate_id = ?");
                                                                            $stmt->execute([$vote_count, $center_id, $station_id, $candidate_id]);
                                                                                    } else {
                                                                                                $stmt = $pdo->prepare("INSERT INTO votes (center_id, station_id, candidate_id, vote_count) VALUES (?, ?, ?, ?)");
                                                                                                            $stmt->execute([$center_id, $station_id, $candidate_id, $vote_count]);
                                                                                                                    }
                                                                                                                            echo json_encode(["status" => "success", "message" => "تم حفظ الأصوات"]);
                                                                                                                                } else {
                                                                                                                                        echo json_encode(["status" => "error", "message" => "بيانات غير كافية لحفظ الأصوات"]);
                                                                                                                                            }
                                                                                                                                            } else {
                                                                                                                                                echo json_encode(["status" => "error", "message" => "طلب غير صحيح"]);
                                                                                                                                                }