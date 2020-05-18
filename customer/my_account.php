<!DOCTYPE html>
<?php
session_start();
include("../functions/functions.php");
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

                <div id="sidebar_title">My account:</div>
                <ul id="cats">
                    <?php
                        global $con;

                        $user = $_SESSION['customer_email'];

                        $get_img = "select * from customers where customer_email='$user'";

                        $run_img = mysqli_query($con, $get_img);

                        $row_img = mysqli_fetch_array($run_img);

                        $c_image = $row_img['customer_photo'];

                        $c_name = $row_img['customer_name'];

                        echo "<p style='text-align:center;'><img src='customer_images/$c_image' width='150' height='150'></p>";

                    ?>
                    <li><a href="my_account.php?my_orders">My Orders</a></li>
                    <li><a href="my_account.php?edit_account">Edit Account</a></li>
                </ul>

            </div>
            <div id="content_area">

                <?php cart(); ?>

                <div id="shopping_cart">
                    <span style="float:right; font-size=17px;padding=5px;line-height:40px">
                    <?php
                        if(isset($_SESSION['customer_email'])){
                            echo "<b>Welcome:</b>" . $_SESSION['customer_email'];
                        }
                    ?>

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
                    

                    <?php 
                    if(!isset($_GET['my_orders'])){
                        if(!isset($_GET['edit_account'])){
                            if(!isset($_GET['change_pass'])){
                                if(!isset($_GET['delete_account'])){
                                    
                        echo "<h2 style='padding:20px;'>Welcome: $c_name </h2><b>You can see your orders' progress by clicking this <a href='my_account.php?my_orders'>link</a></b>
                        <p style='color:red;'><i>Note: Since it is test website and payment is frozen orders can't be seen</i></p>
                        <p style='color:red;'><i>Please check other links like edit, change password and delete</i></p>";
                    }
                }
            }
        }    
                    ?>

                    <?php
                        if(isset($_GET['edit_account'])){
                            include("edit_account.php");
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