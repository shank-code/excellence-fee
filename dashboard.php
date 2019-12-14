<?php 
include_once('API.php');
    // header ("Content-type: application/javascript");
header('Access-Control-Allow-Origin: *');
header("Access-Control-Request-Method: GET, POST");
header('Access-Control-Allow-Headers: accept, origin, content-type');
    session_start();
    $shop = isset($_GET['shop']) ? $_GET['shop'] : null;
    $_SESSION['store'] = $shop;
    $_COOKIE['store'] = $shop;
?>
<?php
$auth = [
    'username' => '3cf019a0d480cd6c9962105d13f0774b',
    'password' => '1a3c5f17f4d5787a8df38167b1c3f94e'
];


$username = "3cf019a0d480cd6c9962105d13f0774b";
$password = "1a3c5f17f4d5787a8df38167b1c3f94e";

//add js file in shopify store
$api = new API();
$GetscriptURL = "https://" . $_SESSION['store'] . "/admin/api/2019-10/script_tags.json";
$Getscript = $api->Getscript($GetscriptURL, $auth);

//Get all products Api
$GetallProductURL = "https://" . $_SESSION['store'] . "/admin/api/2019-04/products.json";
$varientIds = $api->GetallProducts($GetallProductURL,$auth);

//Get collection Api
$GetcollectionURL = "https://" . $_SESSION['store'] . "/admin/api/2019-04/smart_collections.json";
$collection_id = $api->Getcollection($GetcollectionURL,$auth);

//Get collection id
$GetcollectionbyIDURL = "https://" . $_SESSION['store'] . "/admin/api/2019-04/products.json?collection_id=" . $collection_id;
$gift_varientIds=  $api->GetcollectionbyID($GetcollectionbyIDURL,$auth);



?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>GIFTCARD</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <!-- Our Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
    
</head>

<body>

    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Giftcard</h3>
                <strong>GC</strong>
            </div>
            <ul class="list-unstyled components">
                <li>
                    <a href="#" class="upload">
                        <i></i>
                        Upload Gift
                    </a>
                </li>
                <li>
                    <a href="#" class='show'>
                        <i></i>
                        Show Giftcard
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>
                </div>
            </nav>
            <?php if ($_SESSION['SUCCESS'] == "1") 
           echo "<div class='successfully'><h2 style='color:GREEN'>product Already have giftcard</h2></div>";
            ?>
            <?php if ($_SESSION['SUCCESS'] == "2")
                echo "<div class='successfully'><h2 style='color:red'>Successfully </h2></div>";
            ?>
            <div class='upload1' >
                <form action="db.php?shop=<?= $shop ?>" method="post" enctype="multipart/form-data"> 
                <div class="form-content">
                    <div class="row">
                            <div class="form-group col-sm-6  col-xs-12 ">
                                <label>Products SKU</label>
                                <select  name='product' class='chosen' require>         
                                    <?php  
                                        foreach ($varientIds as $key => $value) {    
                                            echo "<option value ='".$key.'_'.$value."'>".$value."</option>";    
                                        }
                                    ?>   
                                </select>  
                            </div>              
                            <div class="form-group col-sm-6 col-xs-12">
                                 <label>GiftProduct SKU</label>
                                 <select class="chosen1" name='gift' require>      
                                         <?php 
                                        foreach ($gift_varientIds as $key => $value) {
                                            echo "<option value ='" . $key .'_'.$value. "'>" . $value . "</option>";
                                        }
                                        ?>
                                </select>
                            </div>
                             <!-- <div class="form-group">
                                 <label>status</label>
                                <input type="checkbox" name="check" class="form-control" />
                            </div> -->
                    </div>
                    <div class='row'> 
                        <button type="submit"  name= "submit" class="btnSubmit">Submit</button>
                    </div>
                </div>
                </form>
            </div>     
            <div class='show1' >
             <div class="container">
        <div class="row">  
            <div class="col-sm-12">        
                <table class="table table-striped table-bordered text-center">
                    <thead>
                        
                        <th>All product SKU</th>
                        <th>GiftCard SKU</th>
                        <th>Action</th>
                    </thead>
                    <tbody id="response"></tbody>       
                </table>
            </div>
        </div>
    </div>  
            </div>
        </div>
    </div>

    <!-- jQuery CDN - Slim version (=without AJAX) -->
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script> -->
    <script type="text/javascript">


    var store = "<?php echo $_SESSION['store']; ?>";
    $(document).ready(function () {
        
        $('.show1').hide();

        $('#sidebarCollapse').on('click', function () {
            $('#sidebar').toggleClass('active');
        });
        $('.show').click(function(){
            $('.upload1').hide();
            $('.show1').show();
            $('.successfully').css('display', 'none');
            var text ="";
            
            
            $.ajax({
                url : "db.php",
                type: "post",
                data:{store:store},
                datatype: "json",
                success:function(responsedata){   
                    text= ''; var data = '';
                    if(responsedata) {
                        data = $.parseJSON(responsedata);
                    }
                    if(data) {
                        $.each(data, function (i,data1) {  
                            text +=  "<tr style='background-color: rgba(255, 255, 255, 0.05)'>"+
                                    "<td>"+data1.product_varient.split('_')[1]+"</td>"+        
                                    "<td>"+data1.gift_varient.split('_')[1]+"</td>"+
                                    "<td><button class='btn btn-danger delete' data-atr="+data1.id+">Delete</button></td>"+
                                    "</tr>";
                        });
                    }
                    
                    $("#response").html(text);
                }
            });
        });

        $('.upload').click(function(){
            $('.result').hide();
            $('.show1').hide();
            $('.upload1').show();
        });

           $(document).on('click', '.delete', function () {
            $.ajax({
                type:'POST',
                data:{val:$(this).attr('data-atr'),type:'del',store:store},
                url:'db.php',
                success: function(data){
                   $('.show').click(); 
                }

            });

        });
    });
    $(document).ready(function(){
        $('.chosen').chosen();
        $('.chosen1').chosen();
});
</script>
</body>
</html>
<?php 
session_destroy();
?>



