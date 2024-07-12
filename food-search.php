<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
            
                //Get the Search Keyword
                //$search = $_POST['search'];
                $search = mysqli_real_escape_string($conn, $_POST['search']);
            
            ?>
            
            <h2>Produk Yang Kamu Cari <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

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
                
                //SQL Query to Get foods based on search keyword
                //
                $sql = "SELECT * FROM tbl_food WHERE (title LIKE '%$search%' OR description LIKE '%$search%') AND active='Ya'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check whether food available of not
                if($count>0)
                {
                    //Food Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the detials
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    //Check whether image name is available or not
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
                    //Food Not Available
                    echo "<div class='error'>Makanan Tidak Tersedia.</div>";
                }

            ?>

            
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>