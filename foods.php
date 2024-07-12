<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Produk Yang Dicari.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center" style="animation: slideIn 1s ease-out forwards;">Produk</h2>

            <?php

                // Fungsi untuk memformat harga ke dalam bentuk Rupiah
                function formatRupiah($angka) {
                    return 'Rp.' . number_format($angka, 2, ',', '.');
                }

                //Display Foods that are Active
                $sql = "SELECT * FROM tbl_food WHERE active='Ya'";

                //Execute the Query
                $res=mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check whether the foods are available or not
                if($count>0)
                {
                    //Foods Available
                    while($row=mysqli_fetch_assoc($res))
                    {
                        //Get the Values
                        $id = $row['id'];
                        $title = $row['title'];
                        $description = $row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php

                                    //Check whether image available or not
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
                                <p class="food-price"></p><?php echo formatRupiah ($price); ?></p><br>
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
                    echo "<div class='error'>Makanan Tidak Ditemukan.</div>";
                }
            ?>



            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>