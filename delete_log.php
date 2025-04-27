<?php
require 'csrf.php'; 
require 'auth.php';
require 'access_control.php';
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
        exit;
        }
        if (file_exists('logs.txt')) {
            unlink('logs.txt');
            }
            header("Location: log.php?msg=" . urlencode("تم حذف السجلات."));
            exit;
            ?><?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
        exit;
        }
        if (file_exists('logs.txt')) {
            unlink('logs.txt');
            }
            header("Location: log.php?msg=" . urlencode("تم حذف السجلات."));
            exit;
            ?>