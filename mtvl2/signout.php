<?php
include_once('inc/functions.php');
session_start();
unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['type']);
unset($_SESSION['phone']);
unset($_SESSION['status']);
unset($_SESSION['user']);

Redirect('index.php');
?>