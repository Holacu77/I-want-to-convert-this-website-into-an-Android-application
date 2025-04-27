<?php
require 'csrf.php';


require 'config.php';

/**
 * تنشئ نسخة احتياطية كاملة من قاعدة البيانات وجميع ملفات الموقع،
  * تحفظها في ZIP ضمن $bk_dir، ثم تدير تدوير آخر 5 نسخ.
   */
   function createBackup($bk_dir) {
       $pdo = $GLOBALS['pdo'];

           // تعطيل فحوصات المفاتيح الأجنبية
               $sql = "SET FOREIGN_KEY_CHECKS=0;\n\n";

                   // تفريغ قاعدة البيانات إلى SQL
                       $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
                           foreach ($tables as $table) {
                                   $row  = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
                                           $sql .= "DROP TABLE IF EXISTS `$table`;\n" . $row['Create Table'] . ";\n\n";
                                                   $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
                                                           foreach ($rows as $r) {
                                                                       $cols = array_keys($r);
                                                                                   $vals = array_map(function($v) {
                                                                                                   return isset($v) ? "'" . addslashes($v) . "'" : "NULL";
                                                                                                               }, array_values($r));
                                                                                                                           $sql .= "INSERT INTO `$table` (`" . implode("`,`", $cols) . "`) VALUES (" . implode(",", $vals) . ");\n";
                                                                                                                                   }
                                                                                                                                           $sql .= "\n";
                                                                                                                                               }

                                                                                                                                                   // إعادة تفعيل فحوصات المفاتيح الأجنبية
                                                                                                                                                       $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

                                                                                                                                                           // إنشاء ZIP
                                                                                                                                                               $timestamp = date('Ymd_His');
                                                                                                                                                                   $filename  = "backup_{$timestamp}.zip";
                                                                                                                                                                       $zip       = new ZipArchive();
                                                                                                                                                                           $zip->open("$bk_dir/$filename", ZipArchive::CREATE);

                                                                                                                                                                               // إضافة SQL
                                                                                                                                                                                   $zip->addFromString("database_{$timestamp}.sql", $sql);

                                                                                                                                                                                       // إضافة ملفات الموقع مع تجاهل مجلد bk
                                                                                                                                                                                           $rootPath = realpath(__DIR__);
                                                                                                                                                                                               $iterator = new RecursiveIteratorIterator(
                                                                                                                                                                                                       new RecursiveDirectoryIterator($rootPath, RecursiveDirectoryIterator::SKIP_DOTS),
                                                                                                                                                                                                               RecursiveIteratorIterator::LEAVES_ONLY
                                                                                                                                                                                                                   );
                                                                                                                                                                                                                       foreach ($iterator as $file) {
                                                                                                                                                                                                                               $filePath     = $file->getRealPath();
                                                                                                                                                                                                                                       $relativePath = substr($filePath, strlen($rootPath) + 1);
                                                                                                                                                                                                                                               if (strpos($relativePath, 'bk' . DIRECTORY_SEPARATOR) === 0) {
                                                                                                                                                                                                                                                           continue;
                                                                                                                                                                                                                                                                   }
                                                                                                                                                                                                                                                                           $zip->addFile($filePath, $relativePath);
                                                                                                                                                                                                                                                                               }

                                                                                                                                                                                                                                                                                   $zip->close();

                                                                                                                                                                                                                                                                                       // حذف أقدم النسخ إذا تجاوزت 5
                                                                                                                                                                                                                                                                                           $backups = glob("$bk_dir/backup_*.zip");
                                                                                                                                                                                                                                                                                               usort($backups, fn($a, $b) => filemtime($a) - filemtime($b));
                                                                                                                                                                                                                                                                                                   while (count($backups) > 5) {
                                                                                                                                                                                                                                                                                                           @unlink(array_shift($backups));
                                                                                                                                                                                                                                                                                                               }
                                                                                                                                                                                                                                                                                                               }