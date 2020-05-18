<!DOCTYPE html>
<?php
session_start();

include("functions/functions.php");
?>
<html>
	<head>
		<title>My Online Shop</title>
		<link rel="stylesheet" href="styles/style.css">
	</head>
	<body>
		<div class="main_wrapper">
            <div class="header_wrapper">
                <img id="logo" src="images/logo.gif" alt="logo" height="100px" width="300px">
                <img id="banner" src="images/adbanner.gif" alt="Google Ad Banner" height="100px" width="700px">
            </div>
            <div class="menubar">
                  <ul id="menu">
                  <li><a href="index.php">Home</a></li>
                      <li><a href="all_products.php">All products</a></li>
                      <li><a href="my_account.php">My account</a></li>
                      <li><a href="customer_register.php">Sign Up</a></li>
                      <li><a href="cart.php">Shopping Cart</a></li>
                  </ul>  

                  <div id="form">
                      <form method="get" action="results.php" enctype="multipart/form-data">
                        <input type="text" name="user_query" placeholder="Search your product here">
                        <input type="submit" name="search" value="Search">
                      </form>

                  </div>
            </div>
            <div class="content_wrapper">
            <div id="sidebar">

                <div id="sidebar_title">Categories</div>
                <ul id="cats">
                    <?php getCats(); ?>
                </ul>

                <div id="sidebar_title">Brands</div>
                <ul id="cats">
                    <?php getBrands(); ?>
                </ul>
            </div>
            <div id="content_area">

                <?php cart(); ?>

                <div id="shopping_cart">
                    <span style="float:right; font-size=15px;padding=5px;line-height:40px">
                    
                    <?php
                        if(isset($_SESSION['customer_email'])){
                            echo "<b>Welcome:</b>" . $_SESSION['customer_email'] . "<b style='color:yellow;'>Your </b>";
                        }
                        else{
                            echo "<b>Welcome Guest:</b>";
                        }

                    ?>
                    <b style="color:yellow;">Shopping Cart</b> Total Items:<?php total_items(); ?> Total Price:<?php total_price(); ?> <a href="index.php" style="color:yellow;">Back to Shop</a>
                    <?php
                        if(!isset($_SESSION['customer_email'])){
                            echo "<a href='checkout.php' style='color:orange;text-decoration:none;'>Login</a>";
                        }
                        else{
                            echo "<a href='logout.php' style='color:orange;text-decoration:none;'>Logout</a>";
                        }
                    ?>
                </span>
                </div>

                <div id="products_box">
                    <form action="" method="post" enctype="multipart/form-data">
                        <table align="center" width="700" bgcolor="skyblue">
                            <tr align="center">
                                <th>Remove</th>
                                <th>Product(S)</th>
                                <th>Total Price</th>
                            </tr>

                            <?php
                                $total = 0;

                                global $con;
                            
                                $ip = getIp();
                            
                                $sel_price = "select * from cart where ip_add='$ip'";
                            
                                $run_price = mysqli_query($con, $sel_price);
                            
                                while($p_price=mysqli_fetch_array($run_price)){
                                    $pro_id = $p_price['p_id'];
                            
                                    $pro_price = "select * from products where product_id='$pro_id'";
                            
                                    $run_pro_price = mysqli_query($con, $pro_price);
                            
                                    while($pp_price = mysqli_fetch_array($run_pro_price)){
                                        $product_price = array($pp_price['product_price']);
                                        $product_title = $pp_price['product_title'];
                                        $product_image = $pp_price['product_image'];
                                        $single_price = $pp_price['product_price'];
                            
                                        $values = array_sum($product_price);
                            
                                        $total +=$values;
                            ?>

                            <tr align="center">
                                <td><input type="checkbox" name="remove[]" value="<?php echo $pro_id;?>"></td>
                                <td><?php echo $product_title; ?><br>
                                <img src="admin_area/product_images/<?php echo $product_image;?>" width=60 height=60>
                                </td>
                                
                                
                                <td><?php echo $single_price . "₹" ?></td>
                            </tr>
                            <?php } } ?> 
                            <tr align="right">
                                <td colspan="4"><b>Sub Total:</b></td>
                                <td><?php echo $total . "₹" ?></td>
                            </tr>

                            <tr align="center">
                                <td colspan="2"><input type="submit" name="update_cart" value="Update Cart"></td>
                                <td><input type="submit" name="continue" value="Continue Shopping"></td>
                                <td><button><a href="checkout.php" style="text-decoration=none;color:black;">Checkout</a></button></td>
                            </tr>

                        </table>
                    </form>

                    <?php
                    
                        global $con;

                        $ip = getIp();

                        if(isset($_POST['update_cart'])){

                            foreach($_POST['remove'] as $remove_id){

                                $delete_product = "delete from cart where p_id='$remove_id' AND ip_add='$ip'";

                                $run_delete = mysqli_query($con, $delete_product);

                                if($run_delete){
                                    echo "<script>window.open('cart.php','_self')</script>";
                                }
                            }
                        }
                        if(isset($_POST['continue'])){
                            echo "<script>window.open('index.php','_self')</script>";
                        }
                        
                    ?>
                </div>
            </div>
            </div>
    
            <div id="footer">
                <h2 style="text-align:center;padding-top:30px;">&copy; 2020 by Kiran Pai Cod</h2>
            </div>
        </div>
        
        
	</body>
</html>