<?php
header('Access-Control-Allow-Origin: *');

header("Access-Control-Request-Method: GET, POST");
header('Access-Control-Allow-Headers: accept, origin, content-type');

    session_start();
    $store = isset($_GET['shop']) ? $_GET['shop'] : null;

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $con = mysqli_connect("localhost", "root", "java@123", "excellence_fee");


if (isset($_POST['action']) && isset($_POST['store'])) {
    $store_name = $_POST['store'];

    $query = "SELECT * FROM excellence_fee where store_name = '$store_name'";
    $result = mysqli_query($con, $query);
    $r = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $r[] = $row;
        }
        print_r(json_encode($r));
    }
    exit;
}




    if (isset($_POST["submit"])) {

        $product_varient = $_POST['product'];
        $gift_varient = $_POST['gift'];


        $check = "SELECT * FROM fee where store_name = '$store' ";
        $rs = mysqli_query($con, $check);
        $data = mysqli_fetch_array($rs, MYSQLI_NUM);
        if ($data[0] > 1) {
        $query = "UPDATE INTO `fee`(`amount`) VALUES ('$product_varient') where store_name = '$store' ";
        $result = mysqli_query($con, $query);
        $_SESSION['SUCCESS'] = "1";
        header("location: dashboard.php?shop=" . $store);
        } else {
        $query = "INSERT INTO `fee`(`product_varient`,`store_name`) VALUES ('$product_varient','$store')";
        $result = mysqli_query($con, $query);
        $_SESSION['SUCCESS'] = "2";   
        header("location: dashboard.php?shop=".$store);
        }
  
            
            // echo "<script type='text/javascript'>alert('SUCCESSFULLY');</script>";
            
      
    }

    $store1 = $_POST['store'];
    $query = "SELECT * FROM fee where store_name = '$store1'";
   
        $result = mysqli_query($con, $query);
    $r = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $r[] = $row;
    }
        print_r(json_encode($r));
    }

    // if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'del' ){
    // $store2 = $_POST['store'];
    //     $query = "DELETE FROM giftcard WHERE id=".$_POST['val']." and store_name = '$store2'";
    //     $result = mysqli_query($con, $query);   
    // }

?>