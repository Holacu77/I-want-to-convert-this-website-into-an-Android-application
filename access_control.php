<?php
require 'csrf.php';
require 'auth.php';


session_start();

/*
 * ملف access_control_block.php
  * الهدف: منع وصول الحسابات من نوع "normal" و "viewer" فقط،
   * والسماح لباقي الحسابات (مثل "admin"، "agent" أو أي نوع آخر) بالدخول.
    * في حالة محاولة الحساب المحظور الدخول، يتم إعادة التوجيه مباشرة إلى الصفحة الرئيسية (index.php).
     */

     // التأكد من تسجيل الدخول ووجود نوع الحساب في الجلسة
     if (!isset($_SESSION['account_type'])) {
         // إذا لم يكن المستخدم مسجل دخولًا، يتم إعادة التوجيه للصفحة الرئيسية
             header("Location: index.php");
                 exit;
                 }

                 // استرجاع نوع الحساب من الجلسة
                 $accountType = $_SESSION['account_type'];

                 // التحقق مما إذا كان الحساب من نوع "normal" أو "viewer"
                 // وفي هذه الحالة يتم منعه (إعادة التوجيه للصفحة الرئيسية)
                 if ($accountType === 'normal' || $accountType === 'viewer') {
                     header("Location: index.php");
                         exit;
                         }

                         // إذا لم يكن نوع الحساب "normal" أو "viewer"، سيستمر عرض الصفحة المحمية
                         ?>