<?php include('partials/menu.php');?>

<div class = "main-content">
    <div class = "wrapper">
        <h1>Pengelolaan Makanan</h1>

        <br /><br /><br /><br />

                <!-- Button to Add Admin -->
                <a href = "<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>

                <br /><br /><br />

                <?php
                    if(isset($_SESSION['add']))
                    {
                        echo $_SESSION['add'];
                        unset($_SESSION['add']);
                    }

                    if(isset($_SESSION['delete']))
                    {
                        echo $_SESSION['delete'];
                        unset($_SESSION['delete']);
                    }

                    if(isset($_SESSION['upload']))
                    {
                        echo $_SESSION['upload'];
                        unset($_SESSION['upload']);
                    }

                    if(isset($_SESSION['unauthorize']))
                    {
                        echo $_SESSION['unauthorize'];
                        unset($_SESSION['unauthorize']);
                    }

                    if(isset($_SESSION['update']))
                    {
                        echo $_SESSION['update'];
                        unset($_SESSION['update']);
                    }
                    
                    
                ?>

                <table class="tbl-full">
                    <tr>
                        <th>No.</th>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Produk Favorite</th>
                        <th>Akitf</th>
                        <th>Tindakan</th>
                    </tr>

                    <?php 
                        //Create a SQL Query to Get all the Food
                        $sql = "SELECT * FROM tbl_food";

                        //Execute the Query
                        $res = mysqli_query($conn, $sql);

                        //Count Rows to check whether we have foods or not
                        $counts = mysqli_num_rows($res);

                        //Create Serial Number Variable and Set Default Value as 1
                        $sn=1;

                        // Fungsi untuk memformat harga ke dalam bentuk Rupiah
                        function formatRupiah($angka) {
                            return 'Rp.' . number_format($angka, 2, ',', '.');
                        }

                        if($counts>0)
                        {
                            //We have food in Database
                            //Get the Foods from Database and Display
                            while($row=mysqli_fetch_assoc($res))
                            {
                                //get the values from individual colums
                                $id = $row['id'];
                                $title = $row['title'];
                                $price = $row['price'];
                                $image_name = $row['image_name'];
                                $featured = $row['featured'];
                                $active = $row['active'];
                                ?>

                                <tr>
                                    <td><?php echo $sn++; ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><?php echo formatRupiah ($price); ?></td>
                                    <td>
                                        <?php 
                                            //Check whether we have image or not
                                            if($image_name=="")
                                            {
                                                //We do not have image, Display Error Message
                                                echo "<div class='error'>Gambar tidak Ada.</div>";
                                            }
                                            else
                                            {
                                                //We have Image, Display Image
                                                ?>
                                                    <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" width="100px">
                                                <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $featured; ?></td>
                                    <td><?php echo $active; ?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">Update Food</a>
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-danger">Delete Food</a>
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else
                        {
                            //Food not Added in Database
                            echo "<tr> <td colspan='7' class='error'> Produk tidak ada. </td> </tr>";
                        }
                    ?>


                </table>
    </div>
</div>

<?php include('partials/footer.php');?>