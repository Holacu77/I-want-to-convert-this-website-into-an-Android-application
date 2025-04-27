<?php
require 'csrf.php'; 
require 'auth.php';
require 'config.php';

if (isset($_GET['center_id'])) {
    $center_id = (int) $_GET['center_id'];
        $totalCandidates = $pdo->query("SELECT COUNT(*) FROM candidates")->fetchColumn();
            $stmt = $pdo->prepare("SELECT * FROM stations WHERE center_id = :center_id ORDER BY station_number");
                $stmt->execute(['center_id' => $center_id]);
                    $stations = $stmt->fetchAll();
                        $html = '<div class="list-group">';
                            foreach ($stations as $station) {
                                    $voteCountStmt = $pdo->prepare("SELECT COUNT(*) FROM votes WHERE center_id = :center_id AND station_id = :station_id AND vote_count >= 0");
                                            $voteCountStmt->execute([
                                                        'center_id'  => $center_id,
                                                                    'station_id' => $station['id']
                                                                            ]);
                                                                                    $enteredVotes = $voteCountStmt->fetchColumn();
                                                                                            // إذا تم إدخال الأصوات (حتى وإن كانت 0) لجميع المرشحين يتم تلوين الزر باللون الأخضر
                                                                                                    $buttonClass = ($enteredVotes == $totalCandidates && $totalCandidates > 0)
                                                                                                                ? "list-group-item-success"
                                                                                                                            : "";
                                                                                                                                    $html .= '<button type="button" class="list-group-item ' . $buttonClass . ' list-group-item-action" onclick="selectStation(' . $station['id'] . ', \'' . $station['station_number'] . '\')">محطة ' . $station['station_number'] . '</button>';
                                                                                                                                        }
                                                                                                                                            $html .= '</div>';
                                                                                                                                                echo $html;
                                                                                                                                                }
                                                                                                                                                ?>