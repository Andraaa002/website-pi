<?php 
    //include Constants Page
    include('../config/constants.php');

    //echo "Delete Food Page";

    if(isset($_GET['id']) AND isset($_GET['image_name'])) //Either use '&& or 'AND'
    {
        //Process to Delete
        //echo "Proses Menghapus";

        //1. Get ID and Image Name
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //2. Remove the Image if Available
        //Check whether the image is available or not and Delete only if available
        if($image_name != "")
        {
            // It has image and need to remove from folder
            //get the Image Path
            $path = "../images/food/".$image_name;

            //Remove Image File form Folder
            $remove = unlink($path);

            //Check whether the image is removed or not
            if($remove==false)
            {
                //Failed to Remove image
                $_SESSION['upload'] = "<div class='error'>Gagal menghapus file Gambar.</div>";
                //Redirect to Manage Food
                header('location:'.SITEURL.'admin/manage-food.php');
                //Stop the Process of deleting Food
                die();
            }

        }

        //3. Delete Food from Database
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed or not and set the session message respectively
        //4. Redirect to Manage Food with Session Message
        if($res==true)
        {
            //Food Deleted
            $_SESSION['delete'] = "<div class='success'>Produk Berhasil Dihapus.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
        else
        {
            //Failed to Delete Food
            $_SESSION['delete'] = "<div class='Error'>Produk Gagal Dihapus.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }


 
    }
    else
    {
        //Redirect to Manage Food Page
        //echo "Redirect";
        $_SESSION['unauthorize'] = "<div class='error'>Tidak ada Akses.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }

?>