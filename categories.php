<?php include('partials-front/menu.php'); ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center" style="animation: slideIn 1s ease-out forwards;">Kategori</h2>

            <?php 

                //Display all the categories that are active
                //SQL Query
                $sql = "SELECT * FROM tbl_category WHERE active='Ya'";

                //Execute the Query
                $res = mysqli_query($conn, $sql);

                //Count Rows
                $count = mysqli_num_rows($res);

                //Check whether categories available or not
                if($count > 0) {
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        
                        <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3">
                                <?php 
                                    if($image_name == "") {
                                        echo "<div class='error'>Gambar Tidak Ditemukan.</div>";
                                    } else {
                                ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve">
                                <?php } ?>
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>
                        
                        <?php
                                }
                            } else {
                                echo "<div class='error'>Kategori Tidak Ditemukan.</div>";
                            }
                        ?>

            
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

<?php include('partials-front/footer.php'); ?>