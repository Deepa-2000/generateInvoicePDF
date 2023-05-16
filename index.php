<?php

include('db.php');

?>
<!DOCTYPE html>
<head>
    <title>Create Printable PDF invoice using PHP MySQL</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel='stylesheet' href='https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css'>
    <script src="https://code.jquery.com/ui/1.13.0-rc.3/jquery-ui.min.js" integrity="sha256-R6eRO29lbCyPGfninb/kjIXeRjMOqY3VWPVk6gMhREk=" crossorigin="anonymous"></script>
    
  </head>
  <body>
    <div class='container pt-5'>
    <h1 class='text-center text-primary'>Create Printable PDF invoice using MySQL</h1><hr>
        <?php

            if(isset($_POST["submit"])){

                $name=mysqli_real_escape_string($con,$_POST["name"]);
                $product=mysqli_real_escape_string($con,$_POST["product"]);
                $price=mysqli_real_escape_string($con,$_POST["price"]);
                $qty=mysqli_real_escape_string($con,$_POST["qty"]);
                $grand_total=mysqli_real_escape_string($con,$_POST["total"]);
                // echo $name,$product,$price,$grand_total;

                $sql="INSERT INTO `customers` (name,product,price,qty,total)VALUES ('$name','$product','$price','$qty','$grand_total')";
                // echo $sql;
                if ($con->query($sql)) {
                    $id=$con->insert_id;
                    // echo"<div class='alert alert-success'>Invoice Addeed Successfully</div>";
                    echo "<div class='alert alert-success'>Invoice Added Successfully. <a href='print.php?id={$id}' target='_BLANK'>Click </a> here to Print Invoice </div> ";
                }
                else{
                    echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
                }
            }
            // else{
                // echo "<div class='alert alert-danger'>Invoice Added Failed.</div>";
            // }
        ?>
      <form method='post' action='index.php' autocomplete='off'>
        <div class='row'>
          <div class='col-md-12'>
            <center><h2 class='text-success'>Customer Details</h2></center>
            <div class='form-group'>
              <label>Name of Buyer</label>
              <input type='text' name='name' required class='form-control'>
            </div>
            <table class='table table-bordered'>    
                <thead>
                    <tr>
                      <th>Product</th>
                      <th>Price</th>
                      <th>Qty</th>
                      <th>Total</th>
                    </tr>
                </thead>
                <tbody id='product_tbody'>
                    <tr>
                      <td><input type='text' required name='product' class='form-control'></td>
                      <td><input type='text' required name='price' class='form-control price'></td>
                      <td><input type='text' required name='qty' class='form-control qty'></td>
                      <td><input type='text' required name='total' class='form-control total'></td>
                    </tr>
                </tbody>
            </table>
            <input type='submit' name='submit' value='Save Invoice' class='btn btn-success float-right'>
            </div>
          </div>
        </div>
      </form>
    </div>
    <script>
        $(document).ready(function(){         

            $("body").on("keyup",".price",function(){
              var price=Number($(this).val());
              var qty=Number($(this).closest("tr").find(".qty").val());
              $(this).closest("tr").find(".total").val(price*qty);
            //   grand_total();
            });

            $("body").on("keyup",".qty",function(){
              var qty=Number($(this).val());
              var price=Number($(this).closest("tr").find(".price").val());
              $(this).closest("tr").find(".total").val(price*qty);
            //   grand_total();

            })

            // function grand_total(){
            //   var tot=0;
            //   $(".total").each(function(){
                // tot+=Number($(this).val());
            //   });
            //   $("#grand_total").val(tot);
            // }
        });
    </script>
  </body>
</DOC!html>