<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Tambahkan Kategori</h1>

        <br><br>

        <?php

            if(isset($_SESSION['add']))
            {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }

        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Nama Kategori Makanan : </td>
                    <td>    
                        <input type="text" name="title" placeholder="Judul Kategori">
                    </td>
                </tr>

                <tr>
                    <td>Gambar :</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Kategori Favorite : </td>
                    <td>
                        <input type="radio" name="featured" value="Ya"> Ya
                        <input type="radio" name="featured" value="Tidak"> Tidak
                    </td>
                </tr>

                <tr>
                    <td>Aktif : </td>
                    <td>
                        <input type="radio" name="active" value="Ya"> Ya
                        <input type="radio" name="active" value="Tidak"> Tidak
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
        <!-- Add Category Form Ends-->

        <?php

            //Check whether the Submit Button is Clicked or Not
            if(isset($_POST['submit']))
            {
                //echo "Clicked";

                //1. Get the Value from Category Form
                $title = $_POST['title'];

                //For Radio Input, we need to check whether the button is selected or not
                if(isset($_POST['featured']))
                {
                    //Get the Value from form
                    $featured = $_POST['featured'];
                }
                else
                {
                    //Set the default Value
                    $featured = "No";
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No";
                }

                //Check whether the image is selected or not and set the value for image name accoridingly
                //print_r($_FILES['image']);

                //die(); //Break the code here

                if(isset($_FILES['image']['name']))
                {
                    //Upload the Image
                    //To upload image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    //Upload the image only if image is selected
                    if($image_name != "")
                    {

                        //Auto Rename or Image
                        //Get the Extension of our image (jpg, png, gif, etc) e.g. "Special.food1.jpg"
                        $ext = end(explode('.', $image_name));

                        //Rename the Image
                        $image_name = "Food_Category_".rand(000, 999).'.'.$ext; // e.g. Food_Category_324.jpg


                        $source_path = $_FILES['image']['tmp_name'];

                        $destination_path = "../images/category/".$image_name;

                        //Finally Upload the Image
                        $upload = move_uploaded_file($source_path, $destination_path);

                        //Check whether the image is uploaded or not
                        //And if the image is not uploaded the we will stop the process and redirect with error message
                        if($upload==false)
                        {
                            //Set message
                            $_SESSION['upload'] = "<div class='error'>Failed to upload Image. </div>";
                            //Redirect to Add Category Page
                            header('location:'.SITEURL.'admin/add-category.php');
                            //Stop the Process
                            die();
                        }

                    }
                }
                else
                {
                    //Don't Upload image and set the image_nam value as blank
                    $image_name="";
                }

                //2. Create SQL Query to Insert Category into Database
                $sql = "INSERT INTO tbl_category SET
                    title='$title',
                    image_name='$image_name',
                    featured='$featured',
                    active='$active'
                ";

                //3. Execute the Query and Save in Database
                $res = mysqli_query($conn, $sql);

                //4. Check whether the query executed or not and data added or not
                if($res==true)
                {
                    //Query Executed and Category Added
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    //Redirect to manage Category Page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else
                {
                    //Failed to Add Category
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    //Redirect to manage Category Page
                    header('location:'.SITEURL.'admin/add-category.php');
                }
            }


        ?>

    </div>
</div>

<?php include('partials/footer.php'); ?>