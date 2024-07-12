<?php include('partials/menu.php');?>


<?php
    //Check whether id is set or not
    if(isset($_GET['id']))
    {
        //Get all the detials
        $id = $_GET['id'];

        //SQL QUery to Get the Selected Food
        $sql2 = "SELECT * FROM tbl_food WHERE id=$id";
        //Execute the Query
        $res2 = mysqli_query($conn, $sql2);

        //Get the value based on query executed
        $row2 = mysqli_fetch_assoc($res2);

        //get the Individual Value of Selected Food
        $title = $row2['title'];
        $description = $row2['description'];
        $price = $row2['price'];
        $current_image = $row2['image_name'];
        $current_category = $row2['category_id'];
        $featured = $row2['featured'];
        $active = $row2['active'];

    }
    else
    {
        //Redirect to Manage Food
        header('location:'. SITEURL.'admin/manage-food.php');
    }
?>


<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">

            <tr>
                <td>Nama Makanan : </td>
                <td>
                    <input type="text" name="title" value="<?php echo $title; ?>">
                </td>
            </tr>

            <tr>
                <td>Deskripsi : </td>
                <td>
                    <textarea name="description" id="" cols="30" rows="5"><?php echo $description; ?></textarea>
                </td>
            </tr>

            <tr>
                <td>Harga : </td>
                <td>
                    <input type="number" name="price" value="<?php echo $price; ?>">
                </td>
            </tr>

            <tr>
                <td>Gambar Sebelum nya : </td>
                <td>
                    <?php
                        if($current_image == "")
                        {
                            //Image not Available
                            echo "<div class='error'>Gambar Tidak Tersedia.</div>";
                        }
                        else
                        {
                            //Image Available
                            ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                    ?>
                </td>
            </tr>

            <tr>
                <td>Tambahkan Gambar Baru : </td>
                <td>
                    <input type="file" name="image">
                </td>
            </tr>

            <tr>
                <td>Kategori : </td>
                <td>
                    <select name="category">

                        <?php   
                            //Query to Get Active Categories
                            $sql = "SELECT * FROM tbl_category WHERE active='Ya'";
                            //Execute the Query
                            $res = mysqli_query($conn, $sql);
                            //Count Rows
                            $count = mysqli_num_rows($res);

                            //Check whether category available or not
                            if($count>0)
                            {
                                //category Available
                                while($row=mysqli_fetch_assoc($res))
                                {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];

                                    //echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                                    <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                                    <?php
                                }
                            }
                            else
                            {
                                //Category Not Available
                                echo "<option value='0'>Kategori Tidak Ada.</option>";
                            }

                        ?>

                    </select>
                </td>
            </tr>

            <tr>
                <td>Produk Favorite : </td>
                <td>
                    <input <?php if($featured=="Ya") {echo "checked";} ?> type="radio" name="featured" value="Ya"> Ya
                    <input <?php if($featured=="Tidak") {echo "checked";} ?> type="radio" name="featured" value="Tidak"> Tidak
                </td>
            </tr>

            <tr>
                <td>Aktif : </td>
                <td>
                    <input <?php if($active=="Ya") {echo "checked";} ?> type="radio" name="active" value="Ya"> Ya
                    <input <?php if($active=="Tidak") {echo "checked";} ?> type="radio" name="active" value="Tidak"> Tidak
                </td>
            </tr>

            <tr>
                <td>
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="current_image" value ="<?php echo $current_image; ?>">
                    <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                </td>
            </tr>

        </table>

        </form>

        <?php

            if(isset($_POST['submit']))
            {
                //echo "Button Clicked";

                //1. Get all the details from the Form
                $id = $_POST['id'];
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $current_image = $_POST['current_image'];
                $category = $_POST['category'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                //2. Upload the image if selected

                //Check whether upload button is clicked or not
                if(isset($_FILES['image']['name']))
                {
                    //Upload Button Clicked
                    $image_name = $_FILES['image']['name']; //New Image Name

                    //Check whether the file is available or not
                    if($image_name!="")
                    {
                        //Image is Available
                        //A. Uploading New Image

                        //Rename the Image
                        $ext = end(explode('.', $image_name)); //Gets the extension of the image

                        $image_name = "Food-Name-".rand(0000, 9999).'.'.$ext; //This will be renamed image

                        //Get the Source Path and Destination Path
                        $src_path = $_FILES['image']['tmp_name']; //Source Path
                        $dest_path = "../images/food/".$image_name; //Destination Path

                        //Upload the image
                        $upload = move_uploaded_file($src_path, $dest_path);

                        //Check whether the image is uploaded or not
                        if($upload==false)
                        {
                            //Failed to Upload
                            $_SESSION['upload'] = "<div class='error'>Gagal Manambahkan Gambar Baru.</div>";
                            //Redirect to Manage Food
                            header('location:'.SITEURL.'admin/manage-food.php');
                            //Stop the Process
                            die();
                        }
                        //3. Remove the image if new image is uploaded and current image exists
                        //B. Remove Current Image if Available
                        if($current_image!="")
                        {
                            //Current Image is Available
                            //Remove the image
                            $remove_path = "../images/food/".$current_image;

                            $remove = unlink($remove_path);

                            //Check whether the image removed or not
                            if($remove==false)
                            {
                                //Failed to Remove current image
                                $_SESSION['remove-failed'] = "<div class='error'>Gagal Menghapus Gambar Sebelumnya.</div>";
                                //Redirect to Manage Food
                                header('location:'.SITEURL.'admin/manage-food.php');
                                //Stop the process
                                die();
                            }

                        }
                    }
                    else
                    {
                        $image_name = $current_image; //Default Image when Image is Not Selected
                    }
                }
                else
                {
                    $image_name = $current_image; //Default Image when Button is not Clicked
                }

                //4. Update the Food in Database
                $sql3 = "UPDATE tbl_food SET 
                    title = '$title',
                    description = '$description',
                    price = '$price',
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active' 
                    WHERE id=$id
                ";

                //Redirect to Manage Food with Session Message
                $res3 = mysqli_query($conn, $sql3);

                //Check whether the query is executed or not
                if($res3==true)
                {
                    //Query Executed and Food Updated
                    $_SESSION['update'] = "<div class='success'>Produk Berhasil Di Perbarui.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
                else
                {
                    //Failed to Update Food
                    $_SESSION['update'] = "<div class='error'>Gagal Perbarui Produk.</div>";
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            }

        ?>

    </div>
</div>

<?php include('partials/footer.php');?>