// slider code
    <html>
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>


</head>
<body>



  <div class='bxslider'></div>-->


 <script> 
  $(document).ready(function(){
  
   
  var text="";
  $.ajax({
      url : "https://plivo1.demo.xmagestore.com/shopify_shoes_app/db1.php?shop={{shop.url}}",
      type: "post",
      datatype: "json",
      success:function(responsedata){
        var data = $.parseJSON(responsedata);
       
        $.each(data, function (i,data1) {
          console.log(data1);
              text +=
                    
                    "<div><img src='https://plivo1.demo.xmagestore.com/shopify_shoes_app/uploads/"+data1.image+"' /><p style='position: absolute;top: 60%;left: 20%;font-weight: bold; text-align:center; right:20%;color: white;font-size: xx-large;'>"+data1.name+"</p></div>"
                    ;
          });
         
        $(".bxslider").append(text);
        var j = jQuery.noConflict();
         $(".bxslider").bxSlider({ auto: true });
  
  }
});


});

 
  </script>
</body>
</html>
</code>