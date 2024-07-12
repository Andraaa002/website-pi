<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Tambahkan Admin</h1>
        
        <br><br>

        <?php
            if(isset($_SESSION['add'])) //Checking whether the session is Set or Not
            {
                echo $_SESSION['add']; //Display the session message if set
                unset($_SESSION['add']); //Remove Session Message
            }
        ?>

        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Nama Lengkap :</td>
                    <td>
                        <input type="text" name="full_name" placeholder="Masukkan Nama">
                    </td>
                </tr>

                <tr>
                    <td>Username :</td>
                    <td>
                        <input type="text" name="username" placeholder="Masukkan Username">
                    </td>
                </tr>

                <tr>
                    <td>Password :</td>
                    <td>
                        <input type="password" name="password" placeholder="Masukkan Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>


    </div>
</div>

<?php include('partials/footer.php'); ?>


<?php 
    //Process the Value from Form and Save it in Database

    //Check whether the submit button is clicked or not

    if(isset($_POST['submit']))
    {
        // Button Not Clicked
        //echo "Button Not Clicked";

        //1. Get the Data from Form
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $password = md5($_POST['password']); //Password Encryption with MD5

        //2. SQL Query to Save the data into database
        $sql = "INSERT INTO tbl_admin SET
            full_name='$full_name',
            username='$username',
            password='$password'
        ";

        //3. Executing Query and Saving Data into Database
        $res = mysqli_query($conn, $sql) or die(mysqli_error()); 

        //4. Check whether the (Query is Executed) data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //data inserted
            //echo "Inserted";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "Sukses Menambahkan Admin";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }
        else
        {
            //failed to insert data
            //echo "Failed to insert data";
            //Create a Session Variable to Display Message
            $_SESSION['add'] = "Gagal Menambahka Admin";
            //Redirect Page to Manage Admin
            header("location:".SITEURL.'admin/manage-admin.php');
        }

    }

?>