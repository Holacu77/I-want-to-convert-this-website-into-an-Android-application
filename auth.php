<?php
require 'csrf.php';


session_start();
if (
    (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) &&
        (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true)
        ) {
            header("Location: login.php");
                exit;
                }
                ?><?php
session_start();
if (
    (!isset($_SESSION['user_logged_in']) || $_SESSION['user_logged_in'] !== true) &&
        (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true)
        ) {
            header("Location: login.php");
                exit;
                }
                ?>