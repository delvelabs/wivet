<?php
    // starting output buffering in order to avoid; Headers sent before ... warning
    ob_start();
    define('NOSTARTHTML', true);
    require_once('../genclude.php');

    if(!isset($_SESSION['page_24_has_been_visited'])){
        $_SESSION['page_24_has_been_visited'] = true;
        header('HTTP/1.1 503 Service Unavailable');
        html_header();
        echo '<center><h1>503 Service Unavailable</h1>Try again later...<br/><br/><a href="../innerpages/'. tc('24_3f4d8',false).'.php">Click me</a></center>';
        exit(0);
    }else{
        html_header();
        echo '<center><a href="../innerpages/'. tc('24_1c3f8',false).'.php">Click me</a></center>';
    }

    ob_end_flush();
?>
