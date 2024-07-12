<?php include('../config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
</head>

    <body>
        
        <div class="login">
            <h1 class="text-center login-header">Login</h1>
            <br><br>

            <?php 
                if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }

                if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
            ?>
            <br><br>

            <!-- Login Form Starts Here -->
            <form action="" method="POST" class="text-center">
            Username : <br>
            <input type="text" name="username" placeholder="Masukkan Username"><br><br>

            Password : <br>
            <input type="password" name="password" placeholder="Masukkan Password"><br><br>

            <input type="submit" name="submit" value="login" class="btn-primary">
            <br><br>
            </form>
            <!-- Login Form Starts Here -->
            
            <p class="text-center">Created By - Ananda Andra</p>
        </div>

    </body>
</html>

<?php

    //Check whether the Submit Button is Clicked or Not
    if(isset($_POST['submit']))
    {
        //Process for login
        //1. Get the Data from Login Form
        // $username = $_POST['username']);
        // $password = md5($_POST['password']);

        $username = mysqli_real_escape_string($conn, $_POST['username']);

        $raw_password = md5($_POST['password']);
        $password = mysqli_real_escape_string($conn, $raw_password);

        //2. SQL to Check whether the user with username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

        //3. Execute the Query
        $res = mysqli_query($conn, $sql);

        //4. Count rows to check whether the user exists or not
        $count = mysqli_num_rows($res);

        if($count==1)
        {
            //User Available and Login Success
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username; //TO check whether the user is loggeed in or not and logout will unset it

            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/');
        }
        else
        {
            //User not Available and Login Failed
            $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
            //Redirect to Home Page/Dashboard
            header('location:'.SITEURL.'admin/login.php');
        }


    }

?>