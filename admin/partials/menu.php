<?php 

    include('../config/constants.php');
    include('login-check.php');

?>


<html>
    <head>
        <title>Andya BaKery Admin Panel</title>

        <link rel = "stylesheet" href = "../css/admin.css">
    </head>

    <body>
        <!-- Menu Section Starts -->
         <div class = "menu text-center">
            <div class = "wrapper">
                <ul>
                    <li><a href = "index.php">Beranda</a></li>
                    <li><a href = "manage-admin.php">Admin</a></li>
                    <li><a href = "manage-category.php">Kategori</a></li>
                    <li><a href = "manage-food.php">Makanan</a></li>
                    <li><a href = "manage-order.php">Pesanan</a></li>
                    <li><a href = "logout.php">Logout</a></li>
                </ul>
            </div>
         </div>
        <!-- Menu Section Ends -->