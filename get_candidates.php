<?php
require 'csrf.php'; 
require 'auth.php';
require 'config.php';

if (isset($_GET['center_id']) && isset($_GET['station_id'])) {
    $center_id = (int) $_GET['center_id'];
        $station_id = (int) $_GET['station_id'];
            $stmt = $pdo->query("SELECT * FROM candidates ORDER BY candidate_name");
                $candidates = $stmt->fetchAll();
                    $html = '<div class="list-group">';
                        foreach ($candidates as $candidate) {
                                $stmtVote = $pdo->prepare(
                                            "SELECT vote_count FROM votes 
                                                         WHERE center_id = :center_id 
                                                                      AND station_id = :station_id 
                                                                                   AND candidate_id = :candidate_id"
                                                                                           );
                                                                                                   $stmtVote->execute([
                                                                                                               'center_id'    => $center_id,
                                                                                                                           'station_id'   => $station_id,
                                                                                                                                       'candidate_id' => $candidate['id']
                                                                                                                                               ]);
                                                                                                                                                       $vote = $stmtVote->fetch();
                                                                                                                                                               $voteCount = $vote ? $vote['vote_count'] : "";
                                                                                                                                                                       // إذا وُجد سجل (حتى وإن كانت القيمة 0) يتم تلوين الزر باللون الأخضر
                                                                                                                                                                               $buttonClass = ($vote) ? "list-group-item-success" : "list-group-item-secondary";
                                                                                                                                                                                       $html .= '<button type="button" class="list-group-item ' . $buttonClass . ' list-group-item-action" onclick="selectCandidate(' . $candidate['id'] . ', \'' . addslashes($candidate['candidate_name']) . '\', \'' . $voteCount . '\')">';
                                                                                                                                                                                               $html .= htmlspecialchars($candidate['candidate_name']);
                                                                                                                                                                                                       $html .= '</button>';
                                                                                                                                                                                                           }
                                                                                                                                                                                                               $html .= '</div>';
                                                                                                                                                                                                                   echo $html;
                                                                                                                                                                                                                   }
                                                                                                                                                                                                                   ?>