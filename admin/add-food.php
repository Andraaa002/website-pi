<?php include ('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Tambahkan Makanan</h1>

        <br><br>

        <?php 
            if(isset($_SESSION['upload']))
            {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Nama Makanan : </td>
                    <td>
                        <input type="text" name="title" placeholder="Nama Makanan">
                    </td>
                </tr>

                <tr>
                    <td>Deskripsi : </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Masukkan deskripsi Makanan"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Harga : </td>
                    <td>
                        <input type="number" name="price" placeholder="Input Harga">
                    </td>
                </tr>
                
                <tr>
                    <td>Gambar : </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Kategori : </td>
                    <td>
                        <select name="category">

                            <?php 
                                //Create PHP Code to display categories from Database
                                //1. Create SQL to get all active categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Ya'";

                                //Executing Query
                                $res = mysqli_query($conn, $sql);

                                //Count Rows to check whether we have categories or not
                                $count = mysqli_num_rows($res);

                                //If count is greater than zero, we have categories else we donot have categories
                                if($count>0)
                                {
                                    //We have Categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories
                                        $id = $row['id'];
                                        $title = $row['title'];

                                        ?>

                                        <option value="<?php echo $id; ?>"><?php echo $title;?></option>

                                        <?php
                                    }
                                }
                                else
                                {
                                    //We do not have category
                                    ?>
                                    <option value="1">No Category Found</option>
                                    <?php
                                }


                                //2. Display on Dropdown
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Produk Favorite : </td>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>


        <?php

            //Check whether the button is cliecked or not
            if(isset($_POST['submit']))
            {
                //Add the food in Database
                //echo "Clicked";

                //1. Get the Data from Form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category = $_POST['category'];

                //Check whether radio button for featured and active are checked or not
                if(isset($_POST['featured']))
                {
                    $featured = $_POST['featured'];
                }
                else
                {
                    $featured = "No"; //Setting the Default Value
                }

                if(isset($_POST['active']))
                {
                    $active = $_POST['active'];
                }
                else
                {
                    $active = "No"; //Setting Default Value
                }

                //2. Upload the image if selected
                //Check whether the select image is clicked or not adn upload the image only if the image is selected
                if(isset($_FILES['image']['name']))
                {
                    //Get the details of the selected image
                    $image_name = $_FILES['image']['name'];
                    
                    //Check Whether the image is Selected or not and upload image only if selected
                    if($image_name!="")
                    {
                        //Image is Selected
                        //A. Rename the Image
                        //Get the extension of selected image (jpg, png, gif, etc.) "ananda.andra.jpg"
                        $ext = end(explode('.', $image_name));

                        //Create New Name for Image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext; //New Image Name May Be "Food-Name-657.jpg"

                        //B. Upload the image
                        //Get the Src Path and Destiation path

                        //Source path is the current location of the image
                        $src = $_FILES['image']['tmp_name'];

                        //Destination Path for the image to be uploaded
                        $dst = "../images/food/".$image_name;

                        //Finally Upload the food image
                        $upload = move_uploaded_file($src, $dst);

                        //Check whether image uploaded of not
                        if($upload==false)
                        {
                            //Failed to upload the image
                            //Redirect to Add Food Page with Error Message
                            $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                            header('location:'.SITEURL.'admin/add-food.php');
                            //Stop the process
                            die();
                        }

                    }

                }
                else
                {
                    $image_name = ""; //Setting Default Value as blank
                }

                //3. Insert Into Database

                //Create a SQL Query to Save or Add food
                // For Numerical we do not need to pass value inside quotes '' But for string value it is compulsory to add quotes ''
                $sql2 = "INSERT INTO tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = $category,
                    featured = '$featured',
                    active = '$active'
                ";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);
                //Check whether data inserted or not

                if($res2 == true)
                {
                    //Data inserted Successfully
                    $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Failed to insert Data
                    $_SESSION['add'] = "<div class='error'>Failed to Add Food..</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }

                //4. Redirect with Message to Managa Food page
            }

        ?>


    </div>
</div>

<?php include ('partials/footer.php'); ?>