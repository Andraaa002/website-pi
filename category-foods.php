<?php include('partials-front/menu.php'); ?>

<?php

    //Check whether id is passed or not
    if(isset($_GET['category_id']))
    {
        //Category id is set and get the id
        $category_id = $_GET['category_id'];
        //Get the Category Title Based on Category ID
        $sql = "SELECT title FROM tbl_category WHERE id=$category_id";

        //Execute the Query
        $res = mysqli_query($conn, $sql);

        //Get the valued from Databas
        $row = mysqli_fetch_assoc($res);
        //Get the Title
        $category_title = $row['title'];
    }
    else
    {
        //Category not passed
        //Redirect to Hame Page
        header('location:'.SITEURL);
    }
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Produk Dalam Kategori <a href="#" class="text-white">"<?php echo $category_title; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Produk</h2>

            <?php

                // Fungsi untuk memformat harga ke dalam bentuk Rupiah
                function formatRupiah($angka) {
                    return 'Rp.' . number_format($angka, 2, ',', '.');
                }
                            
                //Create SQL QUery to get Foods based on Selected Category
                $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id AND active='Ya'";

                //Execute the Query
                $res2 = mysqli_query($conn, $sql2);

                //Count the Rows
                $count2 = mysqli_num_rows($res2);

                //Check whether food is available or not
                if($count2>0)
                {
                    //Food is Available
                    while($row2=mysqli_fetch_assoc($res2))
                    {
                        $id = $row2['id'];
                        $title = $row2['title'];
                        $price = $row2['price'];
                        $description = $row2['description'];
                        $image_name = $row2['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name=="")
                                    {
                                        //Image not Available
                                        echo "<div class='error'>Gambar Tidak Tersedia.</div>";
                                    }
                                    else
                                    {
                                        //Image Available
                                        ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?> 

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo formatRupiah ($price); ?></p>
                                <p class="food-detail">
                                    <?php echo $description; ?>
                                </p>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Pesan Sekarang</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    //Food not Available
                    echo "<div class='error'>Makanan Tidak Tersedia.</div>";
                }

            ?>


            <div class="clearfix"></div>


        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>