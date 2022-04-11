<?php
session_start();
if ($_SESSION['loginadmin']) {
    session_destroy();
    header('location:../index.php');
}
