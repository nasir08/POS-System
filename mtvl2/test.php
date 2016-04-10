<?php
require_once('inc/functions.php');
set_time_limit(600);
system("mysqldump -h localhost -u root -p mtvl > bk.sql");

?>