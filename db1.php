<?php 
    header("Access-Control-Allow-Origin: *");
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $con = mysqli_connect("localhost", "root", "java@123", "testimonial");
    $store = $_GET['shop'];
    $store = str_replace("https://", "",$store);
    $query = "SELECT * FROM user where store_name='$store'";
    $result = mysqli_query($con, $query);
    $r = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $r[] = $row;
        }
        print_r(json_encode($r));
    }
?>